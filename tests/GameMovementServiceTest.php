<?php

namespace App\Tests;

use App\Service\GameMoverService;
use App\Service\GameTurnChecker;
use PHPUnit\Framework\TestCase;

class GameMovementServiceTest extends TestCase
{
    public function testMovementCleanBoard(): void
    {
        $initialBoard = [
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
        ];

        $turnChecker = new GameTurnChecker();
        $movementService = new GameMoverService($turnChecker);
        $movementService->setBoard($initialBoard);
        $resultBoard = $movementService->move(0);

        $movementService->setBoard($initialBoard);
        $this->assertSame([
            [1,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
        ],$resultBoard);
    }

    public function testMovementMovementsDoneBoard(): void
    {
        $initialBoard = [
            [1,2,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
        ];

        $turnChecker = new GameTurnChecker();
        $movementService = new GameMoverService($turnChecker);
        $movementService->setBoard($initialBoard);
        $resultBoard = $movementService->move(0);

        $movementService->setBoard($initialBoard);
        $this->assertSame([
            [1,2,1,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
        ],$resultBoard);
    }

    public function testFullColumnThrowException(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Column is full');
        $initialBoard = [
            [1,2,1,2,1,1],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
        ];

        $turnChecker = new GameTurnChecker();
        $movementService = new GameMoverService($turnChecker);
        $movementService->setBoard($initialBoard);
        $movementService->move(0);

    }

    public function testToNotSetBoardThrowException(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('You need to set the board before make a movement');

        $turnChecker = new GameTurnChecker();
        $movementService = new GameMoverService($turnChecker);
        $movementService->move(0);

    }
}
