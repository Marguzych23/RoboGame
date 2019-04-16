<?php


namespace App\Game\Service;


use App\Game\DTO\CoordinatesDTO;
use App\Game\DTO\InteractionObjectDTO;
use App\Game\DTO\LocationDTO;
use App\Game\DTO\RobotDTO;
use App\Game\Model\Coordinates;
use App\Game\Model\Game;
use App\Game\Model\InteractionObject\Trap\Breakdown;
use App\Game\Model\Step;

class GameService
{
    /** @var Game $game */
    protected static $game = null;

    /** var RobotService $robotService */
    protected $robotService;
    /** var LocationService $locationService */
    protected $locationService;
    /** var DeadAreaService $deadAreaService */
    protected $deadAreaService;

    public function __construct()
    {
        $this->locationService = new LocationService();
        $this->deadAreaService = new DeadAreaService();
        $this->robotService = new RobotService(new ScriptService());
        self::$game = $this->getGame();
    }

    /**
     * @throws \Exception
     */
    public function getNextStepGame()
    {
        $game = $this->getGame();
//        $robots = $game->getRobots();
//        /** @var Step[] $steps */
//        $steps = array();
//        foreach ($robots as $robot) {
//            $step = $this->robotService->getNextRobotStep($robot);
//            if (is_null($step->getDestination())) {
////                TODO
//                throw new \Exception("Error");
//            }
//            array_push($steps, $step);
//            if (($target = $step->getTarget())->getY() !== -1) {
//                foreach ($robots as $tRobot) {
//                    if (($tRobot->getCoordinates()->getX() === $target->getX())
//                        && ($tRobot->getCoordinates()->getY() === $target->getY())) {
//                        $this->robotService->useWeapon($robot, $tRobot);
//                    }
//                }
//            }
//        }
//        for ($i = 0; $i < count($robots); $i++) {
//            $this->robotService->useTrapIfThisExist($robots[$i]);
//            foreach ($game->getDeadArea()->getInteractionObjects() as $interactionObject) {
//                if (($interactionObject->getCoordinates()->getX() === $steps[$i]->getDestination()->getX())
//                    && ($interactionObject->getCoordinates()->getY() === $steps[$i]->getDestination()->getY())) {
//
//                }
//            }
//            $this->robotService->useHealthAchieve($robot);
//        }
        return $game;
    }

    /**
     * @return Game
     */
    public function getGame()
    {
        if (is_null(self::$game)) {
            $locations = $this->locationService->generateLocationsForArea();

            self::$game = new Game(
                $this->deadAreaService->generateDeadArea(
                    $locations,
                    array(),
                    $this->locationService->generateInteractionObjects($locations)
                )
            );
        }
        return self::$game;
    }

    /**
     * @param string $nickName
     * @param string $script
     * @return bool
     */
    public function setRobot(string $nickName, string $script)
    {
        $result = false;
        if ($this->robotService->robotScriptCodeIsCorrect($script)) {
            $robot = $this->robotService->createRobot($nickName, $script, $this->locationService->generateLocationForRobot());
            if ($this->getGame()->setRobot($robot) > 0) {
                $result = true;
            }
        }
        return $result;
    }

    public function getGameDTO(Game $game)
    {
        $locationsDTO = array();
        $robotsDTO = array();
        $interactionObjectsDTO = array();

        foreach ($game->getRobots() as $robot) {
            array_push($robotsDTO,
                new RobotDTO(
                    $this->getCoordinatesDTO($robot->getCoordinates()),
                    $robot->getAuthorNickName(),
                    $robot->getHealth()
                )
            );
        }
        foreach ($game->getDeadArea()->getLocations() as $location) {
            array_push($locationsDTO,
                new LocationDTO(
                    $this->getCoordinatesDTO($location->getStartCoordinates()),
                    $location->getName(),
                    $location::SIZE
                )
            );
        }
        foreach ($game->getDeadArea()->getInteractionObjects() as $interactionObject) {
            array_push($interactionObjectsDTO,
                new InteractionObjectDTO(
                    $this->getCoordinatesDTO($interactionObject->getCoordinates()),
                    $interactionObject->getName()
                )
            );
        }
    }

    private function getCoordinatesDTO(Coordinates $coordinates)
    {
        return new CoordinatesDTO($coordinates->getX(), $coordinates->getY());
    }
}