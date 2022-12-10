import React from 'react'
import { Link } from 'react-router-dom'

const Navbar = () => {
  return (
    <div className='p-5 '>
        <ul className='flex gap-5 justify-end'>
            <li><Link to='/'>Home</Link></li>
            <li><Link to='/posts'>Posts</Link></li>
        </ul>
    </div>
  )
}

export default Navbar