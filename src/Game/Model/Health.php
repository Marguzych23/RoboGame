<?php


namespace App\Game\Model;


class Health implements \JsonSerializable
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

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return array('value' => $this->value);
    }
}