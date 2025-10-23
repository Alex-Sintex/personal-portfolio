<template>
    <div class="container">
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
            <button type="submit" class="btn btn-primary mt-2" @click.prevent="authUser">Submit</button>
        </form>
    </div>
</template>

<script lang="ts" setup>
import AuthService from '@/services/AuthService';
import { ref } from 'vue';

let email = ref("")
let password = ref("")

const authUser = async () => {
    const auth = new AuthService()
    const success = await auth.login(email.value, password.value)
    if (success) {
        alert('Éxito!')
    } else {
        alert('Login incorrecto')
    }
}
</script>