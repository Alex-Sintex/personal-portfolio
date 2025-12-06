<template>
    <div>
        <h3>{{ props.title }}</h3>
        <p>{{ props.content }}</p>
        <button @click="clickMe">Click me</button>
    </div>
</template>

<script setup>
const props = defineProps(['title', 'content'])
const emit = defineEmits(['clickMe'])
const clickMe = () => {
    emit('clickMe', 1)
}
</script>

<style scoped></style>