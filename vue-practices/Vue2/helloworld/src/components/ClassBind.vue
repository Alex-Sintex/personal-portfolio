<template>
    <p :style="{ backgroundColor: '#ccc', color: c }">El mensaje no se ha envíado satisfactoriamente.</p>
    <button @click="handleClick()">Cambiar color</button>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
export default defineComponent({
    name: 'ClassBind',
    setup() {
        let c = ref('#fff')
        const handleClick = () => { c.value = "#ff0000" }
        return { c, handleClick }
    }
})
</script>

<style></style>