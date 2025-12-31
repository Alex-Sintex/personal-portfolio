<template>
  <ul>
    <li v-for="(item, index) in note.notes" :key="index">
      {{ item.title }}
    </li>
  </ul>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import NoteService from '~/services/NoteService'

const note = ref({
  notes: []
})

const noteService = new NoteService()

onMounted(async () => {
  const response = await noteService.GetNote()
  note.value.notes = response.notes
})
</script>
