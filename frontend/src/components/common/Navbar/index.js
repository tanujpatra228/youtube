import React from 'react'
import { Link } from 'react-router-dom'

const Navbar = () => {
  const auth = localStorage.getItem('user');
  return (
    <div className='p-5 '>
      <div className='max-w-5xl mx-auto flex justify-between items-center py-2'>

        <div>
          <Link to='/' className='text-2xl font-semibold'>IWS</Link>
        </div>

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
    </div>
  )
}

export default Navbar