import axios from 'axios';
import React, { useEffect, useState } from 'react'
import { useParams } from 'react-router-dom';

const Single = () => {
    const { id } = useParams();
    const [post, setPost] = useState({});

    useEffect(()=>{
        // axios
        let url = `${process.env.REACT_APP_API_ROOT}/posts/${id}`;
        axios.get(url).then(res => {
            console.log('res', res);
            setPost(res.data);
        }).catch(err => {
            console.log('error:', err.message);
        });
    }, []);
    return (
        <>
            {
                Object.keys(post).length ? (
                    <div className='p-5'>
                        <div className='max-w-md'>
                            <img className='w-full' src={post.featured_src} />
                        </div>
                        <div>
                            <h1 className='text-2xl font-bold'>
                                {post.title.rendered}
                            </h1>
                        </div>
                        <div dangerouslySetInnerHTML={{__html:post.content.rendered}}></div>
                    </div>
                ) : ('Loading....')
            
            }
        </>
    )
}
export default Single;