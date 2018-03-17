<?php
declare(strict_types=1);

namespace Application\DIContainer\Injections\Service\Elevator;

use Application\DIContainer\DIContainer;
use Application\Service\Elevator\ElevatorItemManager;

/** @var DIContainer $container */

$container->set(
    ElevatorItemManager::class,
    function () {
        return new ElevatorItemManager();
    }
);
