import React from 'react';
import { Routes, Route } from 'react-router-dom';
import Navbar from '../common/Navbar';
import Home from './Home';
import Posts from './Posts';

const Pages = () => {
  return (
    <>
      <Navbar />
      <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/posts" element={<Posts />} />
      </Routes>
    </>
  )
}

export default Pages