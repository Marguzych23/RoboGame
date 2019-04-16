<?php


namespace App\Game\Model\InteractionObject\Trap;


use App\Game\Model\InteractionObject\InteractionObject;

abstract class Trap extends InteractionObject
{
    /** @var int $actionTime */
    protected $actionTime;

    /** @var string $name */
    protected $name;

    /**
     * @return int
     */
    public function getActionTime(): int
    {
        return $this->actionTime;
    }

    /**
     * @param int $actionTime
     */
    public function setActionTime(int $actionTime): void
    {
        $this->actionTime = $actionTime;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function jsonSerialize()
    {
        $jsonSerializeArray = parent::jsonSerialize();
        return array_merge($jsonSerializeArray, array(
            'name' => $this->name,
            'actionTime' => $this->actionTime,
        ));
    }
}