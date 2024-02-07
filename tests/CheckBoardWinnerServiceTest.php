<?php

namespace App\Tests;

use App\Service\CheckBoardWinnerService;
use PHPUnit\Framework\TestCase;

class CheckBoardWinnerServiceTest extends TestCase
{
    public function testNoWinnerReturnFalse(): void
    {
        $board = [
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
        ];

        $checker = new CheckBoardWinnerService();
        $result = $checker->checkWinner($board);
        $this->assertFalse($result);
    }

    public function test4VerticalReturnCorrectWinner(): void
    {
        $checker = new CheckBoardWinnerService();

        $board1 = [
            [1,1,1,1,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
        ];

        $result = $checker->checkWinner($board1);
        $this->assertSame(1, $result);

        $board2 = [
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [2,2,2,2,0,0],
        ];

        $result = $checker->checkWinner($board2);
        $this->assertSame(2, $result);
    }

    public function test4horizontalReturnWinner(): void
    {
        $board = [
            [1,0,0,0,0,0],
            [2,0,0,0,0,0],
            [1,0,0,0,0,0],
            [1,0,0,0,0,0],
            [1,0,0,0,0,0],
            [1,0,0,0,0,0],
            [0,0,0,0,0,0],
        ];

        $checker = new CheckBoardWinnerService();
        $result = $checker->checkWinner($board);
        $this->assertSame(1, $result);
    }

    public function test4primaryDiagonalReturnWinner(): void
    {
        $board = [
            [1,0,0,0,0,0],
            [2,1,0,0,0,0],
            [0,0,1,0,0,0],
            [0,0,0,1,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
        ];

        $checker = new CheckBoardWinnerService();
        $result = $checker->checkWinner($board);
        $this->assertSame(1, $result);
    }
    public function test4secondaryDiagonalReturnWinner(): void
    {
        $board = [
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,1,0,0],
            [0,0,1,0,0,0],
            [0,1,0,0,0,0],
            [1,0,0,0,0,0],
        ];

        $checker = new CheckBoardWinnerService();
        $result = $checker->checkWinner($board);
        $this->assertSame(1, $result);
    }

}
