<template>
    <MainLayout>
        <h1>Contact section</h1>
    </MainLayout>
</template>

<script setup lang="ts">
import MainLayout from '@/layouts/MainLayout.vue';
import { useMouse } from '@/composables/useMouse';

const { x, y } = useMouse();
</script>