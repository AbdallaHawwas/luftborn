import axios from "axios";
import { ref } from "vue";

export default async function login(formData) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const data = { password: formData.password }

    // Check For data exist
    if(formData.name_email === '' || formData.password === ''){
        return false;
    }

    // identify for name or email
    if(emailPattern.test(formData.name_email)){
      data["email"] = formData.name_email;
    }else{
      data["name"] = formData.name_email
    }
    
    // Send request to server 
    const url = `${import.meta.env.VITE_API_URL}/login`;
    const userLogged = ref(false), userExist = ref(false), userData = ref({});
    await axios.post(url, data)
      .then((res) => {
          // Storing token and username
            userData.value = res.data;
            localStorage.setItem("userData",JSON.stringify(userData.value));
            userLogged.value = true;
      })
      .catch((err) => {
            userLogged.value = false;
            userExist.value = (err.message === "User doesn't exist" ? false : true);
      });
      return {
        userLogged,
        userExist,
        userData
      }
}