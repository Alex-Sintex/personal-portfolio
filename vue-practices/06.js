const app = new Vue({ // Crea una nueva instancia de Vue, que controlará parte del DOM
    el: '#app', // Asocia esta instancia de Vue con el elemento HTML con id 'app'
    data: { // Define el estado reactivo de la aplicación
        saludo: 'soy el ciclo de vida de Vue'
    },
    // Hooks del ciclo de vida
    beforeCreate() {
        console.log('Before create');
    },
    created() {
        console.log('Created');
    },
    beforeMount() {
        console.log('BeforeMount');
    },
    mounted() {
        console.log('Mounted');
    },
    beforeUpdate() {
        console.log('Before update');
    },
    updated() {
        console.log('Updated');
    },
    beforeDestroy() {
        console.log('BeforeDestroy');
    },
    destroyed() {
        console.log('Destroyed');
    },
    // Métodos personalizados
    methods: {
        destruir() {
            this.$destroy();
        }
    }
});