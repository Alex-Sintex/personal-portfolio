<template>
    <h1>Porcentaje completado: {{ percentage }}%</h1>
</template>

<script lang="ts" setup>
import { onMounted, ref, defineExpose } from 'vue'
const percentage = ref(0)

onMounted(() => {
    // Traer el valor del porcentaje del servicio
    percentage.value = 24
})

const recalculate = () => {
    // Actaulizar el valor del porcentaje a traves del servicio
    percentage.value = 42
}

defineExpose({ recalculate })
</script>