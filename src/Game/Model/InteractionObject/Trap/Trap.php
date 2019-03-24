<?php


namespace App\Game\Model\InteractionObject\Trap;


use App\Game\Model\InteractionObject\InteractionObject;

abstract class Trap implements InteractionObject
{
    /** @var int $actionTime */
    protected $actionTime;

}