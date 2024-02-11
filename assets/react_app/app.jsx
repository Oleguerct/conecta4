import React, { useEffect, useState } from 'react'
import ReactDOM from 'react-dom/client'
import Spinner from './components/Spinner.jsx';
import GamePool from './components/gamePool/GamePool.jsx';
import LoginForm from './components/loginForm/LoginForm.jsx';
import Game from './components/Game/Game.jsx';
import { GameContext } from './context/gameContext.jsx';
import { useContext } from 'react';
import { GameContextWrapper } from './context/gameContext';
import fetchData from './services/fetchData.js';
import getFullPath from '../../src/Service/getFullPath.js';
import "./app.css";


function App(){
    const context = useContext(GameContext);
    const [userFetched, setUserFetched] = useState(false);
    const [gameFetched, setGameFetched] = useState(false);

    useEffect(() => {
        console.log('Full path:', getFullPath('user/current-game'));
        fetchData(getFullPath('user/current-game'), data => {
            context.setGame(data);
        })
        .then(() => setGameFetched(true))

        fetchData(getFullPath('user/get_by_session'), data => {
            context.setUser(data);
        })
        .then(() => setUserFetched(true))
    }, [])

    if (!userFetched || !gameFetched) return <Spinner/>            

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