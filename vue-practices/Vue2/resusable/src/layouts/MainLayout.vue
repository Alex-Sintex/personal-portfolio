<template>
    <div class="container">
      <div class="auxbar">
        <AuxBar />
      </div>
      <div class="main-content-container">
        <div class="menu">
          <MenuSidebar />
        </div>
      </div>
      <div class="main-content">
        <slot name="main"></slot>
      </div>
      <div class="aux-content">
        <slot name="aux"></slot>
      </div>
    </div>
</template>

<script lang="ts" setup>
import AuxBar from '@/components/AuxBar.vue';
import MenuSidebar from '@/components/MenuSidebar.vue';
</script>