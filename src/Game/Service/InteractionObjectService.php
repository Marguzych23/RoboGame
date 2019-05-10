<?php


namespace App\Game\Service;


use App\Game\Model\InteractionObject\HealthAchievement\HealthAchievement;
use App\Game\Model\InteractionObject\InteractionObject;
use App\Game\Model\InteractionObject\Weapon\Weapon;

class InteractionObjectService
{
    public function isArmor(InteractionObject $interactionObject)
    {
        return false;
    }

    public function isHealthAchievement(InteractionObject $interactionObject)
    {
        return false;
    }

    public function isWeapon(InteractionObject $interactionObject)
    {
        return false;
    }

    public function getWeapon(InteractionObject $interactionObject): Weapon
    {

    }

    public function getHealthAchievement(InteractionObject $interactionObject): HealthAchievement
    {

    }

}