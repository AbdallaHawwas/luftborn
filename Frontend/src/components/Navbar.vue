<script>
import { computed, onMounted, ref } from 'vue';
import { useStore } from 'vuex';
import * as bootstrap from 'bootstrap'
import auth from '../compositions/auth';

export default {
    name: "Navbar",
    setup(){
        const store = useStore();
        const authUser = ref(false);
        const username = ref('')
        onMounted(() => {  auth().then(res => authUser.value = res) });
        username.value = localStorage?.userData ? JSON.parse(localStorage.userData).name : '';
        
        return{ authUser, username }
    }    
}
</script>

<template>
    <nav class="navbar navbar-dark d-flex align-items-center justify-content-start">
  <div class="container-fluid">
        <div class="d-flex justify-content-evenly align-items-center">
            <router-link class="navbar-brand navbar-light" to="/">
                <img src="../assets/images/logo.svg" alt="" width="50" height="50" style="border-radius: 50%;">
                <span class="mx-3">Luftborn</span>
            </router-link>
            <router-link class="mx-3" to="/categories">Categories</router-link>
            <router-link class="mx-3" to="/Posts">Posts</router-link>
        </div>
        <div class="d-flex justify-content-evenly align-items-center" v-if="!authUser">
            <router-link class="mx-3" to="/login">Login</router-link>
            <router-link class="mx-3" to="/register"><button class="btn btn-primary mx-3" style="background-color: #5a52ff;">Register</button></router-link>
        </div>
        <div class="d-flex justify-content-evenly align-items-center" v-else>
            Welcome, {{ username  }}
        </div>
  </div>
</nav>
<Login />
<Register />
</template>

<style scoped>
    nav {
        position: fixed;
        z-index: 10000;
        top: 0;
        min-height: 10%;
        margin: 0;
        width: 100%;
        border-bottom: 1px solid #fff;
        font-weight: 900;
    }
    a {
        color: #fff !important;
    }
</style>