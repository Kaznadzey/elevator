<?php
declare(strict_types=1);

namespace Application\DIContainer\Injections\Service\Elevator;

use Application\DIContainer\DIContainer;
use Application\Service\Elevator\ElevatorMoveManager;

/** @var DIContainer $container */

$container->set(
    ElevatorMoveManager::class,
    function () {
        return new ElevatorMoveManager();
    }
);
