<?php


namespace App\Game\Service;


use App\Game\DTO\DeadAreaDTO;
use App\Game\Model\Coordinates;
use App\Game\Model\DeadArea;
use App\Game\Model\Game;
use App\Game\Model\Robot;
use App\Game\Model\Step;

class GameService
{
    /** @var Game $game */
    protected static $game = null;

    /** var RobotService $robotService */
    protected $robotService;
    /** var DTOService $dtoService */
    protected $dtoService;
    /** var LocationService $locationService */
    protected $locationService;
    /** var DeadAreaService $deadAreaService */
    protected $deadAreaService;
    /** @var CoordinatesService $coordinatesService */
    protected $coordinatesService;
    /** @var InteractionObjectService $interactionObjectService */
    protected $interactionObjectService;
    /** @var GameInstanceService $gameInstanceService */
    protected $gameInstanceService;

    /**
     * GameService constructor.
     */
    public function __construct()
    {
        $this->dtoService = new DTOService();
        $this->gameInstanceService = new GameInstanceService();
        $this->coordinatesService = new CoordinatesService();
        $this->interactionObjectService = new InteractionObjectService();
        $this->locationService = new LocationService($this->coordinatesService);
        $this->robotService = new RobotService(new ScriptService(), $this->coordinatesService, $this->interactionObjectService);
        $this->deadAreaService = new DeadAreaService($this->locationService, $this->robotService, $this->coordinatesService);
    }

    /**
     * @return bool|int
     */
    public function resetGame()
    {
        return $this->gameInstanceService->deleteGame();
    }

    /**
     * @throws \Exception
     */
    public function getNextStepGame()
    {
        $game = $this->getGame();
        $robots = $game->getRobots();

        /** @var Step[] $steps */
        $steps = array();

        foreach ($robots as $robot) {
            $step = $this->robotService->getNextRobotStep($robot, $this->dtoService->getRobotViewedDeadAreaDTO($robot, $game));

            if ($step->getDestination()->getX() === 0 & $step->getDestination()->getY() === 0) {
                throw new \Exception("Destination not found");
            }

            array_push($steps, $step);

            $this->robotService->useTrapIfThisExist($robot);

            if (($target = $step->getTarget())->getY() !== -1) {
                foreach ($robots as $tRobot) {
                    if (($robot !== $tRobot) && ($tRobot->getCoordinates()->getX() === $target->getX())
                        && ($tRobot->getCoordinates()->getY() === $target->getY())) {
                        $this->robotService->useWeapon($robot, $tRobot);
                    }
                }
            }
        }

        foreach ($robots as $robot) {
            $step = array_shift($steps);
            $robot->setCoordinates(
                new Coordinates(
                    $step->getDestination()->getX(), $step->getDestination()->getY()
                )
            );
            foreach ($game->getDeadArea()->getInteractionObjects() as $interactionObject) {
                if (($interactionObject->getCoordinates()->getX() === $robot->getCoordinates()->getX())
                    && ($interactionObject->getCoordinates()->getY() === $robot->getCoordinates()->getY())
                ) {
                    $this->robotService->setInteractionObjectForRobot($interactionObject, $robot);
                    break;
                }
            }

            $noLocaltion = true;
            foreach ($game->getDeadArea()->getLocations() as $location) {
                if ($this->locationService->coordinatesInLocation($robot->getCoordinates(), $location)) {
                    $this->robotService->setLocationForRobot($robot, $location);
                    $noLocaltion = false;
                    break;
                }
            }
            if ($noLocaltion === true) {
                $this->robotService->setLocationForRobot($robot, null);
            }

            foreach ($game->getDeadArea()->getTraps() as $trap) {
                if (($trap->getCoordinates()->getX() === $robot->getCoordinates()->getX())
                    && ($trap->getCoordinates()->getY() === $robot->getCoordinates()->getY())
                ) {
                    $this->robotService->setTrapForRobot($robot, $trap);
                    break;
                }
            }
        }

        $this->gameInstanceService->saveGame($game);

        return $game;
    }

    public function gameIsStarted()
    {
        return $this->gameInstanceService->checkGame();
    }

    /**
     * @return Game
     */
    public function getGame()
    {
        if (self::$game === null && $this->gameInstanceService->checkGame() === false) {
            $locations = $this->deadAreaService->generateLocationsForArea();
            $robots = array();
            for ($i = 0; $i < 3; $i++) {
                $robotCoordinates = $this->coordinatesService->generateCoordinates(0, DeadArea::START_SIZE - 1, 0, DeadArea::START_SIZE - 1);
                $robotLocation = null;
                foreach ($locations as $location) {
                    if (
                        ($location->getStartCoordinates()->getX() <= $robotCoordinates->getX())
                        && ($location->getStartCoordinates()->getY() <= $robotCoordinates->getY())
                        && ($location->getStartCoordinates()->getX() + $location->getSize() >= $robotCoordinates->getX())
                        && ($location->getStartCoordinates()->getY() + $location->getSize() >= $robotCoordinates->getY())
                    ) {
                        $robotLocation = $location;
                    }
                }
                array_push(
                    $robots,
                    $this->robotService->createRobot(
                        $this->robotService->generateDefaultRobotName(),
                        'DEFAULT_ROBOT_CODE',
                        $robotCoordinates,
                        $robotLocation
                    )
                );
            }

            self::$game = new Game(
                $this->deadAreaService->generateDeadArea(
                    $locations,
                    $robots,
                    $this->deadAreaService->generateInteractionObjects($locations),
                    $this->deadAreaService->generateTraps()
                )
            );
            $this->gameInstanceService->saveGame(self::$game);
        } else if (self::$game === null) {
            self::$game = $this->gameInstanceService->getGame();
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
            $robotCoordinates = $this->coordinatesService->generateCoordinates(0, DeadArea::START_SIZE - 1, 0, DeadArea::START_SIZE - 1);
            $robotLocation = null;
            $locations = $this->getGame()->getDeadArea()->getLocations();
            foreach ($locations as $location) {
                if (
                    ($location->getStartCoordinates()->getX() <= $robotCoordinates->getX())
                    && ($location->getStartCoordinates()->getY() <= $robotCoordinates->getY())
                    && ($location->getStartCoordinates()->getX() + $location->getSize() >= $robotCoordinates->getX())
                    && ($location->getStartCoordinates()->getY() + $location->getSize() >= $robotCoordinates->getY())
                ) {
                    $robotLocation = $location;
                }
            }
            $robot = $this->robotService->createRobot(
                $nickName,
                $script,
                $this->deadAreaService->generateCoordinatesForRobot(),
                $robotLocation
            );
            if ($this->getGame()->setRobot($robot) > 0) {
                $this->gameInstanceService->saveGame($this->getGame());
                $result = true;
            }
        }
        return $result;
    }

    /**
     * @param Game $game
     * @return DeadAreaDTO
     */
    public function getGameDTO(Game $game)
    {
        return $this->dtoService->getDeadAreaDTO($game);
    }
}