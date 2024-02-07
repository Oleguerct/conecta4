import React, { useEffect, useState } from 'react'
import { useContext } from 'react';
import { GameContext } from '../context/gameContext.jsx'

function LoginForm(){

    const context = useContext(GameContext);

    function submiLogin(e){
        e.preventDefault();
        let formData = new FormData(e.target);
        let name = formData.get('name');

        fetch('http://127.0.0.1:8000/api/users',{
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                // 'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: JSON.stringify({'username': name})
        })
        .then((response) => response.json())
        .then((data) => {
            console.log(data)
            context.setUser(data);
        })

    }
    return (
        <form onSubmit={submiLogin}>
            <label>
                <p>Enter a user name</p>
                <input type='text' name='name' placeholder='Jonny'></input>
            </label>
            <button>Login</button>
        </form>
    )
}

export default LoginForm