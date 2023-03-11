import React from 'react'
import { useFormik } from 'formik';
import * as Yup from 'yup';
import axios from 'axios';

const Login = () => {
    const formik = useFormik({
        // Initial values
        initialValues: {
            email: '',
            password: ''
        },

        // Validation Schema
        validationSchema: Yup.object({
            email: Yup.string().required().email(),
            password: Yup.string().required().min(4),
        }),

        // On Submit
        onSubmit: (data) => {
            const {email , password} = data;
            axios.post(`${process.env.REACT_APP_API_AUTH_TOKEN}`, {
                "username": email,
                "password": password
            }).then((res)=>{
                console.log('response', res);
                if (res.status === 200 && res.statusText === "OK") {
                    localStorage.setItem('user', JSON.stringify(res.data));
                    alert(res.data.user_nicename);
                }
            }).catch((err)=>{
                console.log('error:', err.message);
            });
        }
    });

    return (
        <>
            <section className="h-screen">
                <div className="container px-6 py-12 h-full">
                    <div className="flex justify-center items-center flex-wrap h-full g-6 text-gray-800">
                        <div className="md:w-8/12 lg:w-6/12 mb-12 md:mb-0">
                            <img
                                src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
                                className="w-full"
                                alt=""
                            />
                        </div>
                        <div className="md:w-8/12 lg:w-5/12 lg:ml-20">
                            <h1 className='font-bold text-6xl text-center mb-5'>Login</h1>
                            <form onSubmit={formik.handleSubmit}>
                                <div className="mb-6">
                                    <input
                                        type="email"
                                        className="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        placeholder="Email address"
                                        name="email"
                                        value={formik.values.email}
                                        onChange={formik.handleChange}
                                    />
                                </div>

                                <div className="mb-6">
                                    <input
                                        type="password"
                                        className="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        placeholder="Password"
                                        name="password"
                                        value={formik.values.password}
                                        onChange={formik.handleChange}
                                    />
                                </div>

                                <button
                                    type="submit"
                                    className="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out w-full"
                                    data-mdb-ripple="true"
                                    data-mdb-ripple-color="light"
                                >
                                    Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </>
    )
}

export default Login;