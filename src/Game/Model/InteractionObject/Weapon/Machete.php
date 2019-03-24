<?php


namespace App\Game\Model\InteractionObject\Weapon;


class Machete extends Weapon
{
    const DAMAGE = 200;
    const NAME = 'Мачете';

    /**
     * Machete constructor.
     */
    public function __construct()
    {
        parent::setWeaponName(self::NAME);
        parent::setWeaponDamage(self::DAMAGE);
    }
}