<?php
declare(strict_types=1);

namespace Application\Service\Elevator;

use Application\Entity\Elevator\Elevator;

/**
 * Class ElevatorMoveManager
 */
class ElevatorMoveManager
{
    /**
     * @param Elevator $elevator
     * @param int      $floor
     *
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function move(Elevator $elevator, int $floor) : bool
    {
        if ($floor < $elevator->getFloorMin() || $floor > $elevator->getFloorMax()) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Floor value: %u is not allowed',
                    $floor
                )
            );
        }

        $this->moveToFloor($elevator, $floor);

        return true;
    }

    /**
     * @param Elevator $elevator
     * @param int      $floor
     *
     * @return bool
     */
    private function isOnFloor(Elevator $elevator, int $floor)
    {
        return $elevator->getCurrentFloor() === $floor;
    }

    /**
     * @param Elevator $elevator
     * @param int      $floor
     */
    private function moveToFloor(Elevator $elevator, int $floor)
    {
        while ($this->isOnFloor($elevator, $floor) === false) {
            $currentFloor = $elevator->getCurrentFloor();
            if ($currentFloor <= $floor) {
                $this->moveTop($elevator);
            } else {
                $this->moveBottom($elevator);
            }
        }
    }

    /**
     * @param Elevator $elevator
     */
    private function moveTop(Elevator $elevator)
    {
        $floor = $elevator->getCurrentFloor();
        $floor ++;

        $elevator->setCurrentFloor($floor);
    }

    /**
     * @param Elevator $elevator
     */
    private function moveBottom(Elevator $elevator)
    {
        $floor = $elevator->getCurrentFloor();
        $floor --;

        $elevator->setCurrentFloor($floor);
    }
}
