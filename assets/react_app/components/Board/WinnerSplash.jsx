import React, { useEffect, useState } from 'react'
import { GameContext } from '../../context/gameContext'
import { useContext } from 'react';


const areYoyWinner = (game, user) => {
    if(game.winner === 1){
        return game.player1 && game.player1.id === user.id
    }else{
        return game.player2 && game.player2.id === user.id
    }
}


function WinnerSplash({ leftGame }){

    const context = useContext(GameContext);
    const game = context.game;
    const user = context.user;

    return (
        <div className="winnerSplash">
            {areYoyWinner(game, user) ? <h1>You win</h1> : <h1>You lose</h1>}
            <button className="ressetButton" onClick={leftGame}>Exit game</button>
        </div>
    )
}

export default WinnerSplash

