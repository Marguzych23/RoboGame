<?php


namespace App\Game\Service;


use App\Game\Model\Location\DesertArea;
use App\Game\Model\Location\ElectricEarth;
use App\Game\Model\Location\RainJungle;

class LocationService
{

    public function generateLocationsForArea(): array
    {
//        TODO
        $locations = array(
            new DesertArea(array(0, 0)),
            new ElectricEarth(array(40, 0)),
            new RainJungle(array(56, 20)),
        );
        return $locations;
    }

    public function generateInteractionObjects(array $locations): array
    {
//        TODO
        return array();
    }

    protected function generateCoordinatesForInteractionObjects(): array
    {
//        TODO
        return array();
    }
}