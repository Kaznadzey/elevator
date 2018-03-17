<?php
declare(strict_types=1);

namespace Application\Service\Elevator;

use Application\Entity\Elevator\Elevator;
use Application\Entity\Elevator\Item\ElevatorItem;
use Application\Entity\Elevator\Item\ElevatorItemCollection;

/**
 * Class ElevatorService
 */
class ElevatorService
{
    /** @var ElevatorMoveManager */
    private $elevatorMoveManager;

    /** @var ElevatorItemManager */
    private $elevatorItemManager;

    /** @var Elevator */
    private $elevator;

    /**
     * @param ElevatorMoveManager $elevatorMoveManager
     * @param ElevatorItemManager $elevatorItemManager
     */
    public function __construct(ElevatorMoveManager $elevatorMoveManager, ElevatorItemManager $elevatorItemManager)
    {
        $this->elevatorMoveManager = $elevatorMoveManager;
        $this->elevatorItemManager = $elevatorItemManager;
    }

    /**
     * @param Elevator $elevator
     *
     * @throws \DomainException
     */
    public function setElevator(Elevator $elevator)
    {
        if (!is_null($this->elevator)) {
            throw new \DomainException('Please run flush() action before.');
        }

        $this->elevator = $elevator;
    }

    /**
     * Rebuild service for new elevator
     */
    public function flush()
    {
        $this->elevator = null;
    }

    /**
     * @param ElevatorItem $elevatorItem
     * @param int          $floor
     *
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function call(ElevatorItem $elevatorItem, int $floor) : bool
    {
        if ($elevatorItem->isAlive()) {
            return $this->elevatorMoveManager->move($this->elevator, $floor);
        }

        throw new \InvalidArgumentException('Elevator item must be alive!');
    }

    /**
     * @param ElevatorItem $elevatorItem
     * @param int          $floor
     *
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function moveToFloor(ElevatorItem $elevatorItem, int $floor)
    {
        if ($elevatorItem->isAlive()
            && $this->elevatorItemManager->exists($this->elevator, $elevatorItem)
        ) {
            return $this->elevatorMoveManager->move($this->elevator, $floor);
        }

        throw new \InvalidArgumentException('Elevator item must be alive and exists!');
    }

    /**
     * @param ElevatorItem $elevatorItem
     *
     * @return bool
     * @throws \DomainException
     * @throws \InvalidArgumentException
     */
    public function addItem(ElevatorItem $elevatorItem)
    {
        return $this->addItemCollection(new ElevatorItemCollection([$elevatorItem]));
    }

    /**
     * @param ElevatorItemCollection $itemCollection
     *
     * @return bool
     * @throws \DomainException
     * @throws \InvalidArgumentException
     */
    public function addItemCollection(ElevatorItemCollection $itemCollection)
    {
        return $this->elevatorItemManager->addItems($this->elevator, $itemCollection);
    }

    /**
     * @param ElevatorItem $elevatorItem
     *
     * @return bool
     * @throws \DomainException
     */
    public function removeItem(ElevatorItem $elevatorItem)
    {
        return $this->removeItems(new ElevatorItemCollection([$elevatorItem]));
    }

    /**
     * @param ElevatorItemCollection $elevatorItemCollection
     *
     * @return bool
     * @throws \DomainException
     */
    public function removeItems(ElevatorItemCollection $elevatorItemCollection) : bool
    {
        return $this->elevatorItemManager->removeItems($this->elevator, $elevatorItemCollection);
    }
}
