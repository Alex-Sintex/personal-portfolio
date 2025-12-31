<template>
  <div>
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </div>
</template>

<style>
.nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  background-color: #333;
  color: #fff;
}

.nav__list {
  display: flex;
  list-style: none;
  padding: 0;
  margin: 0;
}

.nav__item {
  margin-right: 1rem;
}

.nav__link {
  text-decoration: none;
  color: inherit;
}

.nav__link:hover {
  opacity: 0.7;
}
</style>

<script setup>
</script>
