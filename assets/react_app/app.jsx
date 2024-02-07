import React, { useEffect, useState } from 'react'
import ReactDOM from 'react-dom/client'
import GamePool from './components/GamePool';
import LoginForm from './components/LoginForm';
import Game from './components/Game.jsx';
import { GameContext } from './context/gameContext.jsx';
import { useContext } from 'react';
import { GameContextWrapper } from './context/gameContext';

import "./app.css";



function App(){

    const context = useContext(GameContext);

    // Retrive session game if exist
    useEffect(() => {
        fetch('http://127.0.0.1:8000/user/current-game')
        .then(response => {
            if(!response.ok) return;
            response.json()
                .then(data => {
                    context.setGame(data)
                })
        })
    }, [])


    // Get user
    useEffect(() => {
        if(JSON.parse(window.sessionUser).userId){
            context.setUser(JSON.parse(window.sessionUser))
        }
    }, [])

    if (context.game) return <Game />
    
    if (context.user) return <GamePool/> 

    return <LoginForm/>
}

ReactDOM.createRoot(document.getElementById('root')).render(
    <React.StrictMode>
        <GameContextWrapper>
            <App />
        </GameContextWrapper>
    </React.StrictMode>,
)