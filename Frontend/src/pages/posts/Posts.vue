<script>
import { onMounted,ref } from 'vue';
import axios from 'axios';

export default {
    name: "Posts",
    setup(){
        const posts = ref([]);
        
        const getposts = async () => {
            const url = `${import.meta.env.VITE_API_URL}/posts`;
            axios.get(url)
            .then( res => {
                posts.value = res.data.posts.slice().reverse()
            })
            .catch(err => {
                console.log(err)
            })
        }

        onMounted(() => getposts());
        return{ posts }
    }
}
</script>

<template>
    <div class="container position-relative mb-5">
        <router-link class="btn btn-primary position-absolute" style="right: 20px;top: -60px;" :to="{name:'NewPost'}">Add Another Post</router-link>

        <div class="posts">
            <div class="text-center mx-auto" v-if="posts.length <= 0"> No Posts added !</div>
            <div v-for="post in posts" :key="post.id" v-else class="post my-5">
                <router-link :to="{name:'PostDetails', params:{id: post.id}}">
                    <div class="d-flex justify-content-between">
                        <h3 class="">{{ post.title }}</h3>
                        <span>{{ post.user.name }}</span>
                    </div>
                    <div class="content text-start ellipsis">
                        {{ post.content }}
                    </div>
                </router-link>

            </div>
        </div>
    </div>
</template>

<style scoped>
a { 
    color: unset;
}

.ellipsis {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 100%;
}

.post:not(:last-of-type) {
    border-bottom: 2px #fff solid;
    padding-bottom: 3rem;
}
</style>