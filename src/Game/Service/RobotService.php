<?php


namespace App\Game\Service;


use App\Game\Model\Health;
use App\Game\Model\InteractionObject\Armor\Armor;
use App\Game\Model\InteractionObject\HealthAchievement\HealthAchievement;
use App\Game\Model\InteractionObject\Trap\CongestionZone;
use App\Game\Model\InteractionObject\Trap\SystemFailure;
use App\Game\Model\InteractionObject\Trap\Trap;
use App\Game\Model\InteractionObject\Weapon\Weapon;
use App\Game\Model\Location;
use App\Game\Model\Robot;
use App\Game\Model\Script;

class RobotService
{
    /** @var ScriptService $scriptService */
    protected $scriptService;

    /**
     * RobotService constructor.
     * @param ScriptService $scriptService
     */
    public function __construct(ScriptService $scriptService)
    {
        $this->scriptService = $scriptService;
    }

    public function createRobot(string $code, array $coordinates): Robot
    {
        return new Robot(new Script($code), $coordinates);
    }

    /**
     * @param Robot $robot
     * @return bool
     */
    public function robotIsCorrect(Robot &$robot)
    {
//        TODO
        return true;
    }

    /**
     * @param Robot $robot
     * @param array $opponentsArray
     * @return array
     */
    public function getNextRobotStep(Robot &$robot, array $opponentsArray = array())
    {
        if (!$this->robotHasTrap($robot, CongestionZone::NAME)) {
            return $this->scriptService->getNextRobotStep($robot, $opponentsArray);
        }
        return array();
    }

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
        $robot->setLocation($location);
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
}