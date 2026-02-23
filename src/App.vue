<template>
  <!-- PRELOADER -->
  <div id="loader-wrapper">
    <div class="loader-center">
      <img src="/favicons/favicon-32x32.png" alt="Logo" class="loader-logo" />
      <div class="loader-ring"></div>
    </div>

    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>

  <!-- GLOBAL TOAST -->
  <transition name="toast">
    <div v-if="toast.show" :class="['toast', toast.type]">
      {{ toast.message }}
    </div>
  </transition>

  <!-- SITE -->
  <div class="site">
    <Navbar />

    <section id="home" class="hero-section">
      <Hero />
      <Wave />
    </section>

    <section id="about" class="content-section primary">
      <About />
      <Wave />
    </section>

    <section id="portfolio" class="content-section secondary">
      <Portfolio />
      <Wave />
    </section>

    <section id="services" class="content-section primary">
      <Services />
      <Wave />
    </section>

    <section id="updates" class="content-section secondary">
      <Updates />
      <Wave />
    </section>

    <section id="contact" class="content-section primary">
      <Contact />
    </section>

    <Footer />
  </div>
</template>

<script setup>
import { ref, reactive, provide, onMounted, onUnmounted } from 'vue'

/* =====================
   COMPONENTS
===================== */
import Navbar from './components/Navbar.vue'
import Hero from './components/Hero.vue'
import About from './components/About.vue'
import Portfolio from './components/Portfolio.vue'
import Services from './components/Services.vue'
import Updates from './components/Updates.vue'
import Contact from './components/Contact.vue'
import Footer from './components/Footer.vue'
import Wave from './components/Wave.vue'

/* =====================
   THEME
===================== */
const theme = ref(localStorage.getItem('theme') || 'light')

function setTheme(mode) {
  theme.value = mode
  document.body.classList.toggle('dark', mode === 'dark')
  localStorage.setItem('theme', mode)
}

provide('theme', theme)
provide('setTheme', setTheme)

/* =====================
   TOAST
===================== */
const toast = reactive({
  show: false,
  type: 'success',
  message: ''
})

function showToast(type, message) {
  toast.type = type
  toast.message = message
  toast.show = true

  setTimeout(() => {
    toast.show = false
  }, 3500)
}

provide('showToast', showToast)

/* =====================
   FADE-IN OBSERVER
===================== */
let observer = null
function initFadeIn() {
  const faders = document.querySelectorAll('.fade-in-section')

  observer = new IntersectionObserver(
    entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible')
          observer.unobserve(entry.target)
        }
      })
    },
    { threshold: 0.3 }
  )

  faders.forEach(el => observer.observe(el))
}

/* =====================
   PRELOADER
===================== */
function initPreloader() {
  document.body.style.overflow = 'hidden'
  window.addEventListener('load', () => {
    setTimeout(() => {
      document.body.classList.add('loaded')
      document.body.style.overflow = ''
    }, 1000)
  })
}

/* =====================
   MOUNT / UNMOUNT
===================== */
onMounted(() => {
  setTheme(theme.value)
  initPreloader()
  initFadeIn()
})

onUnmounted(() => {
  if (observer) observer.disconnect()
})
</script>

<style>
/* =========================
   THEME VARIABLES
========================= */
:root {
  --hero-text: #ffffff;
  --hero-text-muted: #e5e7eb;
  --hero-cursor: #ffffff;
  --hero-arrow: #ffffff;
  --hero-overlay: rgba(0, 0, 0, 0.25);

  --bg-primary: #ffffff;
  --bg-secondary: #e5e5e5;
  --bg-main: #f9f9f9;
  --bg-section: #ffffff;
  --bg-navbar: transparent;
  --bg-navbar-scrolled: #111111;

  --text-main: #1f1f1f;
  --tool-icon-bg: #ffffff;
  --text-muted: #555;
  --text-inverse: #ffffff;
  --text-highlight: #1f1f1f;

  --card-bg: #ffffff;
  --border-color: #e5e5e5;

  --toast-success: #064e3b;
  --toast-error: #d73802;

  --wave-shadow: #e5e5e5;
  --wave-main: #e5e5e5;
  --wave-bg: #e5e5e5;
  --wave-footer-bg: #e5e5e5;
  --wave-footer: #ffffff;

  --orbit-badge-bg: #111111;
  --orbit-badge-text: #ffffff;

  /* PRELOADER */
  --loader-bg: #111111;
  --loader-ring: #3c3c3c;
}

