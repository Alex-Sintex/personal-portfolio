<template>
    <h1>Blog section</h1>
    <ul>
        <li><router-link :to="{name: 'post', params: {id: 1}}">Primer post</router-link></li>
        <li><router-link :to="{name: 'post', params: {id: 2}}">Segundo post</router-link></li>
        <li><router-link :to="{name: 'post', params: {id: 3}}">Tercer post</router-link></li>
        <li><router-link :to="{name: 'post', params: {id: 4}}">Cuarto post</router-link></li>
    </ul>
</template>