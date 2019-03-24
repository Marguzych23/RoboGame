<?php


namespace App\Game\Model\InteractionObject\Weapon;


use App\Game\Model\Coordinates;

class Machete extends Weapon
{
    const DAMAGE = 200;
    const NAME = 'Мачете';

    /**
     * Machete constructor.
     * @param Coordinates $coordinates
     */
    public function __construct(Coordinates $coordinates)
    {
        parent::__construct($coordinates);
        parent::setWeaponName(self::NAME);
        parent::setWeaponDamage(self::DAMAGE);
    }
}