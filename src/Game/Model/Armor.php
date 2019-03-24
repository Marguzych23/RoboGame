<?php


namespace App\Game\Model;


class Armor extends InteractionObject
{
    const MAX_VALUE = 300;
    const ITERATION_VALUE = 100;
    const START_VALUE = 0;

    protected $value;

    public function __construct()
    {
        $this->value = self::START_VALUE;
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
        $this->value = $value;
    }
}