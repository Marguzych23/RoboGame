<?php


namespace App\Game\Service;


use App\Game\Model\Coordinates;
use App\Game\Model\Game;
use App\Game\Model\DeadArea;
use App\Game\Model\Health;
use App\Game\Model\InteractionObject\Armor\Armor;
use App\Game\Model\InteractionObject\HealthAchievement\FuelAchievement;
use App\Game\Model\InteractionObject\HealthAchievement\GreaseAchievement;
use App\Game\Model\InteractionObject\Weapon\AztecSpear;
use App\Game\Model\InteractionObject\Weapon\ElectricStaff;
use App\Game\Model\InteractionObject\Weapon\Machete;
use App\Game\Model\InteractionObject\Weapon\SwirlWhip;
use App\Game\Model\Location\DesertArea;
use App\Game\Model\Location\ElectricEarth;
use App\Game\Model\Location\RainJungle;
use App\Game\Model\Robot;
use App\Game\Model\Script;
use App\Game\Model\Trap\Breakdown;
use App\Game\Model\Trap\CongestionZone;
use App\Game\Model\Trap\SystemFailure;

class GameInstanceService
{
//    for server
    const GAME_FILE_WITH_PATH_FOR_SERVER = '/../../data/game.json';
//    for local
    const GAME_FILE_WITH_PATH_FOR_LOCAL = '\..\..\..\data\game.json';

    protected $filePath;
    protected $fopen;
    protected $fileMode = 'r+';

    /**
     * GameInstanceService constructor.
     */
    public function __construct()
    {
        if (strpos($_SERVER['SERVER_NAME'], '127.0')) {
            $this->filePath = __DIR__ . self::GAME_FILE_WITH_PATH_FOR_LOCAL;
        } else  {
            print_r($_SERVER['SERVER_NAME']);
            $this->filePath = __DIR__ . self::GAME_FILE_WITH_PATH_FOR_SERVER;
        }
    }

    /**
     * @param Game $game
     * @return bool|int
     */
    public function saveGame(Game $game)
    {
        return file_put_contents($this->filePath, json_encode($game, JSON_UNESCAPED_UNICODE));
    }

