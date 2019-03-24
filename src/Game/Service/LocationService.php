<?php


namespace App\Game\Service;


use App\Game\Model\Location\DesertArea;
use App\Game\Model\Location\ElectricEarth;
use App\Game\Model\Location\Location;
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

    /**
     * @param Location[] $locations
     * @return array
     */
    public function generateInteractionObjects(array $locations): array
    {
        foreach ($locations as $location) {
            $interactionObjectsCountForLocation = 0;
            switch ($location->getName()) {
                case ElectricEarth::NAME:
                    {
                        while ($interactionObjectsCountForLocation !== 3) {
                        }
                        break;
                    }
                case RainJungle::NAME:
                    {
                        break;
                    }
                case DesertArea::NAME:
                    {
                        break;
                    }
                default:
                    {
                        break;
                    }
            }

        }
//        TODO
        return array();
    }

    protected function getInteractionObjectsForLocation() {

    }

    protected function generateCoordinatesForInteractionObjects(array $locationCoordinates, int $locationSize): array
    {
        $x = mt_rand($locationCoordinates[0], $locationCoordinates[0] + $locationSize - 1);
        $y = mt_rand($locationCoordinates[1], $locationCoordinates[1] + $locationSize - 1);
        return array($x, $y);
    }
}