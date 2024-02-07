import React from 'react';
import { useState } from 'react';


export const GameContext = React.createContext(null);

export const GameContextWrapper = (props) => {
	const [ game, setGame ] = useState(null);
	const [user, setUser] = useState(null);
	
	return (
		<GameContext.Provider value={{ game, setGame, user, setUser }}>
			{props.children}
		</GameContext.Provider>
	);
}

