<script>
import { ref } from 'vue';
import register from '../../compositions/register';
import { useStore } from 'vuex';

export default {
    name: "Register",
    setup(){
        const formData = ref({'name':'','email':'','password':'','confirm':''})
        const loader = ref(false);
        const result = ref({});
        const response = ref({});
        const store = useStore();
        
        const registerUser = async () => { 
            response.value = await register(formData.value).then(res => res);
            // Validation errors
            if(response.value.errMessages.length > 0){
                result.value = {
                    success : false, 
                    msg : response.value.errMessages[0]
                }
            }
            // If user is exist
            else if(response.value.userExist){
                result.value = {
                    success : false,
                    msg : "This user is alredy exist please login with your credientials"
                }
            }
            // Failed to add user
            else if(!response.value.userLogged){
                result.value = {
                    success : false, 
                    msg : "Failed to add user , Please try again"
                }
            }
            else{
                // Success
                result.value = {
                    success : true, 
                    msg : "Account added successfully"
                }
                location.reload()
                store.dispatch("loginUser",response.value.userData);
            }
            // Remove loader and result value
            setTimeout( () => { loader.value = false; result.value = {}; },3000)
        };
        
        return { formData, registerUser, loader, result }
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
        <form method="post" class="w-50 d-block mx-auto" @submit.prevent="registerUser">
            <div class="my-3 form-floating">
                <input type="text" class="form-control" v-model="formData.name" id="name" placeholder="Name">
                <label for="name">Name</label>
            </div>
            <div class="my-3 form-floating">
                <input type="text" class="form-control" id="email" v-model="formData.email" placeholder="Email">
                <label for="email">Email</label>
            </div>
            <div class="my-3 form-floating">
                <input type="password" class="form-control" id="password" v-model="formData.password" placeholder="Password">
                <label for="password">Password</label>
            </div>
            <div class="my-3 form-floating">
                <input type="password" class="form-control" id="confirm" v-model="formData.confirm" placeholder="Confirm Password">
                <label for="confirm">Confirm Password</label>
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