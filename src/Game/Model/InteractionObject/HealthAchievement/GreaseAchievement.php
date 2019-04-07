<?php


namespace App\Game\Model\InteractionObject\HealthAchievement;


use App\Game\Model\Coordinates;

class GreaseAchievement extends HealthAchievement
{
    const NAME = 'Смазка';
    const VALUE = 80;

    /**
     * GreaseAchievement constructor.
     * @param Coordinates $coordinates
     */
    public function __construct(Coordinates $coordinates)
    {
        parent::__construct($coordinates);
        parent::setAchieveName(self::NAME);
        parent::setAchieveValue(self::VALUE);
    }
}