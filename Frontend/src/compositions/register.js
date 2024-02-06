import axios from "axios";
import { ref } from "vue";
import auth from "./auth";

export default async function register(formData) {
  const passwordPattern = /^.{8,}$/;
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const requiredValues = ['name', 'email', 'password', 'confirm'];
  const data = {};
  const inputs = ['name', 'email', 'password', 'confirm'];
  const errMessages = [];
  const userLogged = ref(false) , userExist = ref(false), userData = ref({});
  const router = useRouter();
  const authUser = ref(false);
  onMounted(() => {  
    auth().then(res => authUser.value = res);
    authUser.value ? router.push('/') : '' 
  });

    // Validate Inputs
    inputs.map((value, index) => {
      data[value] = formData[value];
    });
    
    // check if required data is exist
    requiredValues.map((value) => {
      if (data[value] === 'undefined' || data[value] === 'null' || data[value] === '' || data[value] === null) {
        errMessages.push(`${value} shouldn't be empty`);
      }
    });

    // validate email
    if (data.email && !emailPattern.test(data.email)) {
      errMessages.push('The entered Email isn\'t correct');
    }
    // Validate password
    if (!passwordPattern.test(data.password)) {
      errMessages.push('The Minimum length of password should be 8 characters');
    }

    if (data.password !== data.confirm) {
      errMessages.push('The password and confirm password not identical');
    }

    if(errMessages.length <= 0){
        // Send request to server 
        const url = `${import.meta.env.VITE_API_URL}/register`;
        await axios.post(url, data) 
          .then((res) => {
              // Storing token and username
              userData.value = res.data;
              localStorage.setItem("userData",JSON.stringify(userData.value));
              userLogged.value = true;
          })
          .catch((err) => {
              userLogged.value = false;
              userExist.value = err.message = "The email has already been taken." ? true : false;
          });
    }
    return {
      errMessages,
      userLogged,
      userExist,
      userData
    }
}