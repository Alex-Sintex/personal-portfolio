<template>
    <p>I am the father.</p>
    <button @click="updateMsg">Update Message</button>
    <FirstChild></FirstChild>
</template>

<script setup>
import { provide, ref } from 'vue';
import FirstChild from './FirstChild.vue';

const msg = ref('Hello from fatther');
const updateMsg = () => {
    msg.value = "Msg updated"
}

// Provide the message to child components
provide('msg', msg);
</script>

<style scoped>
.example {
    color: red;
}
</style>
