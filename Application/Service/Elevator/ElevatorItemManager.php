<?php
declare(strict_types=1);

namespace Application\Service\Elevator;

use Application\Entity\Elevator\Elevator;
use Application\Entity\Elevator\Item\ElevatorItem;
use Application\Entity\Elevator\Item\ElevatorItemCollection;

/**
 * Class ElevatorItemManager
 */
class ElevatorItemManager
{
    /**
     * @param Elevator               $elevator
     * @param ElevatorItemCollection $itemCollection
     *
     * @return bool
     * @throws \DomainException
     * @throws \InvalidArgumentException
     */
    public function addItems(Elevator $elevator, ElevatorItemCollection $itemCollection)
    {
        if ($this->canAdd($elevator, $itemCollection)) {
            $collection = $elevator->getItemCollection();
            if (is_null($collection)) {
                $collection = new ElevatorItemCollection([]);
            }

            foreach ($itemCollection as $item) {
                if ($this->exists($elevator, $item)) {
                    throw new \DomainException('Can not twice add item!');
                }

                $collection->append($item);
            }

            $elevator->setItemCollection($collection);

            return true;
        }

        return false;
    }

    /**
     * @param Elevator               $elevator
     * @param ElevatorItemCollection $itemCollection
     *
     * @return bool
     * @throws \DomainException
     */
    public function removeItems(Elevator $elevator, ElevatorItemCollection $itemCollection) : bool
    {
        $elevatorItems = $elevator->getItemCollection();

        if (is_null($elevatorItems)) {
            throw new \DomainException('Elevator is free.');
        }

        foreach ($itemCollection as $elevatorItem) {
            $elevatorItems->removeById($elevatorItem->getId());
        }

        $elevator->setItemCollection($elevatorItems);

        return true;
    }

    /**
     * @param Elevator     $elevator
     * @param ElevatorItem $elevatorItem
     *
     * @return bool
     */
    public function exists(Elevator $elevator, ElevatorItem $elevatorItem) : bool
    {
        $elevatorItems = $elevator->getItemCollection();

        if (!is_null($elevatorItems)) {
            foreach ($elevatorItems as $item) {
                if ($item->getId()->toHex() === $elevatorItem->getId()->toHex()) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param Elevator               $elevator
     * @param ElevatorItemCollection $itemCollection
     *
     * @return bool
     */
    private function canAdd(Elevator $elevator, ElevatorItemCollection $itemCollection) : bool
    {
        return ($this->canAddByWeight($elevator, $itemCollection)
            && $this->canAddByArea($elevator, $itemCollection));
    }

    /**
     * @param Elevator               $elevator
     * @param ElevatorItemCollection $itemCollection
     *
     * @return bool
     */
    private function canAddByWeight(Elevator $elevator, ElevatorItemCollection $itemCollection) : bool
    {
        $currentWeight = 0;
        if (!is_null($elevator->getItemCollection())) {
            $currentWeight = $elevator->getItemCollection()->getTotalWeight();
        }

        $maxWeight = $elevator->getWeightMax();

        return $maxWeight > ($currentWeight + $itemCollection->getTotalWeight());
    }

    /**
     * @param Elevator               $elevator
     * @param ElevatorItemCollection $itemCollection
     *
     * @return bool
     */
    private function canAddByArea(Elevator $elevator, ElevatorItemCollection $itemCollection) : bool
    {
        $currentArea = 0;
        if (!is_null($elevator->getItemCollection())) {
            $currentArea = $elevator->getItemCollection()->getTotalArea();
        }

        $area = $elevator->getArea();

        return $area > ($currentArea + $itemCollection->getTotalArea());
    }
}
