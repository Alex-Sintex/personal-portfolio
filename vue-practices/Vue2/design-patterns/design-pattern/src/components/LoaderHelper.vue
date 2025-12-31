<template>
    <div v-if="!data">Loading...</div>
    <component v-else :is="props.componentToShow" :data="data" />
</template>

<script setup>
import { ref, defineProps, onMounted } from 'vue'
const props = defineProps(['url', 'componentToShow'])
const data = ref()

onMounted(async () => {
    data.value = await fetch(props.url)
}) 
</script>

<style scoped></style>