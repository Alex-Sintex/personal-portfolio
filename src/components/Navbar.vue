<template>
    <header :class="['navbar', { scrolled }]">
        <div class="navbar-container">
            <h1 class="logo">Kevin's portfolio</h1>

            <!-- Hamburger icon -->
            <button class="hamburger" @click="toggleMobileMenu">
                <span></span><span></span><span></span>
            </button>

            <!-- Desktop nav -->
            <nav class="nav-desktop">
                <ul class="nav-list">
                    <li><a href="#home" :class="linkClass('home')">{{ $t('nav.home') }}</a></li>
                    <li><a href="#about" :class="linkClass('about')">{{ $t('nav.about') }}</a></li>
                    <li><a href="#portfolio" :class="linkClass('portfolio')">{{ $t('nav.portfolio') }}</a></li>
                    <li><a href="#services" :class="linkClass('services')">{{ $t('nav.services') }}</a></li>
                    <li><a href="#updates" :class="linkClass('updates')">{{ $t('nav.updates') }}</a></li>
                    <li><a href="#contact" :class="linkClass('contact')">{{ $t('nav.contact') }}</a></li>

                    <!-- Theme toggle -->
                    <li>
                        <button class="theme-toggle" @click="toggleTheme">
                            <img v-if="theme === 'light'" :src="moonIcon" alt="Dark mode" class="w-5" />
                            <img v-else :src="sunIcon" alt="Light mode" class="w-5" />
                        </button>
                    </li>

                    <!-- Desktop language dropdown -->
                    <li class="lang-dropdown">
                        <button class="lang-trigger" @click.stop="toggleLangDesktop">
                            {{ locale.toUpperCase() }}
                            <span class="caret">▾</span>
                        </button>
                        <ul v-if="langOpenDesktop" class="lang-menu">
                            <li @click="changeLang('en')">English</li>
                            <li @click="changeLang('es')">Español</li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <!-- Mobile nav -->
            <nav v-if="isMobileMenuOpen" class="nav-mobile">
                <ul class="nav-list-mobile">
                    <li><a href="#home" @click="toggleMobileMenu">Home</a></li>
                    <li><a href="#about" @click="toggleMobileMenu">About me</a></li>
                    <li><a href="#portfolio" @click="toggleMobileMenu">Portfolio</a></li>
                    <li><a href="#services" @click="toggleMobileMenu">Services</a></li>
                    <li><a href="#updates" @click="toggleMobileMenu">Updates</a></li>
                    <li><a href="#contact" @click="toggleMobileMenu">Contact</a></li>

                    <!-- Mobile theme toggle -->
                    <li class="mobile-theme-toggle">
                        <button @click="toggleTheme">
                            <img v-if="theme === 'light'" :src="moonIcon" alt="Dark mode" />
                            <img v-else :src="sunIcon" alt="Light mode" />
                            <span>{{ theme === 'light' ? 'Dark mode' : 'Light mode' }}</span>
                        </button>
                    </li>

                    <!-- Mobile language dropdown -->
                    <li class="mobile-lang-toggle">
                        <button @click.stop="toggleLangMobile">
                            {{ locale.toUpperCase() }}
                        </button>
                        <ul v-if="langOpenMobile" class="mobile-lang-menu">
                            <li @click="changeLang('en')">English</li>
                            <li @click="changeLang('es')">Español</li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</template>

<script setup>
import moonIcon from '@/assets/icons/moon_icon.png'
import sunIcon from '@/assets/icons/sun_icon.png'
import { ref, onMounted, onUnmounted, inject } from 'vue'
import { useI18n } from 'vue-i18n'

const { locale } = useI18n()
const theme = inject('theme')
const setTheme = inject('setTheme')

// Active scroll section
const activeSection = ref('home')
const scrolled = ref(false)
const isMobileMenuOpen = ref(false)

// Dropdown states
const langOpenDesktop = ref(false)
const langOpenMobile = ref(false)

