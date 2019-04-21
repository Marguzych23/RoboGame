<?php


namespace App\Game\Service;


use App\Game\DTO\DeadAreaDTO;
use App\Game\Model\Game;
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

    /**
     * GameService constructor.
     */
    public function __construct()
    {
        $this->dtoService = new DTOService();
        $this->coordinatesService = new CoordinatesService();
        $this->locationService = new LocationService($this->coordinatesService);
        $this->robotService = new RobotService(new ScriptService(), $this->coordinatesService);
        $this->deadAreaService = new DeadAreaService($this->locationService, $this->robotService, $this->coordinatesService);
        self::$game = $this->getGame();
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
            $step = $this->robotService->getNextRobotStep($this->dtoService->getRobotViewedDeadAreaDTOForRobot($robot, $game));
            if (is_null($step->getDestination())) {
                throw new \Exception("Error");
            }
            array_push($steps, $step);
            if (($target = $step->getTarget())->getY() !== -1) {
                foreach ($robots as $tRobot) {
                    if (($tRobot->getCoordinates()->getX() === $target->getX())
                        && ($tRobot->getCoordinates()->getY() === $target->getY())) {
                        $this->robotService->useWeapon($robot, $tRobot);
                    }
                }
            }
        }
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
            $locations = $this->deadAreaService->generateLocationsForArea();

            self::$game = new Game(
                $this->deadAreaService->generateDeadArea(
                    $locations,
                    array(),
                    $this->deadAreaService->generateInteractionObjects($locations),
                    $this->deadAreaService->generateTraps()
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
            $robot = $this->robotService->createRobot($nickName, $script, $this->deadAreaService->generateCoordinatesForRobot());
            if ($this->getGame()->setRobot($robot) > 0) {
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