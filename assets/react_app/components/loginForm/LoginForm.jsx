import React from 'react'
import { useContext } from 'react';
import { GameContext } from '../../context/gameContext.jsx'
import getFullPath from '../../../../src/Service/getFullPath.js';
import './LoginForm.css';

function LoginForm(){

    const context = useContext(GameContext);

    function submiLogin(e){
        e.preventDefault();
        let formData = new FormData(e.target);
        let name = formData.get('name');

        fetch(getFullPath('api/users'),{
            method: "POST",
            headers: {
                "Content-Type": "application/json",
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
        <div id='login-dialog' >
            <div className='nes-container with-title is-dark is-rounded'>
                <p className='title'>Enter a user name</p>
                <form onSubmit={submiLogin}>
                    <div className='nes-field'>
                        <label htmlFor="name">Your name</label>
                        <input type='text' name='name' placeholder='Jonny' className="nes-input"></input>
                    </div>
                    <button className="nes-btn">Login</button>
                </form>
            </div>
        </div>

    )
}

export default LoginForm