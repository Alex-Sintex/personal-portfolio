<template>
  <div id="app" class="container">
    <CabeceraComponent></CabeceraComponent>
    <ListaComponent></ListaComponent>
  </div>
</template>

<script>
import CabeceraComponent from './components/CabeceraComponent.vue'
import ListaComponent from './components/ListaComponent.vue'

export default {
  name: 'app',
  components: {
    CabeceraComponent,
    ListaComponent
  }
}
</script>
