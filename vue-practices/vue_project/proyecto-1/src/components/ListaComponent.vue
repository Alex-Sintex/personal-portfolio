<template>
    <div>
        <ul class="list-group">
            <li v-for="(item, index) of arrayOrdenado" :key="item.id" @click="aumentar(index)"
                class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">{{ index }} - {{ item.nombre }}</div>
                </div>
                <span class="badge text-bg-primary rounded-pill">{{ item.cantidad }}</span>
            </li>
        </ul>
        <div class="d-grid gap-2">
            <button @click="reiniciar" class="btn btn-danger btn-block">Reiniciar</button>
        </div>
    </div>
</template>

<script>

import { mapState, mapMutations } from 'vuex';

export default {
    name: 'ListaComponent',
    computed: {
        ...mapState(['frutas']),
        arrayOrdenado() {
            return [...this.frutas].sort((a, b) => b.cantidad - a.cantidad)
        }
    },
    methods: {
        ...mapMutations(['aumentar', 'reiniciar'])
    }

}
</script>