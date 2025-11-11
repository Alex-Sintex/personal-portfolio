<template>
  <h1>Notas:</h1>
  <input type="text" v-model="note">
</template>

<script lang="ts" setup>
import { ref, watchEffect } from 'vue';

const note = ref('');
watchEffect(() => alert("Se ha modificado el valor: " + note.value))
</script>

<style></style>
