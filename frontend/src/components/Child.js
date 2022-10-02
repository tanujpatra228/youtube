import React, { useEffect } from "react";

const Child = () => {
    useEffect(()=>{
        console.log('Child');
    }, []);
    return <h1>Hi from child</h1>
}
export default Child;