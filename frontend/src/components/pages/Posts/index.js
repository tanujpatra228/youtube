import React, { useEffect, useState } from 'react';
import axios from 'axios';
import Card from '../../common/Card';

const Posts = () => {
    const [posts, setPosts] = useState([]);
    const [currentPage, setCurrentPage] = useState(1);
    const [totalPages, setTotalPages] = useState(1);
    const perPage = 9;
    useEffect(() => {
        let url = `${process.env.REACT_APP_API_ROOT}/posts?per_page=${perPage}&page=${currentPage}`;
        axios.get(url).then((res) => {
            const { data, headers } = res;
            setTotalPages(Number(headers['x-wp-totalpages']));
            setPosts(data);
        });
    }, [currentPage]);
    console.log('posts', posts);

    return (
        <>
            <section className="bg-gray-100 p-5 min-h-screen">
                <div className="max-w-5xl mx-auto text-center">
                    <h1 className='text-2xl font-bold mb-4'>Posts</h1>
                    <div className='w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 xl:grid-cols-3 gap-10'>
                        {
                            Object.keys(posts).length ? posts.map(post => {
                                console.log('post', post);
                                return (
                                    <Card post={post} key={post.id} />
                                )
                            }) : <div className='col-span-3 w-5 h-5 absolute left-1/2 top-1/2 rounded-full border-2 border-b-0 border-blue-500 animate-spin' />
                        }
                    </div>

                    {/* Pagination */}
                    {
                        Object.keys(posts).length > 0 && (
                            <div className='w-1/2 py-10 m-auto flex justify-between items-center align-middle flex-wrap gap-10'>
                                <button className='btn-primary p-2 bg-blue-500 text-white text-lg rounded-lg hover:shadow-lg disabled:opacity-50'
                                    disabled={currentPage === 1}
                                    onClick={() => setCurrentPage(currentPage - 1)}
                                >
                                    Previous
                                </button>

                                <span className='text-lg'>{currentPage} of {totalPages}</span>

                                <button className='btn-primary p-2 bg-blue-500 text-white text-lg rounded-lg hover:shadow-lg disabled:opacity-50'
                                    disabled={currentPage === totalPages}
                                    onClick={() => setCurrentPage(currentPage + 1)}
                                >
                                    Next
                                </button>
                            </div>
                        )
                    }
                    {/* Pagination Ends */}

                </div>
            </section>
        </>
    )
}

export default Posts;