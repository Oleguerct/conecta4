<?php


namespace App\Service;


class CheckBoardWinnerService
{
    public function checkWinner(array $board): int|false
    {
        if($winner = $this->checkSecondaryDiagonal($board)) return $winner;
        if($winner = $this->checkPrimaryDiagonal($board)) return $winner;
        if($winner = $this->checkVertical($board)) return $winner;
        if($winner = $this->checkHorizontal($board)) return $winner;
        return false;
    }


    private function checkPrimaryDiagonal(array $board): int|false
    {
        $xSize = sizeof($board);
        $ySize = sizeof($board[0]);

        for($xi = 0; $xi < $xSize - 3; $xi++){
            for($yi = 0; $yi < $ySize - 3; $yi++){
                if($board[$xi][$yi] == 0) continue;
                if(
                    $board[$xi][$yi] == $board[$xi+1][$yi+1] &&
                    $board[$xi][$yi] == $board[$xi+2][$yi+2] &&
                    $board[$xi][$yi] == $board[$xi+3][$yi+3]

                ) return $board[$xi][$yi];
            }
        }
        return false;
    }

    private function checkSecondaryDiagonal(array $board): int|false
    {
        $xSize = sizeof($board);
        $ySize = sizeof($board[0]);

        for($xi = 0; $xi < $xSize - 3; $xi++){
            for($yi = 3; $yi < $ySize; $yi++){
                if($board[$xi][$yi] == 0) continue;
                if(
                    $board[$xi][$yi] == $board[$xi+1][$yi-1] &&
                    $board[$xi][$yi] == $board[$xi+2][$yi-2] &&
                    $board[$xi][$yi] == $board[$xi+3][$yi-3]

                ) return $board[$xi][$yi];
            }
        }
        return false;
    }

    private function checkHorizontal(array $board): int|false
    {
        $xSize = sizeof($board);
        $ySize = sizeof($board[0]);

        for ($yi = 0; $yi < $ySize - 1; $yi++){
            $previousPlayer = null;
            $count = 0;
            for ($xi = 0; $xi < $xSize - 1; $xi++){
                $hole = $board[$xi][$yi];
                if($hole == 0) continue;
                if($hole == $previousPlayer){
                    $count++;
                }else{
                    $previousPlayer = $hole;
                    $count = 1;
                }
                if($count == 4) return $hole;
            }
        }
        return false;
    }

    private function checkVertical(array $board): int|false
    {
        foreach ($board as $row){
            $previousPlayer = null;
            $count = 0;
            foreach ($row as $hole){
                if ($hole == 0) continue;
                if($hole == $previousPlayer){
                    $count++;
                }else{
                    $previousPlayer = $hole;
                    $count = 1;
                }
                if($count == 4) return $hole;
            }
        }
        return false;
    }
}