<template>
  <MainLayout>
    <template #main>
      <h5>Main content</h5>
    </template>
    <template #aux>
      <p>X position is {{ x }}, Y position is {{ y }}</p>
    </template>
  </MainLayout>
</template>

<script lang="ts" setup>
import { useMouse } from '@/composables/useMouse';
import MainLayout from '@/layouts/MainLayout.vue';

const { x, y } = useMouse();
</script>