<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <div class="m-4">
        <h1>Hello {{ $page.props.auth.user.name }}</h1>
    </div>
</template>
