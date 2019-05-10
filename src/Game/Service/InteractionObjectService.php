<?php


namespace App\Game\Service;


use App\Game\Model\InteractionObject\Armor\Armor;
use App\Game\Model\InteractionObject\HealthAchievement\FuelAchievement;
use App\Game\Model\InteractionObject\HealthAchievement\GreaseAchievement;
use App\Game\Model\InteractionObject\HealthAchievement\HealthAchievement;
use App\Game\Model\InteractionObject\InteractionObject;
use App\Game\Model\InteractionObject\Weapon\AztecSpear;
use App\Game\Model\InteractionObject\Weapon\ElectricStaff;
use App\Game\Model\InteractionObject\Weapon\Machete;
use App\Game\Model\InteractionObject\Weapon\SwirlWhip;
use App\Game\Model\InteractionObject\Weapon\Weapon;

class InteractionObjectService
{
    /**
     * @param InteractionObject $interactionObject
     * @return bool
     */
    public function isArmor(InteractionObject $interactionObject)
    {
        if ($interactionObject->getName() === Armor::NAME) {
            return true;
        }
        return false;
    }

    /**
     * @param InteractionObject $interactionObject
     * @return bool
     */
    public function isHealthAchievement(InteractionObject $interactionObject)
    {
        if ($interactionObject->getName() === FuelAchievement::NAME && $interactionObject->getName() === GreaseAchievement::NAME) {
            return true;
        }
        return false;
    }

    /**
     * @param InteractionObject $interactionObject
     * @return bool
     */
    public function isWeapon(InteractionObject $interactionObject)
    {
        switch ($interactionObject->getName()) {
            case AztecSpear::NAME:
            case ElectricStaff::NAME:
            case Machete::NAME:
            case SwirlWhip::NAME:
                {
                    return true;
                }
            default:
                {
                    return false;
                }
        }
    }

    /**
     * @param InteractionObject $interactionObject
     * @return Weapon
     */
    public function getWeapon(InteractionObject $interactionObject): Weapon
    {
        switch ($interactionObject->getName()) {
            case AztecSpear::NAME:
                {
                    return new AztecSpear($interactionObject->getCoordinates());
                }
            case ElectricStaff::NAME:
                {
                    return new ElectricStaff($interactionObject->getCoordinates());
                }
            case Machete::NAME:
                {
                    return new Machete($interactionObject->getCoordinates());
                }
            case SwirlWhip::NAME:
                {
                    return new SwirlWhip($interactionObject->getCoordinates());
                }
            default:
                {
                    return null;
                }
        }
    }

    /**
     * @param InteractionObject $interactionObject
     * @return HealthAchievement
     */
    public function getHealthAchievement(InteractionObject $interactionObject): HealthAchievement
    {

        switch ($interactionObject->getName()) {
            case FuelAchievement::NAME:
                {
                    return new FuelAchievement($interactionObject->getCoordinates());
                }
            case GreaseAchievement::NAME:
                {
                    return new GreaseAchievement($interactionObject->getCoordinates());
                }
            default:
                {
                    return null;
                }
        }
    }

}