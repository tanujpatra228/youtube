import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

const Posts = () => {
    const [posts, setPosts] = useState([]);
    const [currentPage, setCurrentPage] = useState(1);
    const [totalPages, setTotalPages] = useState(1);
    const perPage = 9;
    useEffect(()=>{
        let url = `${process.env.REACT_APP_API_ROOT}/posts?per_page=${perPage}&page=${currentPage}`;
        axios.get(url).then((res)=>{
            const { data, headers } = res;
            setTotalPages(Number(headers['x-wp-totalpages']));
            setPosts(data);
        });
    }, [currentPage]);
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
        
        {/* Pagination */}
        <div className='w-3/12 py-10 m-auto flex justify-between items-center align-middle flex-wrap gap-10'>
            <button className='btn-primary p-2 bg-blue-500 text-white text-lg rounded-lg hover:shadow-lg disabled:opacity-50'
                disabled={currentPage === 1}
                onClick={() => setCurrentPage(currentPage-1)}
            >
                Previous
            </button>

            <span className='text-lg'>{currentPage} of {totalPages}</span>
            
            <button className='btn-primary p-2 bg-blue-500 text-white text-lg rounded-lg hover:shadow-lg disabled:opacity-50'
                disabled={currentPage === totalPages} 
                onClick={() => setCurrentPage(currentPage+1)}
            >
                Next
            </button>
        </div>
        </>
    )
}

export default Posts;