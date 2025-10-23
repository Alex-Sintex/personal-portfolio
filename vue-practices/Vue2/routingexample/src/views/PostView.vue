<template>
    <h1>PostView del elemento: {{ postId }}</h1>
</template>

<script setup>
import { computed } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute()
const postId = computed(() => route.params.id)
</script>