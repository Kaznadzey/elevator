<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use Application\DIContainer\DIManager;
use Application\Entity\Elevator\Elevator;
use Application\Entity\Elevator\Item\BagElevatorItem;
use Application\Entity\Elevator\Item\ElevatorItemCollection;
use Application\Entity\Elevator\Item\HumanElevatorItem;
use Application\Service\Elevator\ElevatorService;
use Application\ValueObject\Uuid;

include 'vendor/autoload.php';

$diContainer = DIManager::getContainer();

/** @var ElevatorService $elevatorService */
$elevatorService = $diContainer->get(ElevatorService::class);
$elevator        = new Elevator(1, 16, 10, 1000, 1.5, 2.5, 2.5);

try {
    $elevatorService->setElevator($elevator);

    $humanItem1 = new HumanElevatorItem(new Uuid(random_bytes(16)), 52.2, 0.09, 155);

    $humanItem2      = new HumanElevatorItem(new Uuid(random_bytes(16)), 90, 0.15, 176);
    $bugItem2        = new BagElevatorItem(new Uuid(random_bytes(16)), 30, 0.3, 1);
    $itemCollection2 = new ElevatorItemCollection(
        [
            $humanItem2,
            $bugItem2,
        ]
    );

    printLog($elevator);
    showLog('Call elevator to floor: 2');

    $elevatorService->call($humanItem1, 2);
    showLog('Add item to elevator');
    $elevatorService->addItem($humanItem1);

    printLog($elevator);

    showLog('Move to floor: 1');
    $elevatorService->moveToFloor($humanItem1, 1);

    printLog($elevator);

    showLog('Remove item');
    $elevatorService->removeItem($humanItem1);

    printLog($elevator);

    showLog('Call elevator to floor: 16');
    $elevatorService->call($humanItem2, 16);

    printLog($elevator);

    showLog('Add items to elevator');
    $elevatorService->addItemCollection($itemCollection2);

    printLog($elevator);

    showLog('Move to floor: 6');
    $elevatorService->moveToFloor($humanItem2, 6);

    printLog($elevator);

    showLog('Remove item flom elevator');
    $elevatorService->removeItem($bugItem2);

    printLog($elevator);

    showLog('Move to floor: 1');
    $elevatorService->moveToFloor($humanItem2, 1);

    printLog($elevator);

    showLog('Remove item flom elevator');
    $elevatorService->removeItem($humanItem2);

    printLog($elevator);
} catch (\Throwable $e) {
    showLog($e->getMessage());
}

function showLog(string $commnet)
{
    if (php_sapi_name() === 'cli') {
        echo "\n" . $commnet;
    } else {
        echo "<br />" . $commnet;
    }
}

function printLog(Elevator $elevator)
{
    showLog('Current elevator floor: ' . $elevator->getCurrentFloor());
    showLog(
        'ItemsCount: ' . (!is_null($elevator->getItemCollection())
            ? $elevator->getItemCollection()->count()
            : 0)
    );
}
