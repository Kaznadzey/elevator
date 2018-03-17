<?php
declare(strict_types=1);

namespace Application\DIContainer;

/**
 * Class DIManager
 */
class DIManager
{
    /** @var  DIContainer */
    private static $container;

    /**
     * @return DIContainer
     */
    public static function getContainer() : DIContainer
    {
        if (is_null(self::$container)) {
            $container = new DIContainer();
            $container->load();

            self::$container = $container;
        }

        return self::$container;
    }
}
