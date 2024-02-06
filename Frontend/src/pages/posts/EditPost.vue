<script>
import { effect, onMounted, onUpdated, reactive, ref, watchEffect } from 'vue';
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router';
import auth from '../../compositions/auth';

export default {
    name: "PostDetails",
    setup(){
        const route = useRoute();
        const loader = ref(false)
        const result = ref({});
        const formData = ref({ "title":"", "content":"" });
        const postId = route.params.id;
        const authUser = ref(false);
        
        onMounted(() => {  auth().then(res => authUser.value = res) });

        const getpost = async () => {
            const url = `${import.meta.env.VITE_API_URL}/posts/${postId}`;
            axios.get(url)
            .then( res => {
                formData.value  = res.data.post
            })
            .catch(err => {
                console.log(err)
            })
        }

        watchEffect(getpost());

        const EditPost = async () => {
        // Check For data exist
        if(formData.title === '' || formData.content === ''){
            return;
        }
        let postAdded = false;
        axios.defaults.headers.common['Authorization'] = `Bearer ${JSON.parse(localStorage.userData).token}`;
        const url = `${import.meta.env.VITE_API_URL}/posts/${postId}`;
        await axios.put(url, {title: formData.value.title, content: formData.value.content})
        .then((res) => {
            postAdded = true;
            result.value = {
                success : postAdded,
                msg :"Post Edited successfully" ,
            }
        })
        .catch((err) => {
            postAdded = false;
            result.value = {
                success : postAdded,
                msg : "Something went error \n Please Check your inputs and try again",
            }
        });

        setTimeout(() => { 
            loader.value = false;
            result.value = {};
            postAdded = false;
        }, 3000)
        console.log(result.value);
    }

        return { authUser, loader, result, formData, EditPost }
    }
}
</script>

<template>
    <div class="container position-relative mb-5">

        <div class="container" v-if="!authUser">
      <div :class="'auth d-block w-75 mx-auto text-center'">
        <h3>You Have to Login First to Add a Post</h3>
        <router-link to="/login" class="btn btn-primary">Login Page</router-link>
      </div>
    </div>        
        <!-- Loader (Spinner) -->
        <div class="loader d-block w-100 mx-auto" v-if="authUser && loader && Object.entries(result).length <= 0">
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

    <div class="container" v-else-if="authUser && Object.entries(result).length == 0">
        <h2 class="d-block text-center mx-auto my-5">Edit Post : {{ formData.title }}</h2>
        <form method="post" class="w-75 mx-auto" @submit.prevent="EditPost">
            <div class="form-floating mb-3">
                <input type="text" v-model="formData.title" class="form-control" id="title" name="title" required  placeholder="Post Title">
                <label for="title">Post Title</label>
            </div>
            <div class="form-floating">
                <textarea class="form-control" v-model="formData.content" placeholder="Add Your Content" style="height: 200px;" required maxlength="250" id="content"></textarea>
                <label for="content">Content</label>
            </div>
            <div class="mt-5">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
    </div>
    </div>
</template>

<style scoped>
label {
  color: rgb(113, 113, 113);
}
</style>