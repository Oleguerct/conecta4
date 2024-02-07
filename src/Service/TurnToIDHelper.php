<?php


namespace App\Service;


use App\Entity\Game;

class TurnToIDHelper
{
    /**
     * @var Game
     */
    private Game $game;

    public function setGame(Game $game)
    {
        $this->game = $game;
    }

    public function getID($turn){
        if($turn === 1){
            return $this->game->getPlayer1ID();
        }
        if($turn === 2){
            return $this->game->getPlayer2ID();
        }
    }
}