<?php

namespace App\Game\Model\InteractionObject\HealthAchievement;

use App\Game\Model\Coordinates;
use App\Game\Model\InteractionObject\InteractionObject;

abstract class HealthAchievement extends InteractionObject
{
    /** @var string $name */
    protected $name;
    /** @var int $value */
    protected $value;

    /**
     * @return int
     */
    public function getAchieveValue(): int
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getAchieveName(): string
    {
        return $this->name;
    }

    /**
     * @param int $value
     */
    protected function setAchieveValue(int $value): void
    {
        $this->value = $value;
    }

    /**
     * @param string $name
     */
    protected function setAchieveName(string $name): void
    {
        $this->name = $name;
    }

    public function jsonSerialize()
    {
        $jsonSerializeArray = parent::jsonSerialize();
        return array_merge($jsonSerializeArray, array(
            'name' => $this->name,
            'value' => $this->value,
        ));
    }
}