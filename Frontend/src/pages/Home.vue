<script>
import { ref } from 'vue';
import Navbar from '../components/Navbar.vue';
export default {
    name: "Home",
    setup(){

    }    
}
</script>

<template>
    <div class="container w-100">
        <h1 class="text-center d-block text text-white"> Welcome To our blog</h1>

        <div class="cards d-flex flex-wrap justify-content-evenly mt-5">
            <router-link to="/categories">
                <div class="card" style="width: 18rem; height: 20rem;">
                    <img src="../assets/images/categories.png" class="card-img-top" alt="Categories">
                    <div class="card-body">
                        <h5 class="card-title">Categories</h5>
                        <p class="card-text">Check our post categories to find the topics that you are interested in.</p>
                        <a class="btn btn-primary" style="background-color: #5a52ff;">Read More</a>
                    </div>
                </div>
            </router-link>
            <router-link to="/posts">
                <div class="card" style="width: 18rem; height: 20rem;">
                    <img src="../assets/images/posts.jpg" class="card-img-top" alt="Posts">
                    <div class="card-body">
                        <h5 class="card-title">Posts</h5>
                        <p class="card-text">Browse all posts and know more about new recent features and add new posts</p>
                        <a class="btn btn-primary" style="background-color: #5a52ff;">Read More</a>
                    </div>
                </div>
            </router-link>

        </div>
    </div>
</template>

<style scoped>

</style>