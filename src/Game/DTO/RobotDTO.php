<?php


namespace App\Game\DTO;


class RobotDTO implements \JsonSerializable
{
    /** @var CoordinatesDTO $coordinates */
    public $coordinates;
    /** @var string $name */
    public $name;
    /** @var int $health */
    public $health;
    /** @var string $script */
    public $script;

    /**
     * RobotDTO constructor.
     * @param CoordinatesDTO $coordinates
     * @param string $name
     * @param int $health
     * @param string $script
     */
    public function __construct(CoordinatesDTO $coordinates, string $name, int $health, string $script)
    {
        $this->coordinates = $coordinates;
        $this->name = $name;
        $this->health = $health;
        $this->script = $script;
    }

    /**
     * @return string
     */
    public function getScript(): string
    {
        return $this->script;
    }

    /**
     * @param string $script
     */
    public function setScript(string $script): void
    {
        $this->script = $script;
    }

    /**
     * @return int
     */
    public function getHealth(): int
    {
        return $this->health;
    }

    /**
     * @param int $health
     */
    public function setHealth(int $health): void
    {
        $this->health = $health;
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