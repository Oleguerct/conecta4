import React, { useEffect, useState } from 'react'
import { GameContext } from '../../context/gameContext'
import { useContext } from 'react';

function WinnerSplash(){

    const context = useContext(GameContext);
    const game = context.game;

    return (
        <div className="winnerSplash">
            <h1>Have a winner</h1>
            <button className="ressetButton" onClick={() => {ressetGame()}}>Exit game</button>
        </div>
    )
}

export default WinnerSplash