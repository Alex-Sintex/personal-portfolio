<template>
    <h1>Social Login</h1>
    <button @click="loginGoogle">Login with Google</button>
    <button>Login with Facebook</button>
    <button>Login with Twitter</button>
    <button @click="loginGithub">Login with Github</button>
</template>

<script setup>
import { GithubAuthProvider ,getAuth, GoogleAuthProvider, signInWithPopup } from 'firebase/auth';
const googleprovider = new GoogleAuthProvider()
const githubProvider = new GithubAuthProvider()
const auth = getAuth()

const loginGoogle = () => {
    signInWithPopup(auth, googleprovider)
        .then((result) => {
            const credential = GoogleAuthProvider.credentialFromResult(result)
            const token = credential?.accessToken;
            alert("Success!")
        })
        .catch((error) => {
            alert("Login Failed")
        })
}

const loginGithub = () => {
    signInWithPopup(auth, githubProvider)
    .then((result) => {
        const credential = GithubAuthProvider.credentialFromResult(result)
        const token = credential?.accessToken;
        alert("Success!")
    })
    .catch((error) => {
        alert("Login Failed!")
    })
}
</script>