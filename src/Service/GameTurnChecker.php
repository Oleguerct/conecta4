<?php


namespace App\Service;


class GameTurnChecker
{
    private array $board;

    /**
     * @param array $board
     */
    public function setBoard(array $board)
    {
        $this->board = $board;
    }

    public function getTurn(): int
    {
        $allHoles = array_merge(...$this->board);
        $valuesCount = array_count_values($allHoles);

        if(!isset($valuesCount[1])){
            return 1;
        }
        if(!isset($valuesCount[2])){
            return 2;
        }
        if($valuesCount[2] == $valuesCount[1]){
            return 1;
        }
        return 2;

    }
}