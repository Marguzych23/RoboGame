<?php


namespace App\Game\Model\InteractionObject;


use App\Game\Model\Coordinates;

abstract class InteractionObject
{
    /** @var Coordinates $coordinates */
    protected $coordinates;

    /**
     * InteractionObject constructor.
     * @param Coordinates $coordinates
     */
    public function __construct(Coordinates $coordinates)
    {
        $this->coordinates = $coordinates;
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

}