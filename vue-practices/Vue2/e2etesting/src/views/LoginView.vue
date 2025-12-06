<template>
    <h1>Login</h1>
    <input type="text" placeholder="email" v-model="email" id="email"> <br>
    <input type="password" placeholder="password" v-model="password" id="password"> <br>
    <button @click="login">Login</button>
    <div v-if="!success">
        <p>Wrong email or password</p>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuth } from '@/store/useAuth';
import router from '@/router';

const store = useAuth();
const email = ref('');
const password = ref('');
const success = ref(false);

const login = () => {
    success.value = store.login(email.value, password.value);
    if (store.is_auth) {
        router.push('/');
    }
}
</script>