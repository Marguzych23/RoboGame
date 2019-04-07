<?php


namespace App\Game\Model;


class Step
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
}