<?php


namespace App\Game\Model;


class Health
{
    const START_VALUE = 500;
    const MIN_VALUE = 0;

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
        if ($value > self::START_VALUE) {
            $value = self::START_VALUE;
        } elseif ($value < self::MIN_VALUE) {
            $value = self::MIN_VALUE;
        }
        $this->value = $value;
    }
}