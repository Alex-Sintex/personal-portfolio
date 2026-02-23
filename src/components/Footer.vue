<template>
    <footer class="footer">
        <button class="scroll-top" @click="scrollToTop" aria-label="Back to top">
            <span class="arrow-up"></span>
        </button>
        <!-- TOP WAVE -->
        <div class="wave-container">
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path d="M0,40 C120,80 360,0 600,20 840,40 1080,80 1440,40 L1440,0 L0,0 Z" :fill="waveFooter" />
            </svg>
        </div>

        <!-- FOOTER CONTENT -->
        <div class="footer-content">
            <p>{{ $t('footer.copyright') }}</p>
        </div>
    </footer>
</template>

<script setup>
import { useI18n } from 'vue-i18n'
const { t } = useI18n()
const waveFooter = 'var(--wave-footer)'
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    })
}
</script>

<style scoped>
/* FOOTER BASE */
.footer {
    position: relative;
    background: var(--wave-footer-bg);
    color: #1f1f1f;
    text-align: center;
    padding-top: 80px;
}

/* WAVE CONTAINER */
.wave-container {
    position: absolute;
    top: -1px;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
}

.wave-container svg {
    display: block;
    width: 100%;
    height: 180px;
}

/* CONTENT */
.footer-content {
    padding: 3rem 1rem 2.5rem;
    font-size: 0.9rem;
    letter-spacing: 0.4px;
}

/* =========================
   SCROLL TO TOP ARROW
========================= */
.scroll-top {
    position: absolute;
    right: 30px;
    bottom: 30px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    z-index: 10;
}

/* ARROW SHAPE (UP) */
.arrow-up {
    display: block;
    width: 20px;
    height: 20px;
    border-left: 2px solid #aaa;
    border-top: 2px solid #aaa;
    transform: rotate(45deg);
    animation: fadeArrowUp 2s infinite ease-in-out;
}

/* FADE LOOP */
@keyframes fadeArrowUp {
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
</style>