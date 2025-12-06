<template>
    <img v-lazy="{ src: lazyOptions.src, lifecycle: lazyOptions.lifecycle, delay: lazyOptions.delay }" lazy="loading" />
</template>

<script lang="ts" setup>
import { ref, VNode } from 'vue';

const lazyOptions = ref({
    src: 'https://picsum.photos/200/300',
    delay: 500,
    lifecycle: {
        loading: (el: VNode) => {
            console.log('cargando imagen', el)
        },
        error: (el: VNode) => {
            console.log('error en la caga', el)
        },
        loaded: (el: VNode) => {
            console.log('imagen cargada', el)
        }
    }
})
</script>

<style>
    img[lazy=loading] {
        width: 150px;
        background-color: antiquewhite;
    }
</style>