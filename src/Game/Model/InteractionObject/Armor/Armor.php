<?php


namespace App\Game\Model\InteractionObject\Armor;


use App\Game\Model\InteractionObject\InteractionObject;

class Armor implements InteractionObject
{
    const MAX_VALUE = 300;
    const MIN_VALUE = 0;
    const ITERATION_VALUE = 100;

    protected $value;

    public function __construct()
    {
        $this->value = self::MIN_VALUE;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue(int $value): void
    {
        if ($value > self::MAX_VALUE) {
            $value = self::MAX_VALUE;
        }
        $this->value = $value;
    }
}