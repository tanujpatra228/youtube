import React, { useEffect, useState } from 'react';
import style from './css/style.module.css';
import Child from './Child';

const Hello = (props) => {
    const [fname, setFname] = useState('');
    const [lname, setLname] = useState('');

    useEffect(()=>{
        console.log('Hello');
    }, [fname]);
    
    useEffect(()=>{
        console.log('Hello 2');
    });

    return(
        <>
            <h1 className={style.h1}>Hello {props.name}</h1>
            <Child />
            <p className={style.p}>{fname}</p>
            <input type="text" onChange={(e) => setFname(e.target.value)} value={fname} />
            <input type="text" onChange={(e) => setLname(e.target.value)} value={lname} />
        </>
    );
}

export default Hello;