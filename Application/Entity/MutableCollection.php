<?php
declare(strict_types=1);

namespace Application\Entity;

/**
 * Class MutableCollection
 */
abstract class MutableCollection implements \Iterator, \Countable
{
    /**
     * @var array
     */
    private $storage;

    /**
     * @var int
     */
    private $position;

    /**
     * @var int
     */
    private $count;

    /**
     * ImmutableCollection constructor.
     *
     * @param array $array
     */
    public function __construct(array $array)
    {
        array_map([$this, 'validate'], $array);

        $this->storage  = array_values($array);
        $this->position = 0;
        $this->count    = count($array);
    }

    /**
     * Method which calls for validate each element in array when called collection constructor
     *
     * @param mixed $element
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    abstract public function validate($element);

    /**
     * @return mixed
     * @throws \OutOfRangeException
     */
    public function current()
    {
        return $this->storage[$this->key()];
    }

    public function next()
    {
        $this->position++;
    }

    /**
     * @return mixed
     * @throws \OutOfRangeException
     */
    public function key()
    {
        if (!$this->valid()) {
            throw new \OutOfRangeException('Out of collection range');
        }

        return $this->position;
    }

    /**
     * @return bool
     */
    public function valid() : bool
    {
        return $this->position < $this->count;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Copy collection storage content to array and return it
     *
     * @return array
     */
    public function getArrayCopy() : array
    {
        return $this->storage;
    }

    /**
     * @return int
     */
    public function count() : int
    {
        return $this->count;
    }

    /**
     * @param $element
     *
     * @throws \InvalidArgumentException
     */
    public function append($element)
    {
        $this->validate($element);

        $this->storage[] = $element;
        $this->count     = count($this->storage);

        $this->rewind();
    }
}
