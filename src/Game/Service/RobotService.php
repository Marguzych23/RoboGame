<?php


namespace App\Game\Service;


use App\Game\DTO\RobotViewedDeadAreaDTO;
use App\Game\Model\Coordinates;
use App\Game\Model\DeadArea;
use App\Game\Model\Health;
use App\Game\Model\InteractionObject\Armor\Armor;
use App\Game\Model\InteractionObject\HealthAchievement\HealthAchievement;
use App\Game\Model\InteractionObject\InteractionObject;
use App\Game\Model\Trap\Breakdown;
use App\Game\Model\Trap\CongestionZone;
use App\Game\Model\Trap\SystemFailure;
use App\Game\Model\Trap\Trap;
use App\Game\Model\InteractionObject\Weapon\Weapon;
use App\Game\Model\Location\Location;
use App\Game\Model\Robot;
use App\Game\Model\Script;
use App\Game\Model\Step;

class RobotService
{
    /** @var ScriptService $scriptService */
    protected $scriptService;

    /** @var CoordinatesService $coordinatesService */
    protected $coordinatesService;

    /** @var InteractionObjectService $interactionObjectService */
    protected $interactionObjectService;

    /** @var array $defaultRobotNames */
    protected $defaultRobotNames = array();

    /**
     * RobotService constructor.
     * @param ScriptService $scriptService
     * @param CoordinatesService $coordinatesService
     * @param InteractionObjectService $interactionObjectService
     */
    public function __construct(ScriptService $scriptService, CoordinatesService $coordinatesService, InteractionObjectService $interactionObjectService)
    {
        $this->scriptService = $scriptService;
        $this->coordinatesService = $coordinatesService;
        $this->interactionObjectService = $interactionObjectService;
    }

//    Default methods end

    /**
     * @param string $nickName
     * @param string $script
     * @param Coordinates $coordinates
     * @return Robot
     */
    public function createRobot(string $nickName, string $script, Coordinates $coordinates): Robot
    {
        return new Robot($nickName, new Script($script), $coordinates);
    }

    /**
     * @param string $script
     * @return bool
     */
    public function robotScriptCodeIsCorrect(string $script)
    {
        return $this->scriptService->robotScriptCodeIsCorrect($script);
    }

    /**
     * @param Robot $robot
     * @param RobotViewedDeadAreaDTO $robotViewedDeadAreaDTO
     * @return Step
     */
    public function getNextRobotStep(Robot $robot, RobotViewedDeadAreaDTO $robotViewedDeadAreaDTO)
    {
        if (!($this->robotHasTrap($robot, CongestionZone::NAME) && $this->robotHasTrap($robot, Breakdown::NAME))) {
            if ($this->robotIsDefault($robot)) {
                return $this->getNextDefaultRobotStep($robot, $robotViewedDeadAreaDTO);
            } else {
                return $this->scriptService->getNextRobotStep($robotViewedDeadAreaDTO);
            }
        } else {
            return new Step($robot->getCoordinates());
        }
    }

    /**
     * @param Robot $robot
     * @return bool
     */
    public function robotIsDead(Robot &$robot)
    {
        if ($robot->getHealth()->getValue() <= Health::MIN_VALUE) {
            return true;
        }
        return false;
    }
//    Default methods end

//    Methods with interactionObjects start
    /**
     * @param InteractionObject $interactionObject
     * @param Robot $robot
     */
    public function setInteractionObjectForRobot(InteractionObject $interactionObject, Robot $robot)
    {
        if ($this->interactionObjectService->isArmor($interactionObject)) {
            $this->updateArmor($robot);
        } elseif ($this->interactionObjectService->isWeapon($interactionObject)) {
            $this->setWeaponForRobot(
                $robot,
                $this->interactionObjectService->getWeapon($interactionObject)
            );
        } elseif ($this->interactionObjectService->isHealthAchievement($interactionObject)) {
            $this->useHealthAchievement(
                $robot,
                $this->interactionObjectService->getHealthAchievement($interactionObject)
            );
        }
    }
//    Methods with interactionObjects end

//    Methods with health start
//    public function useHealthAchieveIfThisNeeded(Robot $robot)
//    {
//        if (($robot->getHealth()->getValue() < Health::START_VALUE)
//            && ($robot->)) {
//
//        }
//    }

