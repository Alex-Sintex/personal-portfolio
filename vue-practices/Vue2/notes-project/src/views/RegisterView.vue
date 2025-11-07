<template>
    <form>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" aria-describedby="username"
                placeholder="Enter username" v-model="name">
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" aria-describedby="email"
                placeholder="Enter email" v-model="email">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password" v-model="password">
        </div>
        <button @click.prevent="createUser" type="submit" class="btn btn-primary">Submit</button>
        <p style="color:red;">{{ feedback }}</p>
    </form>
    <RouterLink :to="{ name: 'login' }">Login</RouterLink>
</template>

<script lang="ts" setup>
import router from '@/router';
import useAuth from '@/store/auth';
import { ref } from 'vue';
const store = useAuth();
const name = ref('');
const email = ref('');
const password = ref('');
const feedback = ref('');

const createUser = async () => {
    feedback.value = "Sending...";
    const response = await store.register(name.value, email.value, password.value);
    if(response === false){
        feedback.value = 'Registration error';
    } else {
        router.push({name: 'list'})
    }
}
</script>