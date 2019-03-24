<?php


namespace App\Game\Model\InteractionObject\Weapon;


use App\Game\Model\Coordinates;

class SwirlWhip extends Weapon
{
    const DAMAGE = 150;
    const NAME = 'Вихревой хлыст';

    /**
     * SwirlWhip constructor.
     * @param Coordinates $coordinates
     */
    public function __construct(Coordinates $coordinates)
    {
        parent::__construct($coordinates);
        parent::setWeaponName(self::NAME);
        parent::setWeaponDamage(self::DAMAGE);
    }
}