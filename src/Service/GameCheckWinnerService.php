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
        $this->checkSurrender($game);
        if($winner = $this->checkBoard($game->getBoard())){
            $game->setWinner($winner);
        }
        return false;
    }

    // check if a user has surrendered
    public function checkSurrender(Game $game): int|false
    {
        if($game->getTurn() === null) return false;

        if($game->getPlayer1() === null || $game->getPlayer2() === null){
            $game->setWinner($game->getPlayer1() === null ? 2 : 1);
        }

        return false;
    }
    

    public function checkBoard(array $board): int|false
    {
        return $this->boardWinnerService->checkWinner($board);
    }



}