    /**
     * @return Game|null
     */
    public function getGame()
    {
        $result = file_get_contents($this->filePath);
        $game = json_decode($result, true);
        if (isset($game['deadArea'])) {
            $deadArea = $game['deadArea'];
            $locationsArray = array();
            $robotsArray = array();
            $interactionObjectsArray = array();
            $trapsArray = array();

            // Convert locations
            if (isset($deadArea['locations'])) {
                foreach ($deadArea['locations'] as $location) {
                    $locationObject = null;
                    $coordinates = new Coordinates($location['startCoordinates']['x'], $location['startCoordinates']['y']);
                    switch ($location['name']) {
                        case DesertArea::NAME:
                            {
                                $locationObject = new DesertArea($coordinates);
                                break;
                            }
                        case ElectricEarth::NAME:
                            {
                                $locationObject = new ElectricEarth($coordinates);
                                break;
                            }
                        case RainJungle::NAME:
                            {
                                $locationObject = new RainJungle($coordinates);
                                break;
                            }
                    }
                    array_push($locationsArray, $locationObject);
                }
            }

            // Convert robots
            if (isset($deadArea['robots'])) {
                foreach ($deadArea['robots'] as $robot) {
                    $robotObject = null;

                    $coordinates = new Coordinates($robot['coordinates']['x'], $robot['coordinates']['y']);

                    $authorNickName = $robot['authorNickName'];

                    $script = new Script($robot['script']['code']);

                    $health = null;
                    if (isset($robot['health']['value'])) {
                        $health = new Health($robot['health']['value']);
                    }

                    $weapons = array();
                    $weaponsArray = $robot['weapons'];
                    foreach ($weaponsArray as $weapon) {
                        $weaponObject = null;
                        $weaponCoordinates = new Coordinates($weapon['coordinates']['x'], $weapon['coordinates']['y']);
                        switch ($weapon['name']) {
                            case AztecSpear::NAME:
                                {
                                    $weaponObject = new AztecSpear($weaponCoordinates);
                                    break;
                                }
                            case ElectricStaff::NAME:
                                {
                                    $weaponObject = new ElectricStaff($weaponCoordinates);
                                    break;
                                }
                            case Machete::NAME:
                                {
                                    $weaponObject = new Machete($weaponCoordinates);
                                    break;
                                }
                            case SwirlWhip::NAME:
                                {
                                    $weaponObject = new SwirlWhip($weaponCoordinates);
                                    break;
                                }
                        }

                        array_push($weapons, $weaponObject);
                    }

                    $armor = new Armor(new Coordinates($robot['coordinates']['x'], $robot['coordinates']['y']), $robot['armor']['value']);

                    $locationObject = null;
                    if (!is_null($robot['location'])) {
                        $location = $robot['location'];
                        $locationCoordinates = new Coordinates($location['startCoordinates']['x'], $location['startCoordinates']['y']);
                        switch ($location['name']) {
                            case DesertArea::NAME:
                                {
                                    $locationObject = new DesertArea($locationCoordinates);
                                    break;
                                }
                            case ElectricEarth::NAME:
                                {
                                    $locationObject = new ElectricEarth($locationCoordinates);
                                    break;
                                }
                            case RainJungle::NAME:
                                {
                                    $locationObject = new RainJungle($locationCoordinates);
                                    break;
                                }
                        }
                    }

                    $onLocation = !is_null($robot['onLocation']) ? $robot['onLocation'] : 0;

                    $trapsObject = null;
                    if (!is_null($robot['trap'])) {
                        $trap = $robot['trap'];
                        $timeOfAction = $trap['actionTime'];
                        $trapCoordinates = new Coordinates($trap['coordinates']['x'], $trap['coordinates']['y']);
                        switch ($trap['name']) {
                            case Breakdown::NAME:
                                {
                                    $trapsObject = new Breakdown($trapCoordinates, $timeOfAction);
                                    break;
                                }
                            case CongestionZone::NAME:
                                {
                                    $trapsObject = new CongestionZone($trapCoordinates, $timeOfAction);
                                    break;
                                }
                            case SystemFailure::NAME:
                                {
                                    $trapsObject = new SystemFailure($trapCoordinates, $timeOfAction);
                                    break;
                                }
                        }
                    }

                    array_push(
                        $robotsArray,
                        new Robot(
                            $authorNickName,
                            $script,
                            $coordinates,
                            $health,
                            $weapons,
                            $armor,
                            $locationObject,
                            $trapsObject,
                            $onLocation
                        )
                    );
                }
            }

            // Convert interactionObjects
            if (isset($deadArea['interactionObjects'])) {
                foreach ($deadArea['interactionObjects'] as $interactionObject) {
                    $interactionObjectObject = null;
                    $interactionObjectCoordinates = new Coordinates($interactionObject['coordinates']['x'], $interactionObject['coordinates']['y']);

                    switch ($interactionObject['name']) {
                        case AztecSpear::NAME:
                            {
                                $interactionObjectObject = new AztecSpear($interactionObjectCoordinates);
                                break;
                            }
                        case ElectricStaff::NAME:
                            {
                                $interactionObjectObject = new ElectricStaff($interactionObjectCoordinates);
                                break;
                            }
                        case Machete::NAME:
                            {
                                $interactionObjectObject = new Machete($interactionObjectCoordinates);
                                break;
                            }
                        case SwirlWhip::NAME:
                            {
                                $interactionObjectObject = new SwirlWhip($interactionObjectCoordinates);
                                break;
                            }
                        case GreaseAchievement::NAME:
                            {
                                $interactionObjectObject = new GreaseAchievement($interactionObjectCoordinates);
                                break;
                            }
                        case FuelAchievement::NAME:
                            {
                                $interactionObjectObject = new FuelAchievement($interactionObjectCoordinates);
                                break;
                            }
                        case Armor::NAME:
                            {
                                $interactionObjectObject = new Armor($interactionObjectCoordinates);
                                break;
                            }
                    }

                    array_push(
                        $interactionObjectsArray,
                        $interactionObjectObject
                    );
                }
            }

            // Convert traps
            if (isset($deadArea['traps'])) {
                foreach ($deadArea['traps'] as $trap) {

                    $trapsObject = null;
                    $trapCoordinates = new Coordinates($trap['coordinates']['x'], $trap['coordinates']['y']);
                    switch ($trap['name']) {
                        case Breakdown::NAME:
                            {
                                $trapsObject = new Breakdown($trapCoordinates);
                                break;
                            }
                        case CongestionZone::NAME:
                            {
                                $trapsObject = new CongestionZone($trapCoordinates);
                                break;
                            }
                        case SystemFailure::NAME:
                            {
                                $trapsObject = new SystemFailure($trapCoordinates);
                                break;
                            }
                    }
                    array_push($trapsArray, $trapsObject);
                }
            }

            return new Game(
                new DeadArea(
                    $locationsArray,
                    $robotsArray,
                    $interactionObjectsArray,
                    $trapsArray,
                    $deadArea['currentStepAreaSize']
                ),
                $game['gameStepNumber']
            );
        }
        return null;
    }

    /**
     * @return bool
     */
    public function checkGame()
    {
        $result = file_get_contents($this->filePath);
        return strlen($result) !== 0;
    }

    /**
     * @return bool|int
     */
    public function deleteGame()
    {
        return file_put_contents($this->filePath, '');
    }

}