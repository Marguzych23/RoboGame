<?php


namespace App\Game\Model\InteractionObject;


use App\Game\Model\Coordinates;

abstract class InteractionObject implements \JsonSerializable
{
    /** @var Coordinates $coordinates */
    protected $coordinates;
    /** @var string $name */
    protected $name;

    /**
     * InteractionObject constructor.
     * @param Coordinates $coordinates
     * @param string $name
     */
    public function __construct(Coordinates $coordinates, string $name)
    {
        $this->coordinates = $coordinates;
        $this->name = $name;
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

    /**
     * @return Coordinates
     */
    public function getCoordinates(): Coordinates
    {
        return $this->coordinates;
    }

    /**
     * @param Coordinates $coordinates
     */
    public function setCoordinates(Coordinates $coordinates): void
    {
        $this->coordinates = $coordinates;
    }

    public function jsonSerialize()
    {
        return array(
            'coordinates' => $this->coordinates
        );
    }
}