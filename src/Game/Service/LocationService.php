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
    /** @var CoordinatesService $coordinatesService */
    protected $coordinatesService;

    /**
     * LocationService constructor.
     * @param CoordinatesService $coordinatesService
     */
    public function __construct(CoordinatesService $coordinatesService)
    {
        $this->coordinatesService = $coordinatesService;
    }

    /**
     * @param Coordinates $coordinates
     * @param Location $location
     * @return bool
     */
    public function coordinatesInLocation(Coordinates $coordinates, Location $location): bool
    {
        return false;
    }

    /**
     * @return Location[]
     */
    public function generateLocationsForArea(): array
    {
//        TODO
        $locations = array(
            new DesertArea(new Coordinates(0, 0)),
            new ElectricEarth(new Coordinates(15, 1)),
            new RainJungle(new Coordinates(11, 18)),
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
            $tempInteractionObjects = array();
            switch ($location->getName()) {
                case ElectricEarth::NAME:
                    {
                        $tempInteractionObjects = array(
                            new Armor(new Coordinates(0, 0)),
                            new ElectricStaff(new Coordinates(0, 0)),
                        );
                        break;
                    }
                case RainJungle::NAME:
                    {
                        $tempInteractionObjects = array(
                            new Machete(new Coordinates(0, 0)),
                            new AztecSpear(new Coordinates(0, 0)),
                            new SwirlWhip(new Coordinates(0, 0)),
                        );
                        break;
                    }
                case DesertArea::NAME:
                    {
                        $tempInteractionObjects = array(
                            new FuelAchievement(new Coordinates(0, 0)),
                            new GreaseAchievement(new Coordinates(0, 0)),
                        );
                        break;
                    }
                default:
                    {
                        break;
                    }
            }
            $this->getInteractionObjectsForLocation($tempInteractionObjects, $location);
            $interactionObjects = array_merge($interactionObjects, $tempInteractionObjects);
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
        while ($interactionObjectsCountForLocation !== count($interactionObjects)) {
            $tempCoordinates = $this->coordinatesService->generateCoordinatesForInteractionObjects($location->getStartCoordinates(), $location::SIZE);
            if (!is_null($tempCoordinates)) {
                $interactionObjects[$interactionObjectsCountForLocation]->setCoordinates($tempCoordinates);
                $interactionObjectsCountForLocation++;
            }
        }
    }

}