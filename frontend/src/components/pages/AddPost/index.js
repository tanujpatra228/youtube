import React from 'react';
import { useFormik } from 'formik';
import * as Yup from 'yup';
import axios from 'axios';

const AddPost = ({ authUser }) => {
    const formik = useFormik({
        // Initial values
        initialValues: {
            title: '',
            content: '',
            featured_image: null,
        },

        // Vlidations
        validationSchema: Yup.object({
            title: Yup.string().required(),
            content: Yup.string().required(),
            featured_image: Yup.mixed().required(),
        }),

        // Submit
        onSubmit: async (data) => {
            const { token } = authUser;
            const headers = {
                Authorization: `Bearer ${token}`,
            };
            const formData = new FormData();
            formData.append('title', data.title);
            formData.append('content', data.content);

            if (data.featured_image) {
                // Featured Image
                formData.append('featured_img', data.featured_image);
            }

            const response = await axios.post(`${process.env.REACT_APP_API_ROOT}/create-post`, formData, {
                    headers: headers,
                    'Content-Type': 'multipart/form-data'
                });

            console.log('response', response);
        }
    });

    return (
        <>
            <div className="container mx-auto py-10">
                <h1 className="text-3xl font-bold mb-5">Create a New Post</h1>
                <form onSubmit={formik.handleSubmit}>
                    <div className="mb-5">
                        <label className="block text-gray-700 font-bold mb-2" htmlFor="post-title">
                            Post Title
                        </label>
                        <input
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="post-title"
                            type="text"
                            placeholder="Enter post title"
                            name="title"
                            value={formik.values.title}
                            onChange={formik.handleChange}
                        />
                    </div>
                    <div className="mb-5">
                        <label className="block text-gray-700 font-bold mb-2" htmlFor="post-content">
                            Post Content
                        </label>
                        <textarea
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            name="content"
                            placeholder="Enter post content"
                            onChange={formik.handleChange}
                            value={formik.values.content}
                        ></textarea>
                    </div>
                    <div className="mb-5">
                        <label className="block text-gray-700 font-bold mb-2" htmlFor="post-title">
                            Featured Image
                        </label>
                        <input
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="post-title"
                            type="file"
                            name="featured_image"
                            // value={formik.values.featured_image}
                            onChange={(e) => formik.setFieldValue('featured_image', e.target.files[0])}
                        />
                    </div>
                    <input type='submit' className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" value='Create Post' />
                </form>
            </div>
        </>
    )
}

export default AddPost