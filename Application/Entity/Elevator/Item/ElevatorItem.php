<?php
declare(strict_types=1);

namespace Application\Entity\Elevator\Item;

use Application\ValueObject\Uuid;

/**
 * Class ElevatorItem
 */
abstract class ElevatorItem
{
    /** @var bool */
    protected $alive = true;

    /** @var Uuid */
    private $id;

    /** @var float */
    private $weight;

    /** @var float */
    private $area;

    /** @var float */
    private $height;

    /**
     * @param Uuid  $id
     * @param float $weight
     * @param float $area
     * @param float $height
     */
    public function __construct(Uuid $id, float $weight, float $area, float $height)
    {
        $this->id     = $id;
        $this->weight = $weight;
        $this->area   = $area;
        $this->height = $height;
    }

    /**
     * @return Uuid
     */
    public function getId() : Uuid
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getWeight() : float
    {
        return $this->weight;
    }

    /**
     * @return float
     */
    public function getArea() : float
    {
        return $this->area;
    }

    /**
     * @return float
     */
    public function getHeight() : float
    {
        return $this->height;
    }

    /**
     * @return bool
     */
    public function isAlive() : bool
    {
        return $this->alive;
    }
}
