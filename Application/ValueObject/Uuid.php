<?php
declare(strict_types=1);

namespace Application\ValueObject;

/**
 * Class Uuid
 */
class Uuid
{
    /** @var string */
    private $value;

    /**
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (strlen($value) === 32) {
            $value = hex2bin($value);

            if (is_bool($value)) {
                throw new \InvalidArgumentException('Value is not allowed');
            }
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function toHex() : string
    {
        return bin2hex($this->value);
    }

    /**
     * @return string
     */
    public function toBin() : string
    {
        return $this->value;
    }
}
