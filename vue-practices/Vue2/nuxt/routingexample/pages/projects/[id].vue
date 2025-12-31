<template>
    <NuxtLayout name="projects">
        <h1>Project number: {{ projectId }}</h1>
    </NuxtLayout>
</template>

<script setup>
definePageMeta({
    layout: 'projects'
})
const route = useRoute();
const projectId = ref()
projectId.value = route.params.id

const changeLayout = () => {
    setPageLayout("default")
}
</script>