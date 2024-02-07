<?php


namespace App\Service;


use App\Entity\Game;

class GameCheckWinnerService
{


    /**
     * GameCheckWinnerService constructor.
     */
    public function __construct(private CheckBoardWinnerService $boardWinnerService)
    {
    }

    public function checkWinner(Game $game): int|false
    {
        if($winner = $this->checkBoard($game->getBoard())){
            $game->setWinner($winner);
        }
        return false;
    }

    public function checkBoard(array $board): int|false
    {
        return $this->boardWinnerService->checkWinner($board);
    }

    public function checkSurrender(Game $game): int|false
    {

    }

}