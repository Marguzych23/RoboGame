<?php


namespace App\Game\Model\InteractionObject\HealthAchievement;


use App\Game\Model\Coordinates;

class FuelAchievement extends HealthAchievement
{
    const NAME = 'Топливо';
    const VALUE = 100;

    /**
     * FuelAchievement constructor.
     * @param Coordinates $coordinates
     */
    public function __construct(Coordinates $coordinates)
    {
        parent::__construct($coordinates, self::NAME);
        parent::setAchieveName(self::NAME);
        parent::setAchieveValue(self::VALUE);
    }
}