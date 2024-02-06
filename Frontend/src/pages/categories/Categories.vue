<script>
import { onMounted, ref } from 'vue';
import axios from 'axios';

export default {
    name: "Categories",
    setup(){
        const categories = ref([]);

        const getCategories = async () => {
            const url = `${import.meta.env.VITE_API_URL}/categories`;
            axios.get(url)
            .then( res => {
                categories.value = res.data.categories
            })
            .catch(err => {
                console.log(err)
            })
        }

        onMounted(() => getCategories());

        return{ categories }
    }    
}
</script>

<template>
    <div class="container">
        <h1 class="text-center d-block fw-bold"> Categories </h1>
        <div v-if="categories.length > 0" class="cards row">
            <div class="card m-3" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Category title</h5>
                    <router-link to="/CategoryDetails" class="btn btn-primary">Explore</router-link>
                </div>
            </div>
            <div class="card m-3" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Category title</h5>
                    <router-link to="/CategoryDetails" class="btn btn-primary">Explore</router-link>
                </div>
            </div>
            <div class="card m-3" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Category title</h5>
                    <router-link to="/CategoryDetails" class="btn btn-primary">Explore</router-link>
                </div>
            </div>
            <div class="card m-3" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Category title</h5>
                    <router-link to="/CategoryDetails" class="btn btn-primary">Explore</router-link>
                </div>
            </div>
        </div>
        <div v-else class="empty m-5">
            <h6> No categories added </h6>
        </div>
    </div>
</template>

<style scoped>

</style>