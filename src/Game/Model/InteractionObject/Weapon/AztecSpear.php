<?php


namespace App\Game\Model\InteractionObject\Weapon;


class AztecSpear extends Weapon
{
    const DAMAGE = 100;
    const NAME = 'Копье ацтеков';

    /**
     * Machete constructor.
     */
    public function __construct()
    {
        parent::setWeaponName(self::NAME);
        parent::setWeaponDamage(self::DAMAGE);
    }
}