<script setup>
import { ref, computed } from 'vue'
const name = "Vue dinámico";
//const styleColor = "color: blue";
//const arrayColores = ["blue", "red", "peru"];
//const activo = true;
//const arrayFrutas = ["🍅", "🍌", "🍉", "🍓", "🍒"];
// Array de objetos
/*const arrayFrutas = [
  {
    name: "Manzana",
    price: "$1.00",
    description: "Una manzana",
    id: 1
  },
  {
    name: "Pera",
    price: "$2.00",
    description: "Una pera",
    id: 2
  },
  {
    name: "Naranja",
    price: "$3.00",
    description: "Una naranja",
    id: 3
  }
];*/
/*const objetoFruta = {
  name: "Manzana",
  price: "$1.00",
  description: "Una manzana",
  id: 1,
};*/
/*const arrayFrutas = [
  {
    name: "Manzana",
    price: "$1.00",
    description: "Una manzana",
    stock: 0,
  },
  {
    name: "Pera",
    price: "$2.00",
    description: "Una pera",
    stock: 10,
  },
  {
    name: "Naranja",
    price: "$3.00",
    description: "Una naranja",
    stock: 20,
  },
];*/
// Método - methods
/*const handleClick = (message) => {
  console.log(message);
}*/
// Variable reactiva
const counter = ref(0);

const arrayFavoritos = ref([]);

const increment = () => counter.value++;

const decrement = () => counter.value--;

const reset = () => (counter.value = 0);

const add = () => {
  arrayFavoritos.value.push(counter.value);
}

const bloquearBtnAdd = computed(() => {
  const numSearch = arrayFavoritos.value.find(num => num === counter.value);
  // if (numSearch === 0) return true;
  // return numSearch ? true : false;
  return numSearch || numSearch === 0;
});

// Esta función (computed) siempre debe retornar algo
const classCounter = computed(() => {
  if (counter.value === 0) {
    return 'zero';
  }
  if (counter.value > 0) {
    return 'positive';
  }
  if (counter.value < 0) {
    return 'negative';
  }
});
</script>

<template>
  <div class="container text-center mt-3">
    <!-- INTERPOLACIÓN -->
    <h1>Hola {{ name.toLocaleUpperCase() }}</h1>
    <h2 :class="classCounter">{{ counter }}</h2>
    <div class="btn-group">
      <button @click="increment" class="btn btn-success">Increment</button>
      <button @click="decrement" class="btn btn-danger">Decrement</button>
      <button @click="reset" class="btn btn-secondary">Reset</button>
      <button @click="add" :disabled="bloquearBtnAdd" class="btn btn-primary">Add</button>
    </div>
    <ul class="list-group mt-4">
      <li class="list-group-item" v-for="(num, index) in arrayFavoritos" :key="index">{{ num }}</li>
    </ul>
  </div>
  <!--<button v-on:click.right.prevent="handleClick('Texto Right')">Activame right</button>
  <button @click="handleClick('Texto Left')">Activame left</button>
  <button @click.middle="handleClick('Texto Middle')">Activame middle</button>-->
  <!--<ul>
    <template v-for="item in arrayFrutas" :key="item.name">
      <li v-if="item.stock > 0">{{ item.name }} - {{ item.price }}</li>
    </template>
</ul>-->
  <!--<ul>
    <li v-for="(value, propiedad, index) in objetoFruta" :key="index">
      {{ index }} - {{ propiedad }} : {{ value }}
    </li>
  </ul>-->
  <!-- SE PUEDE INTERPRETAR TEXTO ENTRE LLAVES {{ variable }} -->
  <!--<h2>{{ arrayColores }}</h2>-->
  <!-- ATRIBUTOS REQUIEREN ":" O "v-bind:style" -->
  <!--<h2 :style="`color: ${arrayColores[2]}`">Soy Perú</h2>-->
  <!-- OPERADOR TERNARIO -->
  <!--<h2>
    {{ activo ? "Estoy activo" : "Estoy inactivo" }}
  </h2>-->
  <!-- DEBE ESTAR CERCA DE LA CONDICIÓN SIEMPRE -->
  <!--<h2 v-if="activo === true">
    <span>Icono</span>
    Estoy activo
  </h2>
  <p v-else-if="activo === false">Estoy inactivo</p>
  <p v-else>Estoy indéciso</p>

  <h2 v-show="activo">Estoy activo v-show</h2>-->

</template>

<style>
.positive {
  color: green;
}

.negative {
  color: red;
}

.zero {
  color: peru;
}
</style>