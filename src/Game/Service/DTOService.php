<?php


namespace App\Game\Service;


use App\Game\DTO\CoordinatesDTO;
use App\Game\DTO\DeadAreaDTO;
use App\Game\DTO\InteractionObjectDTO;
use App\Game\DTO\LocationDTO;
use App\Game\DTO\RobotDTO;
use App\Game\DTO\RobotViewedDeadAreaDTO;
use App\Game\Model\Coordinates;
use App\Game\Model\Game;
use App\Game\Model\InteractionObject\InteractionObject;
use App\Game\Model\Location\Location;
use App\Game\Model\Robot;
use App\Game\Model\Trap\SystemFailure;

class DTOService
{
    /** @var CoordinatesService $coordinatesService */
    protected $coordinatesService;

    /**
     * DTOService constructor.
     * @param CoordinatesService|null $coordinatesService
     */
    public function __construct(CoordinatesService $coordinatesService = null)
    {
        if (is_null($coordinatesService)) {
            $coordinatesService = new CoordinatesService();
        }
        $this->coordinatesService = $coordinatesService;
    }

    /**
     * @param Robot $robot
     * @param Game $game
     * @return RobotViewedDeadAreaDTO
     */
    public function getRobotViewedDeadAreaDTOForRobot(Robot $robot, Game $game)
    {
        $robotDTO = $this->getRobotDTO($robot);

        $tempAreaSize = RobotViewedDeadAreaDTO::START_AREA_SIZE;
        if (!is_null($robot->getTrap()) && $robot->getTrap()->getName() === SystemFailure::NAME) {
            $tempAreaSize = RobotViewedDeadAreaDTO::SYSTEM_FAILURE_AREA_SIZE;
        }

        $startX = $robot->getCoordinates()->getY() - (($tempAreaSize - 1) / 2);
        $startY = $robot->getCoordinates()->getY() - (($tempAreaSize - 1) / 2);
        $viewedAreaStartCoordinates = new Coordinates($startX, $startY);
        $viewedAreaStartCoordinatesDTO = $this->getCoordinatesDTO($viewedAreaStartCoordinates);

        $interactionObjectsDTO = array();
        foreach ($game->getDeadArea()->getInteractionObjects() as $interactionObject) {
            if ($this->coordinatesService->checkCoordinatesOnZone(
                $interactionObject->getCoordinates(),
                $viewedAreaStartCoordinates,
                $tempAreaSize)
            ) {
                array_push($interactionObjectsDTO, $this->getInteractionObjectDTO($interactionObject));
            }
        }

        $opponentsRobotsDTO = array();
        foreach ($game->getDeadArea()->getRobots() as $opponentRobot) {
            if (($opponentRobot->getAuthorNickName() !== $robot->getAuthorNickName())
                && ($this->coordinatesService->checkCoordinatesOnZone(
                    $opponentRobot->getCoordinates(),
                    $viewedAreaStartCoordinates,
                    $tempAreaSize))
            ) {
                array_push($opponentsRobotsDTO, $this->getRobotDTO($opponentRobot));
            }
        }

        $locationsDTO = array();
        foreach ($game->getDeadArea()->getLocations() as $location) {
            if ($this->coordinatesService->checkCoordinatesOnZone(
                $viewedAreaStartCoordinates,
                $location->getStartCoordinates(),
                $location->getSize())
            ) {
                $tempX = ($location->getStartCoordinates()->getX() > $viewedAreaStartCoordinates->getX())
                    ? $location->getStartCoordinates()->getX()
                    : $viewedAreaStartCoordinates->getX();
                $tempY = ($location->getStartCoordinates()->getY() > $viewedAreaStartCoordinates->getY())
                    ? $location->getStartCoordinates()->getY()
                    : $viewedAreaStartCoordinates->getY();
                $tempStartLocationCoordinates = new Coordinates($tempX, $tempY);
                $tempX = (($location->getStartCoordinates()->getX() + $location->getSize()) < ($viewedAreaStartCoordinates->getX() + $tempAreaSize - 1))
                    ? ($location->getStartCoordinates()->getX() + $location->getSize())
                    : ($viewedAreaStartCoordinates->getX() + $tempAreaSize - 1);
                $tempY = (($location->getStartCoordinates()->getY() + $location->getSize()) < ($viewedAreaStartCoordinates->getY() + $tempAreaSize - 1))
                    ? ($location->getStartCoordinates()->getY() + $location->getSize())
                    : ($viewedAreaStartCoordinates->getY() + $tempAreaSize - 1);
                $tempEndLocationCoordinates = new Coordinates($tempX, $tempY);
                $tempLocation = new Location($tempStartLocationCoordinates, $location->getName(), $location->getSize());
                array_push($locationsDTO, $this->getLocationDTO($tempLocation, $tempEndLocationCoordinates));
            }
        }

        return new RobotViewedDeadAreaDTO(
            $viewedAreaStartCoordinatesDTO,
            $robotDTO,
            $tempAreaSize,
            $interactionObjectsDTO,
            $opponentsRobotsDTO,
            $locationsDTO
        );
    }

    /**
     * @param InteractionObject $interactionObject
     * @return InteractionObjectDTO
     */
    public function getInteractionObjectDTO(InteractionObject $interactionObject)
    {
        return new InteractionObjectDTO(
            $this->getCoordinatesDTO($interactionObject->getCoordinates()),
            $interactionObject->getName()
        );
    }

    /**
     * @param Robot $robot
     * @return RobotDTO
     */
    public function getRobotDTO(Robot $robot)
    {
        return new RobotDTO(
            $this->getCoordinatesDTO($robot->getCoordinates()),
            $robot->getAuthorNickName(),
            $robot->getHealth()->getValue(),
            $robot->getScript()->getCode()
        );
    }

    /**
     * @param Location $location
     * @param Coordinates $endCoordinates
     * @return LocationDTO
     */
    public function getLocationDTO(Location $location, Coordinates $endCoordinates = null)
    {
        return new LocationDTO(
            $this->getCoordinatesDTO($location->getStartCoordinates()),
            $location->getName(),
            $location::SIZE,
            $endCoordinates
        );
    }

    public function getDeadAreaDTO(Game $game)
    {
        $locationsDTO = array();
        $robotsDTO = array();
        $interactionObjectsDTO = array();

        foreach ($game->getRobots() as $robot) {
            array_push($robotsDTO, $this->getRobotDTO($robot));
        }
        foreach ($game->getDeadArea()->getLocations() as $location) {
            array_push($locationsDTO, $this->getLocationDTO($location));
        }
        foreach ($game->getDeadArea()->getInteractionObjects() as $interactionObject) {
            array_push($interactionObjectsDTO, $this->getInteractionObjectDTO($interactionObject));
        }

        return new DeadAreaDTO(
            $interactionObjectsDTO,
            $robotsDTO,
            $locationsDTO
        );
    }

    /**
     * @param Coordinates $coordinates
     * @return CoordinatesDTO
     */
    public function getCoordinatesDTO(Coordinates $coordinates)
    {
        return new CoordinatesDTO($coordinates->getX(), $coordinates->getY());
    }

}