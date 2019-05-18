<?php


namespace App\Game\Model\InteractionObject\Armor;


use App\Game\Model\Coordinates;
use App\Game\Model\InteractionObject\InteractionObject;

class Armor extends InteractionObject
{
    const MAX_VALUE = 300;
    const MIN_VALUE = 0;
    const ITERATION_VALUE = 100;
    const NAME = 'Armor';

    protected $value;

    /**
     * Armor constructor.
     * @param Coordinates $coordinates
     * @param int $value
     */
    public function __construct(Coordinates $coordinates, $value = self::MIN_VALUE)
    {
        parent::__construct($coordinates, self::NAME);
        $this->value = $value;
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

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $jsonSerializeArray = parent::jsonSerialize();
        return array_merge(
            $jsonSerializeArray,
            array(
                'name' => $this->name,
                'value' => $this->value
            )
        );
    }
}