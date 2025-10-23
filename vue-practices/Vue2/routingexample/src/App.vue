<template>
  <nav>
    <router-link to="/">Home</router-link> |
    <router-link to="/about">About</router-link> |
    <router-link to="/services">Services</router-link> |
    <router-link to="/blog">Blog</router-link> |
    <router-link to="/contact">Contact</router-link>
  </nav>
  <router-view />
</template>

<style lang="scss">
.router-link-active {
  font-weight: bold;
}

a {
  display: inline-block;
  padding: 10px 20px;
  background-color: #ecf0f1;
  border-radius: 5px;
  text-decoration: none;
}
</style>
