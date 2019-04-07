<?php


namespace App\Game\Service;


use App\Game\Model\Game;

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
     * @param string $code
     * @return bool
     */
    public function setRobot(string $code)
    {
        $result = false;
        if ($this->robotService->robotScriptCodeIsCorrect($code)) {
            $robot = $this->robotService->createRobot($code, $this->locationService->generateLocationForRobot());
            if ($this->getGame()->setRobot($robot) > 0) {
                $result = true;
            }
        }
        return $result;
    }
}