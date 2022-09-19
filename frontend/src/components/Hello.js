import React, { useState } from 'react';

const Hello = (props) => {
    const [fname, setFname] = useState('');

    console.log('fname', fname);
    return(
        <>
            <h1>Hello {props.name}</h1>
            <p>{fname}</p>
            <input type="text" onChange={(e) => setFname(e.target.value)} value={fname} />
        </>
    );
}

export default Hello;