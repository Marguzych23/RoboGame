<?php


namespace App\Game\Service;


use App\Game\Model\Coordinates;
use App\Game\Model\InteractionObject\Armor\Armor;
use App\Game\Model\InteractionObject\HealthAchievement\FuelAchievement;
use App\Game\Model\InteractionObject\HealthAchievement\GreaseAchievement;
use App\Game\Model\InteractionObject\InteractionObject;
use App\Game\Model\InteractionObject\Weapon\AztecSpear;
use App\Game\Model\InteractionObject\Weapon\ElectricStaff;
use App\Game\Model\InteractionObject\Weapon\Machete;
use App\Game\Model\InteractionObject\Weapon\SwirlWhip;
use App\Game\Model\Location\DesertArea;
use App\Game\Model\Location\ElectricEarth;
use App\Game\Model\Location\Location;
use App\Game\Model\Location\RainJungle;

class LocationService
{

    /**
     * @return Location[]
     */
    public function generateLocationsForArea(): array
    {
//        TODO
        $locations = array(
            new DesertArea(new Coordinates(0, 0)),
            new ElectricEarth(new Coordinates(40, 0)),
            new RainJungle(new Coordinates(56, 20)),
        );
        return $locations;
    }

    /**
     * @param Location[] $locations
     * @return InteractionObject[]
     */
    public function generateInteractionObjects(array $locations): array
    {
        /** @var InteractionObject[] $interactionObjects */
        $interactionObjects = array();
        foreach ($locations as $location) {
            $emptyInteractionObjects = array();
            switch ($location->getName()) {
                case ElectricEarth::NAME:
                    {
                        $emptyInteractionObjects = array(
                            new Armor(null),
                            new ElectricStaff(null),
                        );
                        break;
                    }
                case RainJungle::NAME:
                    {
                        $emptyInteractionObjects = array(
                            new Machete(null),
                            new AztecSpear(null),
                            new SwirlWhip(null),
                        );
                        break;
                    }
                case DesertArea::NAME:
                    {
                        $emptyInteractionObjects = array(
                            new FuelAchievement(null),
                            new GreaseAchievement(null),
                        );
                        break;
                    }
                default:
                    {
                        break;
                    }
            }
            $this->getInteractionObjectsForLocation($emptyInteractionObjects, $location);
            array_push($interactionObjects, $emptyInteractionObjects);
        }
        return $interactionObjects;
    }

    /**
     * @param InteractionObject[] $interactionObjects
     * @param Location $location
     */
    protected function getInteractionObjectsForLocation(array &$interactionObjects, Location $location)
    {
        $interactionObjectsCountForLocation = 0;
        /** @var Coordinates[] $coordinates */
        $coordinates = array();
        while ($interactionObjectsCountForLocation !== count($interactionObjects)) {
            $emptyCoordinate = $this->generateCoordinatesForInteractionObjects($location->getStartCoordinates(), $location::SIZE);
            foreach ($coordinates as $coordinate) {
                if (($coordinate->getX() == $emptyCoordinate->getX()) && $coordinate->getY() == $emptyCoordinate->getY()) {
                    $emptyCoordinate = null;
                }
            }
            if (!is_null($emptyCoordinate)) {
                $interactionObjects[$interactionObjectsCountForLocation]->setCoordinates($emptyCoordinate);
                $interactionObjectsCountForLocation++;
            }
        }
    }

    /**
     * @param Coordinates $locationCoordinates
     * @param int $locationSize
     * @return Coordinates
     */
    protected function generateCoordinatesForInteractionObjects(Coordinates $locationCoordinates, int $locationSize): Coordinates
    {
        $x = mt_rand($locationCoordinates->getX(), $locationCoordinates->getX() + $locationSize - 1);
        $y = mt_rand($locationCoordinates->getY(), $locationCoordinates->getY() + $locationSize - 1);
        return new Coordinates($x, $y);
    }
}