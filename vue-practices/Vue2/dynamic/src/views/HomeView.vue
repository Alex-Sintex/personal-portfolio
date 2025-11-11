<template>
  <h1>Listado de usuarios</h1>
  <input type="text" placeholder="Filtrar usuario" v-model="search" @keyup="handleSearch">
  <div>
    <button @click="handleLayout(ListLayout)">Ver en lista</button>
    <button @click="handleLayout(CardLayout)">Ver en tarjetas</button>
    <button @click="handleLayout(TableLayout)">Ver en tabla</button>
  </div>
  <component :is="layout" :content="filterUsers"/>
</template>

<script lang="ts" setup>
import { ref, defineAsyncComponent } from 'vue';

interface User {
  name: string;
  age: number;
  position: string;
}

const ListLayout = defineAsyncComponent(() => import ('@/layouts/ListLayout.vue'));
const TableLayout = defineAsyncComponent(() => import ('@/layouts/TableLayout.vue'));
const CardLayout = defineAsyncComponent(() => import ('@/layouts/CardLayout.vue'));

const layout = ref(ListLayout);

const handleLayout = (cmp: any) => layout.value = cmp;

const search = ref('');

const handleSearch = () => {
  filterUsers.value = users.value.filter(item => item.name.toLowerCase().includes(search.value.toLowerCase()));
}

const users = ref<User[]>([
  {
    name: "Luis",
    age: 30,
    position: "Frontend"
  },
  {
    name: "Ana",
    age: 25,
    position: "Backend"
  },
  {
    name: "Carlos",
    age: 28,
    position: "Fullstack"
  },
  {
    name: "Marta",
    age: 32,
    position: "DevOps"
  },
  {
    name: "Sofía",
    age: 27,
    position: "UI/UX Designer"
  }
]);

const filterUsers = ref<User[]>([]);

filterUsers.value = users.value;
</script>
