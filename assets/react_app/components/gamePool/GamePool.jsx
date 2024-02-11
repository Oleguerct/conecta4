import React, { useEffect, useState } from 'react'
import ShowGames from '../ShowGames.jsx';
import { GameContext } from '../../context/gameContext.jsx';
import { useContext } from 'react';
import fetchData from '../../services/fetchData.js';
import getFullPath from '../../../../src/Service/getFullPath.js';
import './GamePool.css';

function GamePool(){
    const context = useContext(GameContext)

    const handleSubmit = (e) => {
        e.preventDefault();
        let formData = new FormData(e.target);

        fetchData(getFullPath(`game/create/${formData.get('gameName')}`), data => {
            context.setGame(data);
        })
    }

    return (
        <div id='game-pool'>
            <div className='nes-container is-dark with-title'>
                <p className='title'>Game pool</p>
                <div className='nes-container is-dark with-title'>
                    <p className='title'>Create new</p>
                    <form method='POST' onSubmit={handleSubmit}>
                        <div className="nes-field">
                            <label htmlFor="gameName">Game name: </label>
                            <input type='text' name='gameName' className='nes-input'></input>
                        </div>
                        <button type='submit' className='nes-btn'>Create</button>
                    </form>
                </div>

                <ShowGames />
            </div>

        </div>
    )
}

export default GamePool