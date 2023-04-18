import { Navigate, Outlet } from 'react-router-dom';

const ProtectedRoute = ({ authUser }) => {

    if (!authUser?.token) {
        return <Navigate to={'/login'} />
    }

    return (
        <>
            <Outlet/>
        </>
    )
}

export default ProtectedRoute;