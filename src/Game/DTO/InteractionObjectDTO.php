<?php


namespace App\Game\DTO;


class InteractionObjectDTO implements \JsonSerializable
{
    /** @var CoordinatesDTO $coordinates */
    public $coordinates;
    /** @var string $name */
    public $name;

    /**
     * InteractionObjectDTO constructor.
     * @param CoordinatesDTO $coordinates
     * @param string $name
     */
    public function __construct(CoordinatesDTO $coordinates, string $name)
    {
        $this->coordinates = $coordinates;
        $this->name = $name;
    }

    /**
     * @return CoordinatesDTO
     */
    public function getCoordinates(): CoordinatesDTO
    {
        return $this->coordinates;
    }

    /**
     * @param CoordinatesDTO $coordinates
     */
    public function setCoordinates(CoordinatesDTO $coordinates): void
    {
        $this->coordinates = $coordinates;
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
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return array(
            'coordinates' => $this->coordinates,
            'name' => $this->name,
        );
    }
}