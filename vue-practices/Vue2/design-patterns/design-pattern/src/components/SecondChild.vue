<template>
    <h1>Child Component</h1>
    <p>{{ msg }}</p>
</template>

<script setup>
import { inject } from 'vue';

// Inject the message provided by the ancestor component
const msg = inject('msg');
</script>