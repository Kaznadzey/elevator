<?php
declare(strict_types=1);

namespace Application\Entity\Elevator\Item;

use Application\ValueObject\Uuid;

/**
 * Class BagElevatorItem
 */
class BagElevatorItem extends ElevatorItem
{
    /**
     * @param Uuid  $id
     * @param float $weight
     * @param float $area
     * @param float $height
     */
    public function __construct(Uuid $id, $weight, $area, $height)
    {
        parent::__construct($id, $weight, $area, $height);

        $this->alive = false;
    }
}
