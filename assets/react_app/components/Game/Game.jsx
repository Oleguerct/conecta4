import React, { useEffect, useState } from 'react'
import Board from '../Board/Board.jsx'
import { useContext } from 'react';
import { GameContext } from '../../context/gameContext.jsx'
import WinnerSplash from '../Board/WinnerSplash.jsx';
import getMercureIRIUrl from '../../services/mercureURLHandler.js';
import TurnInfo from '../TournInfo.jsx';
import getFullPath from '../../../../src/Service/getFullPath.js';
import './Game.css';

function Game(){
    console.log('Game component rendered');
    const context = useContext(GameContext);

    const subscribeToMercure = () => {
        let evtSrc;
        const mercureIRIURL = getMercureIRIUrl(`https://example.com/game/${context.game.id}`);
        evtSrc = new EventSource(mercureIRIURL);
        console.log('creating new event source');
        evtSrc.onmessage = (event) => {
            console.log('event received');
            const data = JSON.parse(event.data);
            console.log(data);
            context.setGame(data);
        }

        return () => {
            evtSrc.close();
            console.log('closing event source');
        }
    };

    useEffect(subscribeToMercure, [context.game.winner]);

    const leftGame = () =>{
        fetch(getFullPath('user/left-game'))
        .then(response => {
            if(!response.ok) return;
            response.json()
                .then(data => {
                    context.setGame(null)
                })
        })
    }


    return (
        <div className='game'>
            <div className='header'>
                { !context.game.winner && (
                    <div className='nes-container is-dark with-title'>
                        <TurnInfo/>
                        <button onClick={leftGame}>Surrender</button>
                    </div>
                )}
            </div>
            { context.game.winner && <WinnerSplash leftGame={leftGame} />}
            <Board/>
        </div>
    ) 
}

export default Game