import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

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
        <h1 className='text-2xl font-bold'>Posts</h1>
        <div className='w-4/5 py-10 m-auto flex justify-between align-middle flex-wrap gap-10'>
        {
            Object.keys(posts).length ? posts.map(post => {
                console.log('post', post);
                return (
                    <div key={post.id} className='card p-3 w-[330px] shadow-lg rounded-lg flex gap-5 flex-col'>
                        <Link to={`/posts/${post.id}`}>
                            <img src={post.featured_src ? post.featured_src : 'https://via.placeholder.com/500'} alt={post.title.rendered} />
                            <h2 className='text-lg font-bold'>{post.title.rendered}</h2>
                            <p dangerouslySetInnerHTML={{__html: post.excerpt.rendered}}></p>
                        </Link>
                    </div>
                )
            }) : 'Loading...'
        }
        </div>
        </>
    )
}

export default Posts;