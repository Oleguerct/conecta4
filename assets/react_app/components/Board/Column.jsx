import React, { useEffect, useState } from 'react'

import Hole from './Hole.jsx';
import getFullPath from '../../../../src/Service/getFullPath.js';

function makeMovement(columnKey){
  console.log('MOVE!');
  fetch(getFullPath(`game/move/${columnKey}`))
    .then(response => {
      if(response.ok){
        return response.json()
      }
    })
    .then(data => {
      console.log(data)
    })
    .catch(error => {
      console.error('Error:', error.message);
      // Aquí pots gestionar l'error com vulguis, com mostrar un missatge a l'usuari, registrar-lo, etc.
    });
}

function Column({columnKey, columnValues,  winner, currentPlayer}){
    const isFull = columnValues[5] != 0;
    return (
      <div className='column'>
        {
          columnValues.map((state, index) => 
            <Hole key={index} holeState={state}></Hole>
          )
        }
        <button onClick={() => makeMovement(columnKey)} className='nes-btn' disabled={isFull || winner} >play</button>
      </div>
    )
  }

export default Column