<template>
    <div class="post-card">
        <h3>Título</h3>
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum ullam voluptates corrupti error optio
            eligendi, eaque saepe omnis quaerat eum eveniet! Eveniet voluptatem laboriosam doloribus ut ipsa eos quo
            exercitationem.
        </p>
        <PostButton></PostButton>
    </div>
</template>

<script lang="ts" setup>
import PostButton from './PostButton.vue';
</script>

<style scoped>
.post-card {
    border-radius: 15px;
    padding: 10px;
    margin: 5px;
    border: 1px solid #ccc;
}
</style>