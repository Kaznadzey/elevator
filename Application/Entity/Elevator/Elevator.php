<?php
declare(strict_types=1);

namespace Application\Entity\Elevator;

use Application\Config\Elevator\ElevatorDoorStatus;
use Application\Entity\Elevator\Item\ElevatorItemCollection;

/**
 * Class Elevator
 */
class Elevator
{
    /** @var int */
    private $floorMin;

    /** @var int */
    private $floorMax;

    /** @var int */
    private $weightMin;

    /** @var int */
    private $weightMax;

    /** @var float */
    private $length;

    /** @var float */
    private $width;

    /** @var float */
    private $height;

    /** @var float */
    private $area;

    /** @var int */
    private $currentFloor;

    /** @var ElevatorItemCollection|null */
    private $itemCollection;

    private $doorStatus;

    /**
     * @param int   $floorMin
     * @param int   $floorMax
     * @param int   $weightMin
     * @param int   $weightMax
     * @param float $length
     * @param float $width
     * @param float $height
     */
    public function __construct(
        $floorMin,
        $floorMax,
        $weightMin,
        $weightMax,
        $length,
        $width,
        $height
    ) {
        $this->floorMin  = $floorMin;
        $this->floorMax  = $floorMax;
        $this->weightMin = $weightMin;
        $this->weightMax = $weightMax;
        $this->length    = $length;
        $this->width     = $width;
        $this->height    = $height;

        $this->area         = $this->length * $this->width;
        $this->currentFloor = $this->floorMin;
        $this->doorStatus   = ElevatorDoorStatus::CLOSED;
    }

    /**
     * @return int
     */
    public function getFloorMin() : int
    {
        return $this->floorMin;
    }

    /**
     * @return int
     */
    public function getFloorMax() : int
    {
        return $this->floorMax;
    }

    /**
     * @return int
     */
    public function getWeightMin() : int
    {
        return $this->weightMin;
    }

    /**
     * @return int
     */
    public function getWeightMax() : int
    {
        return $this->weightMax;
    }

    /**
     * @return float
     */
    public function getLength() : float
    {
        return $this->length;
    }

    /**
     * @return float
     */
    public function getWidth() : float
    {
        return $this->width;
    }

    /**
     * @return float
     */
    public function getHeight() : float
    {
        return $this->height;
    }

    /**
     * @return float
     */
    public function getArea() : float
    {
        return $this->area;
    }

    /**
     * @return int
     */
    public function getCurrentFloor() : int
    {
        return $this->currentFloor;
    }

    /**
     * @param int $currentFloor
     */
    public function setCurrentFloor(int $currentFloor)
    {
        $this->currentFloor = $currentFloor;
    }

    /**
     * @return ElevatorItemCollection|null
     */
    public function getItemCollection()
    {
        return $this->itemCollection;
    }

    /**
     * @param ElevatorItemCollection $itemCollection
     */
    public function setItemCollection(ElevatorItemCollection $itemCollection)
    {
        $this->itemCollection = $itemCollection;
    }

    /**
     * @return int
     */
    public function getDoorStatus() : int
    {
        return $this->doorStatus;
    }

    /**
     * @param int $doorStatus
     */
    public function setDoorStatus(int $doorStatus)
    {
        $this->doorStatus = $doorStatus;
    }
}
