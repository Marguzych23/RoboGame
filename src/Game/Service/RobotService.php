<?php


namespace App\Game\Service;


use App\Game\Model\Coordinates;
use App\Game\Model\DeadArea;
use App\Game\Model\Health;
use App\Game\Model\InteractionObject\Armor\Armor;
use App\Game\Model\InteractionObject\HealthAchievement\HealthAchievement;
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

    /**
     * RobotService constructor.
     * @param ScriptService $scriptService
     * @param CoordinatesService $coordinatesService
     */
    public function __construct(ScriptService $scriptService, CoordinatesService $coordinatesService)
    {
        $this->scriptService = $scriptService;
        $this->coordinatesService = $coordinatesService;
    }

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
     * @param array $opponentsArray
     * @return Step
     */
    public function getNextRobotStep(Robot &$robot, array $opponentsArray = array())
    {
        if (!$this->robotHasTrap($robot, CongestionZone::NAME)) {
            return $this->scriptService->getNextRobotStep($robot, $opponentsArray);
        }
        return new Step(null);
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
    public function useHealthAchieve(Robot &$robot, HealthAchievement $healthAchievement)
    {
        $robotHealth = $robot->getHealth();
        $robotHealth->setValue($robot->getHealth()->getValue() + $healthAchievement->getAchieveValue());
        $robot->setHealth($robotHealth);
    }

    /**
     * @param Robot $robot
     */
    public function updateArmor(Robot &$robot)
    {
        $armor = $robot->getArmor();
        $armor->setValue($robot->getArmor()->getValue() + $robot->getArmor()::ITERATION_VALUE);
        $robot->setArmor($armor);
    }

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
        if ($this->robotHasWeapon($used) && ($used->getTrap()->getName() !== SystemFailure::NAME)) {
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
     * @param Trap $trap
     */
    public function setTrapForRobot(Robot &$robot, Trap $trap)
    {
        $robot->setTrap($trap);
    }

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

    /**
     * @param Robot $robot
     * @param string $trapName
     * @return bool
     */
    public function robotHasTrap(Robot &$robot, string $trapName = null)
    {
        if (is_null($trapName)) {
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

    public function useTrapIfThisExist(Robot $robot)
    {
        if ($this->robotHasTrap($robot)) {

        }
    }


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
                foreach ($this->occupiedCoordinates as $coordinate) {
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