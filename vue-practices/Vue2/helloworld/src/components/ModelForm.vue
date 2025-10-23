<template>
    <form>
        <input type="text" v-model="InpuText">
        <input type="checkbox" v-model="agree"> Acepto los términos y condiciones
        <select v-model="country">
            <option value="Mexico">Mexico</option>
            <option value="Spain">Spain</option>
            <option value="France">France</option>
        </select>
    </form>
</template>

<script lang="ts" setup>

import { ref } from 'vue';

let InpuText = ref('')
let agree = ref(true)
let country = ref('Mexico')
</script>

<style scoped></style>