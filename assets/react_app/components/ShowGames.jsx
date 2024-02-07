import React, { useEffect, useState } from 'react'
import { GameContext } from '../context/gameContext.jsx';
import { useContext } from 'react';
import getMercureIRIUrl from '../services/mercureURLHandler.js';

function ShowGames(){

    const [games, setGames] = useState(null);
    const context = useContext(GameContext)
    const [needUpdateGames, setNeedUpdateGames] = useState(true);

    useEffect(() => {
    
        if(!needUpdateGames) return;

        fetch('http://127.0.0.1:8000/api/games')
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
        fetch(`http://127.0.0.1:8000/game/join/${id}`) 
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
        <>
            {games && (
                <ul>
                    {games.map(game => 
                        <li key={game.id}>
                            <button onClick={() => {joinGame(game.id)}}>Join</button> {game.title}
                        </li>)
                    }
                </ul>
            )}
        </>
    )
}

export default ShowGames