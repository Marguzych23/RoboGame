<?php


namespace App\Game\Model;


class Step implements \JsonSerializable
{
    /** @var Coordinates $destination */
    protected $destination;
    /** @var Coordinates $target */
    protected $target;

    /**
     * Step constructor.
     * @param Coordinates $destination
     * @param Coordinates $target
     */
    public function __construct(Coordinates $destination, Coordinates $target = null)
    {
        if (is_null($target)) {
            $target = new Coordinates(-1, -1);
        }
        $this->destination = $destination;
        $this->target = $target;
    }

    /**
     * @return Coordinates
     */
    public function getDestination(): Coordinates
    {
        return $this->destination;
    }

    /**
     * @param Coordinates $destination
     */
    public function setDestination(Coordinates $destination): void
    {
        $this->destination = $destination;
    }

    /**
     * @return Coordinates
     */
    public function getTarget(): Coordinates
    {
        return $this->target;
    }

    /**
     * @param Coordinates $target
     */
    public function setTarget(Coordinates $target): void
    {
        $this->target = $target;
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
            'target' => $this->target,
            'destination' => $this->destination,
        );
    }
}