import React from 'react';
import { Routes, Route } from 'react-router-dom';
import Navbar from '../common/Navbar';
import Home from './Home';
import Login from './Login';
import Posts from './Posts';
import Single from './Single';
import AddPost from './AddPost';
import ProtectedRoute from './ProtectedRoute';
import { useSelector } from 'react-redux';

const Pages = () => {
  const authUser = useSelector((state) => state.auth.user);
  return (
    <>
      <Navbar authUser={authUser} />
      <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/posts" element={<Posts />} />
          <Route path="/posts/:id" element={<Single />} />
          <Route path="/login" element={<Login />} />

          <Route element={<ProtectedRoute authUser={authUser} />}>
            <Route path="/add-post" element={<AddPost />} />
            <Route path="/profile" element={<div>Profile Page</div>} />
          </Route>

      </Routes>
    </>
  )
}

export default Pages