// Toggle functions
function toggleLangDesktop() { langOpenDesktop.value = !langOpenDesktop.value }
function toggleLangMobile() { langOpenMobile.value = !langOpenMobile.value }

function changeLang(lang) {
    locale.value = lang
    localStorage.setItem('lang', lang)
    langOpenDesktop.value = false
    langOpenMobile.value = false
    isMobileMenuOpen.value = false
}

function toggleTheme() {
    const newTheme = theme.value === 'light' ? 'dark' : 'light'
    setTheme(newTheme)
    isMobileMenuOpen.value = false
}

function toggleMobileMenu() {
    isMobileMenuOpen.value = !isMobileMenuOpen.value
}

function updateActiveSection() {
    const sections = document.querySelectorAll('section')
    const scrollY = window.scrollY
    scrolled.value = scrollY > window.innerHeight * 0.8

    sections.forEach(section => {
        const rect = section.getBoundingClientRect()
        const midpoint = window.innerHeight / 2
        if (rect.top <= midpoint && rect.bottom >= midpoint) {
            activeSection.value = section.id
        }
    })
}

function linkClass(id) {
    return [
        'nav-link',
        activeSection.value === id ? 'active' : 'inactive'
    ]
}

// Handle clicks outside dropdowns
onMounted(() => {
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches
    theme.value = localStorage.getItem('theme') || (prefersDark ? 'dark' : 'light')

    const handleClickOutside = (e) => {
        const desktop = document.querySelector('.lang-dropdown')
        if (desktop && !desktop.contains(e.target)) langOpenDesktop.value = false

        const mobile = document.querySelector('.mobile-lang-toggle')
        if (mobile && !mobile.contains(e.target)) langOpenMobile.value = false
    }

    document.addEventListener('click', handleClickOutside)
    window.addEventListener('scroll', updateActiveSection)
    window.addEventListener('hashchange', updateActiveSection)
    updateActiveSection()

    onUnmounted(() => {
        document.removeEventListener('click', handleClickOutside)
        window.removeEventListener('scroll', updateActiveSection)
        window.removeEventListener('hashchange', updateActiveSection)
    })
})
</script>

<style scoped>
.navbar {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 100;
    padding: 0.8rem 1.5rem;
    /* smaller padding */
    transition: background-color 0.3s ease, padding 0.3s ease;
    background-color: transparent;
}

.nav-desktop a {
    font-size: clamp(1.1rem, 1.2vw, 1.4rem);
}

.navbar.scrolled {
    padding-top: 10px;
    padding-bottom: 10px;
    background-color: var(--bg-navbar-scrolled);
    box-shadow: rgba(0, 0, 0, 0.5) 0px 1px 70px;
    transition: 0.5s;
}

.navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
}

.logo {
    font-family: 'MyCustomFont', cursive;
    font-size: 1.5rem;
    color: var(--text-inverse);
}

