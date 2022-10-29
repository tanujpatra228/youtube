import React, { useEffect, useState } from 'react';
import axios from 'axios';

const Posts = () => {
    const [posts, setPosts] = useState([]);
    useEffect(()=>{
        let url = `${process.env.REACT_APP_API_ROOT}/posts`;
        axios.get(url).then((res)=>{
            setPosts(res.data);
        });
    }, []);
    console.log('posts', posts);

    return(
        <>
        {
            posts && posts.map(post => {
                console.log('post', post);
                return (
                    <div key={post.id}>
                        <h2>{post.title.rendered}</h2>
                        <p dangerouslySetInnerHTML={{__html: post.excerpt.rendered}}></p>
                    </div>
                )
            })
        }
        </>
    )
}

export default Posts;