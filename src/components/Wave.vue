<template>
  <svg class="wave" viewBox="0 0 1400 60" preserveAspectRatio="none" aria-hidden="true">
    <path d="M0,60c0,0,420-90,700-30s700-30,700-30v60H0z" fill="currentColor" />
  </svg>
</template>

<style scoped>
.wave {
  color: var(--wave-color);
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 32px;
  pointer-events: none;
  display: block;
  z-index: 2;
}
</style>
