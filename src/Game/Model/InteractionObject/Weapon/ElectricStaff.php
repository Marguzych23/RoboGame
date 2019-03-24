<?php


namespace App\Game\Model\InteractionObject\Weapon;


use App\Game\Model\Coordinates;

class ElectricStaff extends Weapon
{
    const DAMAGE = 150;
    const NAME = 'Электрический посох';

    /**
     * ElectricStaff constructor.
     * @param Coordinates $coordinates
     */
    public function __construct(Coordinates $coordinates)
    {
        parent::__construct($coordinates);
        parent::setWeaponName(self::NAME);
        parent::setWeaponDamage(self::DAMAGE);
    }
}