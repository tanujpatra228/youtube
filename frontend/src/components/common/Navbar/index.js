import React from 'react'
import { Link } from 'react-router-dom'

const Navbar = () => {
  const auth = localStorage.getItem('user');
  return (
    <div className='p-5 '>
        <ul className='flex gap-5 justify-end'>
            <li><Link to='/'>Home</Link></li>
            <li><Link to='/posts'>Posts</Link></li>
            {!auth ? (
              <li><Link to='/login'>Login</Link></li>
            ) : (
              <>
                <li><Link to='/add-post'>Add Post</Link></li>
                <li><Link to='/logout'>Logout</Link></li>
              </>
            )}
        </ul>
    </div>
  )
}

export default Navbar