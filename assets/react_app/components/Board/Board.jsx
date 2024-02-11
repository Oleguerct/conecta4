import React, { useEffect, useState } from 'react'
import Column from './Column.jsx';
import { useContext } from 'react';
import { GameContext } from '../../context/gameContext.jsx';
import './Board.css';

function Board(){ 
  
  const context = useContext(GameContext)

  return (
    <>
      <div className='board'>
          <div className='columns'>
          {
              context.game.board.map((columnValues, index) => 
                <Column key={index} columnKey={index} columnValues={columnValues} winner={null} currentPlayer={1}></Column>
              )
          }
        </div>
      </div>
    </>
  )
}

export default Board