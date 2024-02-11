<?php


namespace App\Service;


use App\Entity\Game;
use App\Entity\User;

class GameMoverService
{
    /**
     * @var Game
     */
    private Game $game;

    /**
     * GameMovementService constructor.
     * @param GameTurnChecker $turnChecker
     * @param TurnToIDHelper $turnToIDHelper
     */
    public function __construct(
        private TurnToIDHelper $turnToIDHelper
    ){}

    /**
     * @param Game $game
     */
    public function setGame(Game $game)
    {
        $this->game = $game;
    }

    public function move(User $user, int $column){

        if(!isset($this->game)){
            throw new \Exception('You need to set the game before make a movement');
        }

        $currentPlayer = $this->game->getCurrentPlayerID();
        if($user->getId() !== $currentPlayer){
            throw new \Exception('Is not your turn',403);
        }

        $board = $this->game->getBoard();
        foreach ($board[$column] as $key => $value){
            if($value == 0){
                $board[$column][$key] = $this->game->getTurn();
                $this->game->setBoard($board);
                $this->game->passTurn();
                return;
            }
        }
        throw new \Exception('Column is full');
    }

}