body.dark {
  --hero-text: #f9fafb;
  --hero-text-muted: #d1d5db;
  --hero-cursor: #f9fafb;
  --hero-arrow: #f9fafb;
  --hero-overlay: rgba(0, 0, 0, 0.45);

  --bg-primary: #1f1f1f;
  --bg-secondary: #333;
  --bg-main: #121212;
  --bg-section: #1a1a1a;
  --bg-navbar-scrolled: #1a1a1a;

  --text-main: #eaeaea;
  --tool-icon-bg: #f9fafb;
  --text-muted: #aaaaaa;
  --text-highlight: #f9fafb;

  --card-bg: #1f1f1f;
  --border-color: #333;

  --toast-success: #10b981;
  --toast-error: #f87171;

  --wave-shadow: #1f1f1f;
  --wave-main: #1f1f1f;
  --wave-bg: #1f1f1f;
  --wave-footer: #1a1a1a;

  --orbit-badge-bg: #ffffff;
  --orbit-badge-text: #111111;

  --loader-bg: #0b0b0b;
  --loader-ring: #aaa;
}

/* =========================
   BASE
========================= */
html,
body {
  margin: 0;
  padding: 0;
  scroll-behavior: smooth;
  background: var(--bg-main, #f9f9f9);
  color: var(--text-main, #1f1f1f);
  width: 100%;
  overflow-x: hidden;
}

body {
  overflow-x: hidden;
}

/* =========================
   SECTION BASE
========================= */
.content-section>* {
  background: transparent !important;
}

.hero-section,
.content-section {
  position: relative;
  overflow: hidden;
}

.hero-section {
  height: 100vh;
}

/* Default (hero safety) */
section {
  --wave-color: transparent;
}

/* Light mode */
.content-section.primary {
  background: var(--bg-primary);
  --wave-color: var(--bg-secondary);
}

.content-section.secondary {
  background: var(--bg-secondary);
  --wave-color: var(--bg-primary);
}

/* Dark mode */
body.dark .content-section.primary {
  background: #1a1a1a;
  --wave-color: #121212;
}

body.dark .content-section.secondary {
  background: #121212;
  --wave-color: #1a1a1a;
}

/* =========================
   FADE IN
========================= */
.fade-in-section {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.6s ease, transform 0.6s ease;
}

.fade-in-section.visible {
  opacity: 1;
  transform: translateY(0);
}

/* Wave must overlap hero */
.hero-section .wave-bottom {
  position: absolute;
  bottom: -1px;
  left: 0;
  width: 100%;
  z-index: 5;
}

/* =========================
   SITE
========================= */
.site {
  position: relative;
  z-index: 1;
}

/* =========================
   PRELOADER
========================= */
#loader-wrapper {
  position: fixed;
  inset: 0;
  z-index: 9999;
  pointer-events: none;
}

/* CENTER (LOGO + RING) */
.loader-center {
  position: fixed;
  inset: 0;
  display: grid;
  place-items: center;
  z-index: 1002;
  opacity: 1;
  transition: opacity 0.4s ease;
}

/* STATIC LOGO */
.loader-logo {
  width: 42px;
  z-index: 2;
  pointer-events: none;
}

/* RING (ONLY THIS SPINS) */
.loader-ring {
  position: absolute;
  width: 90px;
  height: 90px;
  border-radius: 50%;
  border: 5px solid transparent;
  border-left-color: var(--loader-ring);
  border-bottom-color: var(--loader-ring);
  animation: spin 1.4s linear infinite;
}

/* CURTAINS */
#loader-wrapper .loader-section {
  position: fixed;
  top: -500%;
  width: 101%;
  height: 1000%;
  background: var(--loader-bg);
  z-index: 1001;
  transform: translateX(0);
}

#loader-wrapper .section-left {
  left: -50%;
}

#loader-wrapper .section-right {
  right: -50%;
}

/* =========================
   LOADED STATE
========================= */
body.loaded .loader-center {
  opacity: 0;
}

body.loaded #loader-wrapper .section-left {
  -webkit-transform: translateX(-100%);
  -ms-transform: translateX(-100%);
  transform: translateX(-100%);
  -webkit-transition: all 1.5s 1s cubic-bezier(0.645, 0.045, 0.355, 1);
  -o-transition: all 1.5s 1s cubic-bezier(0.645, 0.045, 0.355, 1);
  transition: all 1.5s 1s cubic-bezier(0.645, 0.045, 0.355, 1);
}

body.loaded #loader-wrapper .section-right {
  -webkit-transform: translateX(100%);
  -ms-transform: translateX(100%);
  transform: translateX(100%);
  -webkit-transition: all 1.5s 1s cubic-bezier(0.645, 0.045, 0.355, 1);
  -o-transition: all 1.5s 1s cubic-bezier(0.645, 0.045, 0.355, 1);
  transition: all 1.5s 1s cubic-bezier(0.645, 0.045, 0.355, 1);
}

body.loaded #loader-wrapper {
  visibility: hidden;
  transition: visibility 0s 2.6s;
}

/* =========================
   TOAST
========================= */
.toast {
  position: fixed;
  top: 6rem;
  right: 1.5rem;
  z-index: 99999;
  background: var(--card-bg);
  color: var(--text-main);
  padding: 15px 20px;
  border-radius: 4px;
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
}

.toast.success {
  border-left: 6px solid var(--toast-success);
}

.toast.error {
  border-left: 6px solid var(--toast-error);
}

/* =========================
   ANIMATIONS
========================= */
@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}
</style>
