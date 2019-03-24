<?php


namespace App\Game\Model\InteractionObject\HealthAchievement;


abstract class HealthAchievement implements InteractionObject
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
}