<?php
declare(strict_types=1);

namespace Application\Entity\Elevator\Item;

use Application\Entity\MutableCollection;
use Application\ValueObject\Uuid;

/**
 * Class ElevatorItemCollection
 * @method ElevatorItem[] getArrayCopy()
 * @method ElevatorItem next()
 * @method ElevatorItem current()
 */
class ElevatorItemCollection extends MutableCollection
{
    /**
     * @param mixed $element
     *
     * @throws \InvalidArgumentException
     */
    public function validate($element)
    {
        if (!($element instanceof ElevatorItem)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Each element of collection must be instance of: %s',
                    ElevatorItem::class
                )
            );
        }
    }

    /**
     * @return float
     */
    public function getTotalArea() : float
    {
        $area = 0.0;
        foreach ($this as $item) {
            $area += $item->getArea();
        }

        return $area;
    }

    /**
     * @return float
     */
    public function getTotalWeight() : float
    {
        $weight = 0.0;
        foreach ($this as $item) {
            $weight += $item->getWeight();
        }

        return $weight;
    }

    /**
     * @param Uuid $id
     *
     * @return MutableCollection
     */
    public function removeById(Uuid $id)
    {
        $toStore = [];
        foreach ($this as $elevatorItem) {
            if ($elevatorItem->getId()->toHex() !== $id->toHex()) {
                $toStore[] = $elevatorItem;
            }
        }

        $this->__construct($toStore);
    }
}
