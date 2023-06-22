import React from 'react'
import { useDispatch } from 'react-redux'
import { Link } from 'react-router-dom'
import { logout } from '../../../redux/slice/authSlice';

const Navbar = ({authUser}) => {
  // const auth = localStorage.getItem('user');
  const dispatch = useDispatch();
  
  console.log('authUser', authUser);
  return (
    <div className='p-5 '>
      <div className='max-w-5xl mx-auto flex justify-between items-center py-2'>

        <div>
          <Link to='/' className='text-2xl font-semibold'>IWS</Link>
        </div>

        <ul className='flex gap-5 justify-end'>
            <li><Link to='/'>Home</Link></li>
            <li><Link to='/posts'>Posts</Link></li>
            {!authUser?.token ? (
              <>
                <li><Link to='/login'>Login</Link></li>
                <li><Link to='/register'>Register</Link></li>
              </>
            ) : (
              <>
                <li><Link to='/add-post'>Add Post</Link></li>
                <li><button onClick={() => dispatch(logout())}>Logout</button></li>
                <li><Link to='/profile'>Hi {authUser.user_display_name}</Link></li>
              </>
            )}
        </ul>
        
      </div>
    </div>
  )
}

export default Navbar