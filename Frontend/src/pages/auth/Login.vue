<script>
import { onMounted, ref } from 'vue';
import login from '../../compositions/login';
import { useStore } from 'vuex';
import auth from '../../compositions/auth';
import { useRouter } from 'vue-router';

export default {
    name: "Login",
    setup(){
      const loader = ref(false)
      const result = ref({});
      const store = useStore();
      const formData = ref({ "name_email":"", "password":"" });
      const router = useRouter();
      const authUser = ref(false);

      onMounted(() => {  
        auth().then(res => authUser.value = res);
        setTimeout(() => { authUser.value ? router.push('/') : '' }, 2000) 
      });

      const loginUser = () => {
        const userLogged = ref(false), userExist = ref(false), userData = ref({});
        // send data
        login(formData.value)
        .then(res => {
          loader.value = true;
          userLogged.value = res.userLogged;
          userData.value = res.userData;
          userExist.value = res.userExist;
          
          // Store user info
          store.dispatch("loginUser", (userLogged.value ? userData.value.value : null));
          result.value = {
            success :  userLogged.value,
            msg : userLogged.value ? "Account logged in successfully" : (!userExist.value ? "This user isn't exist": "Something went error \n Please Check your inputs and try again"),
          }
          location.reload()
        }).catch((err) => {
          userLogged.value = false; 
          result.value = {
            success :  userLogged.value,
            msg : "Something went error \n Please Check your inputs and try again",
          }
        });



          // unset loader and results
          setTimeout(() => {
            loader.value = false;
            result.value = {};
          },3000);
      };
    return { loginUser, formData, loader, result }
    }

}
</script>

<template>
    <!-- Loader (Spinner) -->
    <div class="loader d-block w-100 mx-auto" v-if="loader && Object.entries(result).length <= 0">
      <div class="spinner-grow text-light" role="status">
    </div><br>
    <span class="mt-3 d-block">Loading...</span>
    </div>
    
    <!-- Form Submit results -->
    <div class="container" v-else-if="Object.entries(result).length > 0">
      <div :class="'results d-block w-75 mx-auto text-center alert alert-' + (result.success ? 'success' : 'danger')">
        {{ result.msg }}
      </div>
    </div>
    
    <div v-else class="container">
      <!-- Login Form -->
      <form method="post" id="login-form" @submit.prevent="loginUser" class="w-50 d-block mx-auto">
        <div class="my-3 form-floating">
          <input type="text" v-model="formData.name_email" class="form-control" name="name_email" id="name_email" placeholder="Name Or Email" required>
            <label for="name_email">Name or Email</label>
        </div>
        <br>
        <div class="my-3 form-floating">
          <input type="password" class="form-control" v-model="formData.password" id="password" name="password" placeholder="Password" required>
          <label for="password">Password</label>
        </div>
        <div class="mt-5">
          <button class="btn btn-primary" type="submit">Submit</button>
        </div>
        </form>
    </div>
      </template>

<style scoped>
label {
  color: rgb(113, 113, 113);
}
</style>