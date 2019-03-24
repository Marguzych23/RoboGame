<?php


namespace App\Game\Model\InteractionObject\Weapon;


class SwirlWhip extends Weapon
{
    const DAMAGE = 150;
    const NAME = 'Вихревой хлыст';

    /**
     * SwirlWhip constructor.
     */
    public function __construct()
    {
        parent::setWeaponName(self::NAME);
        parent::setWeaponDamage(self::DAMAGE);
    }
}