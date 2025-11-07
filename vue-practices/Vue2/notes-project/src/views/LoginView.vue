<template>
    <form>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                placeholder="Enter email" v-model="email">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
                v-model="password">
        </div>
        <button @click.prevent="loginUser" type="submit" class="btn btn-primary">Submit</button>
        <p style="color:red;">{{ feedback }}</p>
    </form>
    <RouterLink :to="{ name: 'register' }">Create account</RouterLink>
</template>

<script lang="ts" setup>
import router from '@/router';
import useAuth from '@/store/auth';
import { ref } from 'vue';

const store = useAuth();
const email = ref('');
const password = ref('');
const feedback = ref('');

const loginUser = async () => {
    const response = await store.login(email.value, password.value);
    if (response === false) {
        feedback.value = "Login error"
    } else {
        router.push({ name: 'list' })
    }
}
</script>