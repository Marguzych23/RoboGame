<?php


namespace App\Game\Service;


use App\Game\DTO\CoordinatesDTO;
use App\Game\DTO\DeadAreaDTO;
use App\Game\DTO\InteractionObjectDTO;
use App\Game\DTO\LocationDTO;
use App\Game\DTO\RobotDTO;
use App\Game\Model\Coordinates;
use App\Game\Model\Game;
use App\Game\Model\InteractionObject\InteractionObject;
use App\Game\Model\Location\Location;
use App\Game\Model\Robot;

class DTOService
{
    /**
     * DTOService constructor.
     */
    public function __construct()
    {
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
     * @return LocationDTO
     */
    public function getLocationDTO(Location $location)
    {
        return new LocationDTO(
            $this->getCoordinatesDTO($location->getStartCoordinates()),
            $location->getName(),
            $location::SIZE
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