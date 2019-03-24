<?php


namespace App\Game\Model\InteractionObject\Weapon;


class ElectricStaff extends Weapon
{
    const DAMAGE = 150;
    const NAME = 'Электрический посох';

    /**
     * ElectricStaff constructor.
     */
    public function __construct()
    {
        parent::setWeaponName(self::NAME);
        parent::setWeaponDamage(self::DAMAGE);
    }
}