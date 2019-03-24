<?php


namespace App\Game\Model\InteractionObject\HealthAchievement;


class GreaseAchievement extends HealthAchievement
{
    const NAME = 'Смазка';
    const VALUE = 80;

    public function __construct()
    {
        parent::setAchieveName(self::NAME);
        parent::setAchieveValue(self::VALUE);
    }
}