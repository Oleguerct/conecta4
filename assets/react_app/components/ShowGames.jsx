import React, { useEffect, useState } from 'react'
import { GameContext } from '../context/gameContext.jsx';
import { useContext } from 'react';
import getMercureIRIUrl from '../services/mercureURLHandler.js';
import getFullPath from '../../../src/Service/getFullPath.js';

function ShowGames(){

    const [games, setGames] = useState([]);
    const context = useContext(GameContext)
    const [needUpdateGames, setNeedUpdateGames] = useState(true);

    useEffect(() => {
    
        if(!needUpdateGames) return;

        fetch(getFullPath('game/get_available'))
        .then((response) => response.json())
        .then((data) => {
            setGames(data)
            setNeedUpdateGames(false)
        })

    }, [needUpdateGames])

    useEffect(() => {
        const mercureIRIURL = getMercureIRIUrl(`https://example.com/games`);
        const eventSource = new EventSource(mercureIRIURL);
        eventSource.onmessage = event => {
            setNeedUpdateGames(true);
        }

        return () => eventSource.close();

    }, [])
    

    const joinGame = (id) => {
        fetch(getFullPath(`game/join/${id}`)) 
            .then((response) => response.json())
            .then(game => {
                context.setGame(game);
            })
    }

    return (
        <div id='game-list'>
            <div className='nes-container with-title is-dark'>
                <p className='title'>Available games</p>
                <div className='lists'>
                    <ul className='nes-list is-circle'>
                        {games.map(game => 
                            <li key={game.id}>
                                <label>
                                    Game: {game.title} - Started by {game.player1.username} <button className='nes-btn' onClick={() => {joinGame(game.id)}}>Join</button> 
                                </label>
                                
                            </li>)
                        }
                    </ul>
                </div>
            </div>
        </div>

    )
}

export default ShowGames