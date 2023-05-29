import { Link } from "react-router-dom";

const Card = ({post}) => {
  return (
    <>
      <div key={post.id} className='card bg-white p-3 w-full shadow-lg rounded-lg transition duration-300 ease-in-out hover:shadow-2xl'>
        <Link to={`/posts/${post.id}`} className="space-y-5">
          <img src={post.featured_src ? post.featured_src : 'https://via.placeholder.com/500'} alt={post.title.rendered} className="w-full h-64 object-cover" />
          <h2 className='text-lg font-bold line-clamp-1'>{post.title.rendered}</h2>
          <p className='line-clamp-3' dangerouslySetInnerHTML={{ __html: post.excerpt.rendered }}></p>
        </Link>
      </div>
    </>
  )
}

export default Card;