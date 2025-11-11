<template>
  <TransitionGroup name="list" tag="ul">
    <li v-for="note in notes" :key="note"><v-icon name="ai-conversation" title="My icon" hover="true" animation="spin"></v-icon>{{ note }}</li>
  </TransitionGroup>
  <input type="text" v-model="note">
  <button @click="handleNote">Save note</button>
</template>

<script setup>
import { ref } from 'vue';

const notes = ref([])
const note = ref('')
const handleNote = () => {
  notes.value.push(note.value)
  note.value = ''
}
</script>

<style scoped>
.list-enter-active, .list-leave-active {
  transition: all 0.5s ease;
}

.list-enter-from, .list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}
</style>
