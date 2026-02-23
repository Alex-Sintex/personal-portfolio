<template>
    <section id="updates" class="updates-section">
        <h2 class="section-title">{{ t('updates.title') }}</h2>

        <transition-group name="updates" tag="div" class="updates-grid">
            <!-- REAL CARDS -->
            <article v-for="update in visibleUpdates" :key="update.id" class="update-card">
                <div class="image-wrapper">
                    <img :src="update.image" :alt="update.title" />
                </div>

                <h3 class="update-title">{{ update.title }}</h3>
                <p class="update-description">{{ update.description }}</p>
                <p class="update-meta">
                    <strong>{{ t('updates.statusLabel') }}:</strong>
                    {{ update.status }} · {{ update.tech }}
                </p>
            </article>

            <!-- SKELETON -->
            <article v-if="loading" v-for="n in 3" :key="'skeleton-' + n" class="update-card skeleton">
                <div class="skeleton-img"></div>
                <div class="skeleton-line"></div>
                <div class="skeleton-line short"></div>
            </article>
        </transition-group>

        <button v-if="hasMoreThanThree" class="view-more" @click="toggleUpdates" :disabled="loading">
            {{
                loading
                    ? t('updates.loading')
                    : expanded
                        ? t('updates.showLess')
                        : t('updates.viewMore')
            }}
        </button>
    </section>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useI18n } from 'vue-i18n'

import portfolio_web from '@/assets/images/portfolio/web/portfolio_web.png'
import mootec from '@/assets/images/portfolio/web/mootec.png'

const { t } = useI18n()

/* 🔹 Translated updates */
const allUpdates = computed(() => [
    {
        id: 1,
        title: t('updates.items.portfolio.title'),
        image: portfolio_web,
        description: t('updates.items.portfolio.description'),
        status: t('updates.status.inProgress'),
        tech: 'Vue 3, Vite, HTML5, CSS, JavaScript, i18n'
    },
    {
        id: 2,
        title: t('updates.items.cyber.title'),
        image: mootec,
        description: t('updates.items.cyber.description'),
        status: t('updates.status.completed'),
        tech: t('updates.items.cyber.tech')
    }
])

const visibleCount = ref(3)
const loading = ref(false)
const expanded = ref(false)

const visibleUpdates = computed(() =>
    allUpdates.value.slice(0, visibleCount.value)
)

const hasMoreThanThree = computed(() => allUpdates.value.length > 3)

function toggleUpdates() {
    loading.value = true

    setTimeout(() => {
        if (!expanded.value) {
            visibleCount.value = allUpdates.value.length
            expanded.value = true
        } else {
            visibleCount.value = 3
            expanded.value = false
        }
        loading.value = false
    }, 800)
}
</script>

<style scoped>
.updates-section {
    padding: 4rem 2rem;
    background: var(--bg-main);
    text-align: center;
    padding-top: 120px;
    padding-bottom: 160px;
}

.section-title {
    font-size: 2.5rem;
    margin-bottom: 2.5rem;
    color: var(--text-main);
}

.updates-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 2.5rem;
    max-width: 1200px;
    margin: 0 auto 3rem;
    position: relative;
}

.update-card {
    background: var(--card-bg);
    text-align: left;
    box-shadow: 0 6px 20px rgba(0, 0, 0, .08);
    transition: transform .3s ease, box-shadow .3s ease;
    overflow: hidden;
}

.update-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 35px rgba(0, 0, 0, .12);
}

/* ------------------------
   TRANSITION
------------------------ */
.updates-enter-from {
    opacity: 0;
    transform: translateY(20px) scale(0.96);
    max-height: 0;
}

.updates-enter-to {
    opacity: 1;
    transform: translateY(0) scale(1);
    max-height: 500px;
}

.updates-enter-active {
    transition: all 0.45s ease;
}

.updates-leave-from {
    opacity: 1;
    transform: translateY(0) scale(1);
    max-height: 500px;
}

.updates-leave-to {
    opacity: 0;
    transform: translateY(-20px) scale(0.95);
    max-height: 0;
}

.updates-leave-active {
    transition: all 0.35s ease;
}

.updates-move {
    transition: transform 0.35s ease;
}

/* ------------------------
   IMAGE
------------------------ */
.image-wrapper {
    height: 200px;
    overflow: hidden;
}

.image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ------------------------
   TEXT
------------------------ */
.update-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin: 1.2rem 1.5rem .5rem;
}

.update-description {
    font-size: .95rem;
    color: var(--text-muted);
    margin: 0 1.5rem 1rem;
}

.update-meta {
    font-size: .85rem;
    color: var(--text-muted);
    margin: 0 1.5rem 1.5rem;
}

/* ------------------------
   BUTTON
------------------------ */
.view-more {
    padding: .75rem 2.2rem;
    border: 1px solid var(--text-main);
    color: var(--text-main);
    background: transparent;
    cursor: pointer;
    transition: .3s;
}

.view-more:disabled {
    opacity: .4;
    cursor: not-allowed;
}

.view-more:hover:not(:disabled) {
    background: var(--text-main);
    color: var(--bg-main);
}

/* ------------------------
   SKELETON
------------------------ */
.skeleton {
    pointer-events: none;
}

.skeleton-img {
    height: 200px;
    background: var(--border-color);
    background-size: 400% 100%;
    animation: shimmer 1.4s infinite;
}

.skeleton-line {
    height: 14px;
    margin: 1.2rem 1.5rem .6rem;
    background: var(--border-color);
    animation: shimmer 1.4s infinite;
}

.skeleton-line.short {
    width: 60%;
}

@keyframes shimmer {
    0% {
        background-position: 100% 0
    }

    100% {
        background-position: -100% 0
    }
}
</style>
