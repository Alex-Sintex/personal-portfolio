<template>
    <div class="container mt-4">

        <!-- Alerta Bootstrap (si hay mensaje) -->
        <div v-if="alertMessage" :class="['alert', alertType, 'alert-dismissible', 'fade', 'show']" role="alert">
            <strong>{{ alertTitle }}</strong> {{ alertMessage }}
            <button type="button" class="btn-close" @click="closeAlert" aria-label="Close"></button>
        </div>

        <form>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    placeholder="Enter email" v-model="email" />
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
                    v-model="password" />
            </div>
            <button type="submit" class="btn btn-primary mt-2" @click.prevent="authUser">Submit</button>
        </form>
    </div>
</template>


<script lang="ts" setup>
import { ref } from 'vue'
import { getAuth, signInWithEmailAndPassword } from 'firebase/auth'

// Campos del formulario
const email = ref("")
const password = ref("")

// Estado de alerta
const alertMessage = ref("")
const alertTitle = ref("")
const alertType = ref("alert-warning") // o alert-success, alert-danger, etc.

// Cierra la alerta
const closeAlert = () => {
    alertMessage.value = ""
    alertTitle.value = ""
    alertType.value = "alert-warning"
}

const authUser = () => {
    const auth = getAuth()
    signInWithEmailAndPassword(auth, email.value, password.value)
        .then(() => {
            alertTitle.value = "¡Éxito!"
            alertMessage.value = "Inicio de sesión exitoso."
            alertType.value = "alert-success"
        })
        .catch((error) => {
            alertTitle.value = "¡Error!"
            alertMessage.value = error.message
            alertType.value = "alert-danger"
        })
}
</script>
