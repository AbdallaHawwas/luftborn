import axios from "axios";

export default async function auth() {
    let authUser = false;

    const token = localStorage?.userData ? JSON.parse(localStorage?.userData)?.token : null;
    // Check for access token 
    if(token){
    // Check for token expiration
    const url = `${import.meta.env.VITE_API_URL}/auth`;
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    await axios.get(url)
        .then(res => {
            authUser = true;
            console.log(res)
        })
        .catch(err => {
            authUser = false;
            console.log(err)
        });
    }else{
        authUser = false;
    }
    return authUser;
}