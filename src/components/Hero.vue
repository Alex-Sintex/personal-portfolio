<template>
    <div class="hero">
        <div class="overlay">
            <div class="intro">
                <button class="scroll-indicator" @click="scrollToNext" aria-label="Scroll to next section">
                    <span class="arrow"></span>
                </button>
                <h1 class="text-uppercase">Kevin Alexis</h1>
                <p class="typewriter">{{ typedText }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed, watch } from 'vue'
import { useI18n } from 'vue-i18n'

const { tm, locale } = useI18n()

// 🔹 reactive translated texts
const texts = computed(() => tm('hero.roles'))

const typedText = ref('')
let textIndex = 0
let charIndex = 0
let isDeleting = false
let timerId = null

function resetTypewriter() {
    typedText.value = ''
    textIndex = 0
    charIndex = 0
    isDeleting = false
}

function typeEffect() {
    const currentText = texts.value[textIndex]
    if (!currentText) return

    if (!isDeleting) {
        typedText.value = currentText.substring(0, charIndex + 1)
        charIndex++

        if (charIndex === currentText.length) {
            setTimeout(() => (isDeleting = true), 1500)
        }
    } else {
        typedText.value = currentText.substring(0, charIndex - 1)
        charIndex--

        if (charIndex === 0) {
            isDeleting = false
            textIndex = (textIndex + 1) % texts.value.length
        }
    }

    timerId = setTimeout(typeEffect, isDeleting ? 50 : 100)
}

function scrollToNext() {
    const nextSection = document.querySelector('#about')

    if (nextSection) {
        nextSection.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        })
    }
}

// 🔹 restart animation when language changes
watch(locale, () => {
    clearTimeout(timerId)
    resetTypewriter()
    typeEffect()
})

onMounted(() => {
    typeEffect()
})

onUnmounted(() => {
    clearTimeout(timerId)
})
</script>


<style scoped>
.hero {
    position: absolute;
    inset: 0;
    background-image: url('@/assets/images/backgrounds/kali.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    color: var(--hero-text);
}

.text-uppercase {
    font-weight: 800;
    color: var(--hero-text);
    font-size: 60px;
    line-height: 100px;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.overlay {
    position: absolute;
    inset: 0;
    background-color: var(--hero-overlay);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.intro {
    text-align: center;
    padding-bottom: 100px;
}

.intro h2 {
    font-size: 3rem;
    margin-bottom: 0.5rem;
}

/* =========================
   SCROLL ARROW (MINIMAL)
========================= */
.scroll-indicator {
    position: absolute;
    bottom: 100px;
    left: 50%;
    transform: translateX(-50%);
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    border: none;
    cursor: pointer;
    z-index: 10;
    touch-action: manipulation;
}

@media (max-width: 768px) {
    .scroll-indicator {
        bottom: 60px;
        width: 72px;
        height: 72px;
    }

    .arrow {
        width: 26px;
        height: 26px;
        border-width: 3px;
    }
}

@media (max-height: 500px) {
    .intro {
        padding-bottom: 40px;
    }

    .text-uppercase {
        font-size: 42px;
        line-height: 56px;
    }

    .typewriter {
        font-size: 24px;
    }

    .typewriter::after {
        height: 24px;
    }
}

.scroll-indicator:active {
    transform: translateX(-50%) scale(0.9);
}

/* ARROW SHAPE */
.arrow {
    display: block;
    width: 22px;
    height: 22px;
    border-left: 2px solid var(--hero-arrow);
    border-bottom: 2px solid var(--hero-arrow);
    transform: rotate(-45deg);
    animation: fadeArrow 1.8s infinite ease-in-out;
}

/* FADE IN / OUT */
@keyframes fadeArrow {
    0% {
        opacity: 0;
    }

    30% {
        opacity: 1;
    }

    60% {
        opacity: 1;
    }

    100% {
        opacity: 0;
    }
}

.typewriter {
    display: inline-block;
    position: relative;
    color: var(--hero-text-muted);
    font-size: 32px;
    font-weight: 500;
}

.typewriter::after {
    content: '';
    display: inline-block;
    width: 2px;
    height: 32px;
    background-color: var(--hero-cursor);
    margin-left: 4px;
    vertical-align: bottom;
    opacity: 1;
    animation: 0.7s infinite blink;
    font-size: 35px;
    font-weight: 900;
    color: rgb(255, 255, 255);
}

@keyframes blink {
    50% {
        opacity: 0;
    }
}

@media (max-width: 768px) {
    .hero {
        background-size: cover !important;
        background-position: center !important;
    }
}
</style>
