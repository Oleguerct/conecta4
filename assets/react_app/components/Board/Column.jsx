import React, { useEffect, useState } from 'react'

import Hole from './Hole.jsx';
import { colorMap } from '../../constants/constants.js'


function makeMovement(columnKey){
  console.log('MOVE!');
  fetch(`http://127.0.0.1:8000/game/move/${columnKey}`)
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
        <button onClick={() => makeMovement(columnKey)} className={`button ${colorMap[currentPlayer]}`} disabled={isFull || winner} >Add<br></br> token</button>
      </div>
    )
  }

export default Column