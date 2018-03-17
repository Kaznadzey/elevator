<?php
declare(strict_types=1);

namespace Application\DIContainer\Injections\Service\Elevator;

use Application\DIContainer\DIContainer;
use Application\Service\Elevator\ElevatorItemManager;
use Application\Service\Elevator\ElevatorMoveManager;
use Application\Service\Elevator\ElevatorService;

/** @var DIContainer $container */

$container->set(
    ElevatorService::class,
    function (DIContainer $c) {
        return new ElevatorService(
            $c->get(ElevatorMoveManager::class),
            $c->get(ElevatorItemManager::class)
        );
    }
);