    /**
     * @param Robot $robot
     * @param HealthAchievement $healthAchievement
     */
    public function useHealthAchievement(Robot &$robot, HealthAchievement $healthAchievement)
    {
        $robotHealth = $robot->getHealth();
        $robotHealth->setValue($robot->getHealth()->getValue() + $healthAchievement->getAchieveValue());
        $robot->setHealth($robotHealth);
    }
//    Methods with health end

//    Methods with armor start
    /**
     * @param Robot $robot
     */
    public function updateArmor(Robot &$robot)
    {
        $armor = $robot->getArmor();
        $armor->setValue($robot->getArmor()->getValue() + $robot->getArmor()::ITERATION_VALUE);
        $robot->setArmor($armor);
    }
//    Methods with armor end

//    Methods with weapons start
    /**
     * @param Robot $robot
     * @param Weapon $weapon
     */
    public function useWeaponAgainstRobot(Robot &$robot, Weapon $weapon)
    {
        $weaponDamageValue = $weapon->getWeaponDamage();
        $robotArmor = $robot->getArmor();
        if ($robotArmor->getValue() > Armor::MIN_VALUE) {
            $robotArmorNewValue = $robotArmor->getValue() - $weaponDamageValue;
            $robotArmor->setValue($robotArmorNewValue);
            $robot->setArmor($robotArmor);
            if ($robotArmorNewValue <= 0) {
                $weaponDamageValue = -$robotArmorNewValue;
            }
        }
        if ($weaponDamageValue > 0) {
            $robotHealth = $robot->getHealth();
            $robotHealth->setValue($robot->getHealth()->getValue() - $weaponDamageValue);
            $robot->setHealth($robotHealth);
        }
    }

    /**
     * Пока используется первое оружие из списка
     * @param Robot $used
     * @param Robot $against
     */
    public function useWeapon(Robot &$used, Robot &$against)
    {
        if ($this->robotHasWeapon($used) && ($used->getTrap()->getName() !== CongestionZone::NAME)) {
            $maxDamageWeaponValue = 0;
            $maxDamageWeaponIndex = -1;
            for ($i = 0; $i < count($used->getWeapons()); $i++) {
                if ($maxDamageWeaponValue < $used->getWeapons()[$i]->getWeaponDamage()) {
                    $maxDamageWeaponValue = $used->getWeapons()[$i]->getWeaponDamage();
                    $maxDamageWeaponIndex = $i;
                }
            }
            $weapon = $used->getWeapons()[$maxDamageWeaponIndex];
            $this->useWeaponAgainstRobot($against, $weapon);
            array_splice($used->getWeapons(), $maxDamageWeaponIndex, 1);
        }
    }

    /**
     * @param Robot $robot
     * @return bool
     */
    public function robotHasWeapon(Robot &$robot)
    {
        return count($robot->getWeapons()) > 0;
    }

    /**
     * @param Robot $robot
     * @param Weapon $weapon
     */
    public function setWeaponForRobot(Robot &$robot, Weapon $weapon)
    {
        $weapons = $robot->getWeapons();
        array_push($weapons, $weapon);
        $robot->setWeapons($weapons);
    }
//    Methods with weapons end

//    Methods with locations start
    /**
     * @param Robot $robot
     * @param Location $location
     */
    public function setLocationForRobot(Robot &$robot, Location $location)
    {
        if (!$this->robotHasTrap($robot, Breakdown::NAME)) {
            $robot->setLocation($location);
        }
    }
//    Methods with locations end

//    Methods with traps start
    /**
     * @param Robot $robot
     * @param Trap $trap
     */
    public function setTrapForRobot(Robot &$robot, Trap $trap)
    {
        $robot->setTrap($trap);
    }

    /**
     * @param Robot $robot
     * @param string $trapName
     * @return bool
     */
    public function robotHasTrap(Robot &$robot, string $trapName = null)
    {
        if (is_null($robot->getTrap())) {
            return false;
        } elseif (is_null($trapName)) {
            return ($robot->getTrap()->getActionTime() > 0);
        }
        return ($robot->getTrap()->getActionTime() > 0) && ($trapName === $robot->getTrap()->getName());
    }

