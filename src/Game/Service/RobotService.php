<?php


namespace App\Game\Service;


use App\Game\Model\Health;
use App\Game\Model\InteractionObject\Armor\Armor;
use App\Game\Model\InteractionObject\HealthAchievement\HealthAchievement;
use App\Game\Model\InteractionObject\Trap\Trap;
use App\Game\Model\InteractionObject\Weapon\Weapon;
use App\Game\Model\Robot;

class RobotService
{

    public function robotIsCorrect(Robot &$robot)
    {
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
        if ($this->robotHasWeapon($used)) {
            $weapon = array_shift($used->getWeapons());
            $this->useWeaponAgainstRobot($against, $weapon);
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

    public function useTrapAgainstRobot(Robot &$robot, Trap $trap) {

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

}