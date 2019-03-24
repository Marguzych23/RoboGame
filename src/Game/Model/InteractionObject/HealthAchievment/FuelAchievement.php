<?php


namespace App\Game\Model\InteractionObject\HealthAchievement;


class FuelAchievement extends HealthAchievement
{
    const NAME = 'Топливо';
    const VALUE = 100;

    public function __construct()
    {
        parent::setAchieveName(self::NAME);
        parent::setAchieveValue(self::VALUE);
    }
}