    /**
     * @param Robot $robot
     */
    public function changeTrapActionTime(Robot &$robot)
    {
        if ($this->robotHasTrap($robot)) {
            $trap = $robot->getTrap();
            $newActionTime = $trap->getActionTime();
            $newActionTime--;
            if ($newActionTime === 0) {
                $trap = null;
            } else {
                $trap->setActionTime($newActionTime);
            }
            $robot->setTrap($trap);
        }
    }

    /**
     * @param Robot $robot
     */
    public function useTrapIfThisExist(Robot $robot)
    {
        if ($this->robotHasTrap($robot)) {
            if ($this->robotHasTrap($robot, Breakdown::NAME) && $robot->getTrap()->getActionTime() === Breakdown::TIME_OF_ACTION) {
                $robot->getArmor()->setValue($robot->getArmor()->getValue() * 2);
            }
        }
    }
//    Methods with traps end

//    Methods with default robot start
    /**
     * @param Robot $robot
     * @param RobotViewedDeadAreaDTO $robotViewedDeadAreaDTO
     * @return Step
     */
    public function getNextDefaultRobotStep(Robot $robot, RobotViewedDeadAreaDTO $robotViewedDeadAreaDTO)
    {
        /** @var Step $step */
        $step = new Step(null);
        if ($this->robotHasTrap($robot, Breakdown::NAME)) {
            $step->setDestination($robot->getCoordinates());
        } else {
            $x = DeadArea::START_SIZE / 2 - $robot->getCoordinates()->getX();
            $y = DeadArea::START_SIZE / 2 - $robot->getCoordinates()->getY();
            $x = ($x !== 0) ? (($x > 0) ? 1 : -1) : 0;
            $y = ($y !== 0) ? (($y > 0) ? 1 : -1) : 0;
            $step->setDestination(
                new Coordinates(
                    $robot->getCoordinates()->getX() + $x,
                    $robot->getCoordinates()->getY() + $y
                )
            );
        }
        if ($this->robotHasWeapon($robot) && !$this->robotHasTrap($robot, CongestionZone::NAME)) {
            $dest = ($this->robotHasTrap($robot, SystemFailure::NAME)) ? 1 : 2;
            foreach ($robotViewedDeadAreaDTO->getRobots() as $tempRobot) {
                $x = $tempRobot->getCoordinates()->getX() - $robot->getCoordinates()->getX();
                $y = $tempRobot->getCoordinates()->getY() - $robot->getCoordinates()->getY();
                if (
                    ($tempRobot->getName() !== $robot->getAuthorNickName())
                    && (($x <= $dest) && ($x >= -$dest))
                    && (($y <= $dest) && ($y >= -$dest))
                ) {
                    $step->setTarget(
                        new Coordinates(
                            $tempRobot->getCoordinates()->getX(),
                            $tempRobot->getCoordinates()->getY()
                        )
                    );
                    break;
                }
            }
        }
        return $step;
    }

    /**
     * @return string
     */
    public function generateDefaultRobotName(): string
    {
        $robotName = '';
        while (true) {
            $characters = '0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 4; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $robotName = 'default' . $randomString;
            if (!array_search($robotName, $this->defaultRobotNames)) {
                break;
            }
        }
        array_push($this->defaultRobotNames, $robotName);
        return $robotName;
    }

    /**
     * @param Robot $robot
     * @return bool
     */
    public function robotIsDefault(Robot $robot): bool
    {
        return array_search($robot->getAuthorNickName(), $this->defaultRobotNames) ? true : false;
    }
//    Methods with default robot end

    /**
     * @return Coordinates
     */
    public function generateCoordinatesForRobot(): Coordinates
    {
        /** @var Coordinates $tempCoordinates */
        $tempCoordinates = null;
        while (true) {
            if (is_null($tempCoordinates)) {
                $x = mt_rand(0, DeadArea::START_SIZE - 1);
                $y = mt_rand(0, DeadArea::START_SIZE - 1);
                $tempCoordinates = new Coordinates($x, $y);
                foreach ($this->coordinatesService->getOccupiedCoordinates() as $coordinate) {
                    if (($coordinate->getX() === $tempCoordinates->getX()) && $coordinate->getY() == $tempCoordinates->getY()) {
                        $tempCoordinates = null;
                    }
                }
            } else {
                break;
            }
        }
        return $tempCoordinates;
    }
}