<?php
declare(strict_types=1);

namespace Application\DIContainer;

/**
 * Class DIContainer
 */
class DIContainer
{
    const EXTENSION_PHP = 'php';

    private $injections = [];

    private $keys = [];

    /**
     * Load injections list
     */
    public function load()
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(dirname(__FILE__) . '/Injections', \RecursiveIteratorIterator::SELF_FIRST)
        );

        /** @var \SplFileInfo $info */
        foreach ($iterator as $info) {
            if ($info->isFile() && $info->getExtension() === self::EXTENSION_PHP) {
                $container = $this;
                require_once $info->getPathname();
            }
        }
    }

    /**
     * @param string   $name
     * @param callable $function
     */
    public function set(string $name, callable $function)
    {
        if (!$this->has($name)) {
            $this->injections[$name] = $function;
            $this->keys[$name] = true;
        }
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function get(string $name)
    {
        if ($this->has($name)) {
            /** @var \Closure $injection */
            $injection = $this->injections[$name];
            if ($injection instanceof \Closure) {
                $return = $injection->call($this, $this);
                $this->injections[$name] = $return;
            } else {
                $return = $injection;
            }

            return $return;
        }

        throw new \InvalidArgumentException(
            sprintf(
                'Injection name is not defined: %s',
                $name
            )
        );
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name) : bool
    {
        return !empty($this->keys[$name]) && ($this->keys[$name] === true);
    }
}
