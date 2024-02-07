import React, { useEffect, useState } from 'react'
import ShowGames from './ShowGames';
import { GameContext } from '../context/gameContext.jsx';
import { useContext } from 'react';
import getMercureIRIUrl from '../services/mercureURLHandler.js';

function GamePool(){
    const context = useContext(GameContext)

    function createGame(e){
        e.preventDefault();
        let formData = new FormData(e.target);

        fetch(`http://127.0.0.1:8000/game/create/${formData.get('gameName')}`)
            .then((response) => response.json())
            .then(game => {
                context.setGame(game);
                const mercureIRIURL = getMercureIRIUrl(`https://example.com/game/${game.id}`);
                const eventSource = new EventSource(mercureIRIURL);
                eventSource.onmessage = event => {
                    console.log(event.data);
                    context.setGame(JSON.parse(event.data));
                }
            })
    }


    return (
        <div>
            <form method='POST' onSubmit={createGame}>
                <input type='text' name='gameName'></input>
                <button type='submit'>Create Game</button>
            </form>
            <ShowGames />
        </div>
    )
}

export default GamePool