<template>
    <ul>
        <li v-for="country in countries" :key="country.code">{{ country.name }}</li>
    </ul>
</template>

<script lang="ts" setup>
import { Ref, ref } from 'vue';

interface ICountry {
    code: string,
    name: string
}
let countries: Ref<Array<ICountry>> = ref([
    {
        code: 'es',
        name: 'Spain'
    },
    {
        code: 'en',
        name: 'UK'
    },
    {
        code: 'fr',
        name: 'France'
    },
    {
        code: 'mx',
        name: 'Mexico'
    }
])
</script>
<style scoped></style>
