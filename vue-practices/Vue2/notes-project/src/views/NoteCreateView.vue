<template>
    <form>
        <div class="form-group">
            <label for="note">My note</label>
            <input type="text" class="form-control" id="note" aria-describedby="noteHelp" placeholder="Enter note"
                v-model="note">
        </div>
        <button @click.prevent="sendNote" type="submit" class="btn btn-primary">Submit</button>
        <p style="color:red;">{{ feedback }}</p>
    </form>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import useAuth from '@/store/auth';
import router from '@/router';

const feedback = ref('');
const store = useAuth();
const note = ref('');

const sendNote = async () => {
    const response = await store.createNote(note.value);
    if (response === false) {
        feedback.value = "Error recording the note";
    } else {
        router.push({ name: 'list' });
    }
}
</script>