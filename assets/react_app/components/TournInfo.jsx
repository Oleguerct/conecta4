import React, {useContext} from 'react';
import { GameContext } from '../context/gameContext';

function TurnInfo(){
    const context = useContext(GameContext);

    if(context.game.currentPlayerID === null) return (<p>Waiting for opponent to join</p>)

    if(context.game.currentPlayerID === context.user.id){
        return <p>Your turn</p>
    } else {
        console.log(context)
        console.log(`Opponent turn because ${context.game.currentPlayerID} !== ${context.user.id}`)
        return <p>Opponent's turn</p>
    }
}

export default TurnInfo