.nav-list {
    display: flex;
    align-items: center;
    gap: 1.2rem;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-link {
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    position: relative;
    transition: color 0.3s ease;
}

/* Hover effect */
.nav-link.inactive:hover {
    color: rgba(255, 255, 255, 0.75);
    transition: color 0.3s ease;
}

.nav-link::after {
    content: '';
    position: absolute;
    bottom: -6px;
    left: 0;
    width: 0%;
    height: 2px;
    background-color: var(--text-inverse);
    transition: width 0.3s ease;
}

.nav-link:hover::after {
    width: 100%;
}

.nav-link.active {
    color: var(--text-inverse);
}

.nav-link.inactive {
    color: var(--text-muted);
}

.hamburger {
    display: none;
    flex-direction: column;
    gap: 5px;
    background: none;
    border: none;
    cursor: pointer;
}

.hamburger span {
    width: 25px;
    height: 3px;
    background-color: var(--text-inverse);
    border-radius: 2px;
}

.theme-toggle {
    width: 1.25rem;
    display: block;
    background: none;
    border: none;
    cursor: pointer;
    margin-left: 1rem;
    display: flex;
    align-items: center;
}

.theme-toggle img {
    width: 20px;
    height: 20px;
}

/* Mobile nav styles */
.nav-mobile {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background-color: var(--bg-navbar-scrolled);
    padding: 1rem 0;
    z-index: 99;
}

.nav-list-mobile {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-list-mobile a {
    color: white;
    text-decoration: none;
    font-size: 1.1rem;
}

/* Responsive breakpoint (mobile) */
@media (max-width: 768px) {

    .navbar {
        padding-top: 10px;
        padding-bottom: 10px;
        background-color: #111;
        box-shadow: rgba(0, 0, 0, 0.5) 0px 1px 70px;
        padding-right: 0;
        padding-left: 0;
    }

    .navbar-container {
        padding-right: 1rem;
        padding-left: 1rem;
    }

    .nav-desktop {
        display: none;
    }

    .nav-desktop a {
        font-size: clamp(0.85rem, 1vw, 1rem);
    }

    .hamburger {
        display: flex;
    }
}

/* Tablet landscape (iPads, etc.) */
@media (min-width: 769px) and (max-width: 1024px) {

    .navbar {
        padding-top: 10px;
        padding-bottom: 10px;
        background-color: #111;
        box-shadow: rgba(0, 0, 0, 0.5) 0px 1px 70px;
        padding-right: 0;
        padding-left: 0;
    }

    .navbar-container {
        padding-right: 1rem;
        padding-left: 1rem;
    }

    .nav-desktop {
        display: flex;
        gap: 1rem;
        font-size: 0.95rem;
        margin: 10px;
    }

    .nav-desktop a {
        font-size: clamp(0.85rem, 1vw, 1rem);
    }

    .hamburger {
        display: none;
    }

    .nav-mobile {
        display: none;
    }
}

@media (min-width: 769px) and (max-width: 1366px) {

    /* widened max-width for iPad Pro */
    .navbar {
        padding: 10px 0;
    }

    .navbar-container {
        padding: 0 1rem;
    }

    .nav-desktop {
        display: flex;
        gap: 1rem;
        font-size: 0.95rem;
        margin: 0;
        /* remove unnecessary margin */
    }
}

.mobile-theme-toggle {
    margin-top: 1rem;
}

.mobile-theme-toggle button {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    background: none;
    border: none;
    color: white;
    font-size: 1rem;
    cursor: pointer;
}

.mobile-theme-toggle img {
    width: 20px;
    height: 20px;
}

/* Language switcher styles */
.lang-dropdown {
    position: relative;
    margin-left: 1rem;
}

.lang-trigger {
    background: none;
    border: 1px solid var(--text-muted);
    color: var(--text-muted);
    padding: 0.3rem 0.6rem;
    font-size: 0.8rem;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.lang-trigger:hover {
    border-color: var(--text-inverse);
    color: var(--text-inverse);
}

.caret {
    font-size: 0.6rem;
}

.lang-menu {
    position: absolute;
    top: 120%;
    right: 0;
    background: var(--bg-navbar-scrolled);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 6px;
    list-style: none;
    padding: 0.4rem 0;
    min-width: 120px;
    z-index: 200;
}

.lang-menu li {
    padding: 0.4rem 0.8rem;
    cursor: pointer;
    color: var(--text-muted);
    font-size: 0.85rem;
}

.lang-menu li:hover {
    background: rgba(255, 255, 255, 0.08);
    color: var(--text-inverse);
}

.mobile-lang-toggle {
    margin-top: 0.5rem;
    text-align: center;
}

.mobile-lang-toggle button {
    background: none;
    border: 1px solid white;
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 5px;
    cursor: pointer;
}

.mobile-lang-menu {
    margin-top: 0.4rem;
    list-style: none;
    padding: 0;
}

.mobile-lang-menu li {
    padding: 0.4rem;
    cursor: pointer;
    color: white;
}

.mobile-lang-menu li:hover {
    background: rgba(255, 255, 255, 0.15);
}
</style>
