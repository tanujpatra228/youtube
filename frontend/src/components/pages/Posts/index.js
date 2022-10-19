import React, { useEffect, useState } from 'react';
import axios from 'axios';

const Posts = () => {
    const [posts, setPosts] = useState([]);
    useEffect(()=>{
        let url = 'http://localhost/wp-headless/server/wp-json/wp/v2/posts';
        axios.get(url).then((res)=>{
            setPosts(res.data);
        });
    }, []);
    console.log('posts', posts);

    return(
        <>
        {
            posts && posts.map((post)=>{
                console.log('posts', post);
                return <p key={post.id}>{post.title.rendered}</p>
            })
        }
        </>
    )
}

export default Posts;