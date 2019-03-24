<?php


namespace App\Game\Model;


class Health extends InteractionObject
{
    const START_VALUE = 500;
    // Desert area
    const ACHIEVE_FUEL_VALUE = 100;
    const ACHIEVE_GREASE_VALUE = 80;

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