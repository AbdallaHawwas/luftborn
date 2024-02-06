<script>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import auth from '../../compositions/auth';

export default {
    name: "NewPost",
    setup(){
      const loader = ref(false)
      const result = ref({});
      const formData = ref({ "title":"", "content":"" });
      const authUser = ref(false);
      const router = useRouter();
      
      onMounted(() => {  auth().then(res => authUser.value = res) });
      
      let postAdded;
      const addPost = async () => {
        // Check For data exist
        if(formData.title === '' || formData.content === ''){
            postAdded = false;
        }
        axios.defaults.headers.common['Authorization'] = `Bearer ${JSON.parse(localStorage.userData).token}`;
        const url = `${import.meta.env.VITE_API_URL}/posts`;
        await axios.post(url, formData.value)
        .then((res) => {
            postAdded = true;
            setTimeout(() => location.href = "/posts",2000)
        })
        .catch((err) => {
            postAdded = false;
        });
        result.value = {
            success : postAdded,
            msg : postAdded ? "Post Added successfully" : "Something went error \n Please Check your inputs and try again",
        }
        setTimeout(() => { 
            loader.value = false;
            result.value = {};
            postAdded = false;
            formData.value = { "title":"", "content":"" }
            }, 3000)

    }
      return { formData, loader, result, addPost, authUser, router }
    }
}
</script>

<template>
        <!-- User Not logged in  -->
    <div class="container" v-if="!authUser">
      <div :class="'auth d-block w-75 mx-auto text-center'">
        <h3>You Have to Login First to Add a Post</h3>
        <router-link to="/login" class="btn btn-primary">Login Page</router-link>
      </div>
    </div>        
        <!-- Loader (Spinner) -->
        <div class="loader d-block w-100 mx-auto" v-else-if="authUser && loader && Object.entries(result).length <= 0">
      <div class="spinner-grow text-light" role="status">
    </div><br>
    <span class="mt-3 d-block">Loading...</span>
    </div>
    
    <!-- Form Submit results -->
    <div class="container" v-else-if="authUser && Object.entries(result).length > 0">
      <div :class="'results d-block w-75 mx-auto text-center alert alert-' + (result.success ? 'success' : 'danger')">
        {{ result.msg }}
      </div>
    </div>

    <div class="container" v-else>
        <h2 class="d-block text-center mx-auto my-5">New Post</h2>
        <form method="post" class="w-75 mx-auto" @submit.prevent="addPost">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="title" name="title" required v-model="formData.title" placeholder="Post Title">
                <label for="title">Post Title</label>
            </div>
            <div class="form-floating">
                <textarea class="form-control" placeholder="Add Your Content" style="height: 200px;" required maxlength="250" v-model="formData.content" id="content"></textarea>
                <label for="content">Content</label>
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