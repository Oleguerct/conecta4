import React, { useEffect, useState } from 'react'
import Board from './Board/Board'
import { useContext } from 'react';
import { GameContext } from '../context/gameContext.jsx'
import WinnerSplash from './Board/WinnerSplash.jsx';

function Game(){

    const context = useContext(GameContext);

    function leftGame(){
        fetch('http://127.0.0.1:8000/user/left-game')
        .then(response => {
            if(!response.ok) return;
            response.json()
                .then(data => {
                    context.setGame(null)
                })
        })
    }

    function renderTurnInfo(){

        let currentPlayerslug = `player${context.game.turn}ID`;
        let currentPlayerID = context.game[currentPlayerslug];

        if(context.game.players.length < 2) return <h4>Waiting for oponent</h4>

        if(currentPlayerID == context.user.id){
            return <h3>You</h3>
        }else{
            return <h3>L'altre</h3>
        }

    }


    return (
        <>
            <div>
                <button onClick={leftGame}>Surrender</button>
                <div>
                    { !context.game.winner && renderTurnInfo()}
                </div>
            </div>
            { context.game.winner && <WinnerSplash/>}
            <Board/>
        </>
    ) 
}

export default Game