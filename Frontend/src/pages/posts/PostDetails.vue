<script>
import { effect, onMounted, onUpdated, reactive, ref, watchEffect } from 'vue';
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router';
import auth from '../../compositions/auth';

export default {
    name: "PostDetails",
    setup(){
        const route = useRoute();
        const postId = route.params.id;
        const post = ref({});
        const authUser = ref(false);
        const result = ref({});
        const router = useRouter();

        onMounted(() => {  auth().then(res => authUser.value = res) });

        const getpost = async () => {
            const url = `${import.meta.env.VITE_API_URL}/posts/${postId}`;
            axios.get(url)
            .then( res => {
                post.value = res.data.post
            })
            .catch(err => {
                console.log(err)
            })
        }

        watchEffect(getpost());

        const deletePost = () => {
            let del = confirm("Do you want to delete this post ?");
            if(del){
                const url = `${import.meta.env.VITE_API_URL}/posts/${postId}`;
                axios.delete(url)
                .then( res => {
                    result.value = {
                        success: true,
                        msg: "Post Deleted Successfully"
                    }
                    console.log(res)
                    setTimeout( () => {
                        result.value = {}; 
                        location.href = "/posts" 
                    },2000);
                })
                .catch(err => {
                    console.log(err)
                })
            }
        }

        return { post, authUser, deletePost }
    }
}
</script>

<template>
    <div class="container position-relative mb-5">
        <router-link class="btn btn-primary position-absolute fw-bold" style="right: 20px;top: -50px;" :to="{name:'NewPost'}">Add Another Post</router-link>
        <div class="position-absolute d-flex flex-wrap w-50" style="left: 20px; top: -60px;">
            <a  class="btn btn-danger m-2 fw-bold" @click.prevent="deletePost">Remove Post</a>
            <router-link class="btn btn-warning m-2 fw-bold" :to="{name:'EditPost', params:{id: post.id}}">Edit Post</router-link>
        </div>

        <h2 class="d-block text-center mx-auto my-5">{{ post.title }}</h2>
        <p class="text-justify d-inline-block mx-auto">{{ post.content }}</p>
    </div>
</template>

<style scoped>

</style>