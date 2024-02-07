<?php

namespace App\Tests;

use App\Service\GameTurnChecker;
use PHPUnit\Framework\TestCase;

class GameTurnCheckerTest extends TestCase
{
    public function testTurnCleanBoard(): void
    {
        $board = new GameTurnChecker();
        $board->setBoard([
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
        ]);
        $tourn = $board->getTurn();

        $this->assertSame(1, $tourn);
    }

    public function testTurnOneMovement(): void
    {
        $board = new GameTurnChecker();
        $board->setBoard([
            [1,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
        ]);

        $tourn = $board->getTurn();
        $this->assertSame(2, $tourn);
    }

    public function testTurnTwoMovements(): void
    {
        $board = new GameTurnChecker();
        $board->setBoard([
            [1,2,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
        ]);

        $tourn = $board->getTurn();
        $this->assertSame(1, $tourn);
    }
}
