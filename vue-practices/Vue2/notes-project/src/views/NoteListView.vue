<template>
    <RouterLink :to="{ name: 'create' }">Create new note</RouterLink>
    <button @click.prevent="logout" href="#">Logout</button>
    <table class="table" v-if="notes.length > 0">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Note</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="note in notes" :key="note.id">
                <th scope="row">{{ note.id }}</th>
                <td>{{ note.content }}</td>
            </tr>
        </tbody>
    </table>
    <p v-else>No data yet.</p>
</template>

<script lang="ts" setup>
import useAuth from '@/store/auth';
import { onMounted, Ref, ref } from 'vue';
import INote from '@/interfaces/INote';
import router from '@/router';
const store = useAuth();

const notes: Ref<Array<INote>> = ref([]);
onMounted(async () => {
    notes.value = await store.getNotes();
});

const logout = () => {
    store.logout();
    router.push({ name: 'login' });
};
</script>