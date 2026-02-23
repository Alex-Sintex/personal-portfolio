<template>
    <section id="portfolio" class="portfolio-section">
        <div class="portfolio-header">
            <h2 class="section-title">{{ t('portfolio.title') }}</h2>
            <p class="section-subtitle">
                {{ t('portfolio.subtitle') }}
            </p>
        </div>

        <!-- CATEGORY TABS -->
        <div class="category-tabs">
            <button v-for="cat in categories" :key="cat" :class="['tab-button', { active: selectedCategory === cat }]"
                @click="selectedCategory = cat">
                {{ cat }}
            </button>
        </div>

        <!-- CAROUSEL -->
        <div class="carousel">
            <button class="nav-arrow" @click="prevProject" :disabled="currentIndex === 0" aria-label="Previous project">
                ‹
            </button>

            <div class="carousel-window" @touchstart="onTouchStart" @touchend="onTouchEnd">
                <div class="carousel-track" :style="{ transform: `translateX(-${currentIndex * 100}%)` }">
                    <div v-for="(item, i) in filteredProjects" :key="item.title" class="carousel-item"
                        @click.stop="showLightbox(i)">
                        <img :src="item.image" :alt="item.title" loading="lazy" />
                        <h3>{{ item.title }}</h3>
                    </div>
                </div>
            </div>

            <button class="nav-arrow" @click="nextProject" :disabled="currentIndex === filteredProjects.length - 1"
                aria-label="Next project">
                ›
            </button>
        </div>

        <!-- LIGHTBOX (lazy loaded) -->
        <VueEasyLightbox v-if="visible" :visible="visible" :imgs="filteredProjects.map(p => p.image)" :index="index"
            :scroll-disabled="true" @hide="visible = false" />
    </section>
</template>

<script setup>
import { ref, computed, watch, defineAsyncComponent } from 'vue'
import { useI18n } from 'vue-i18n'

// Images
import dontacoLogin from '@/assets/images/portfolio/web/dontaco.png'
import academic_system from '@/assets/images/portfolio/web/academic_system.png'
import band_web from '@/assets/images/portfolio/web/band_web.png'
import iautism from '@/assets/images/portfolio/mobile/iautism.png'
import itracker from '@/assets/images/portfolio/mobile/itracker.png'

const { t } = useI18n()

const VueEasyLightbox = defineAsyncComponent(() =>
    import('vue-easy-lightbox')
)

/* 🔹 Categories (translated) */
const categories = computed(() => [
    t('portfolio.categories.web'),
    t('portfolio.categories.mobile')
])

const selectedCategory = ref(categories.value[0])

/* 🔹 Projects (titles translated, category is KEY) */
const projects = computed(() => [
    {
        title: t('portfolio.projects.accounting'),
        category: 'web',
        image: dontacoLogin
    },
    {
        title: t('portfolio.projects.academic'),
        category: 'web',
        image: academic_system
    },
    {
        title: t('portfolio.projects.band'),
        category: 'web',
        image: band_web
    },
    {
        title: t('portfolio.projects.iautism'),
        category: 'mobile',
        image: iautism
    },
    {
        title: t('portfolio.projects.itracker'),
        category: 'mobile',
        image: itracker
    }
])

/* 🔹 Filter */
const filteredProjects = computed(() => {
    const key =
        selectedCategory.value === t('portfolio.categories.web')
            ? 'web'
            : 'mobile'

    return projects.value.filter(p => p.category === key)
})

const currentIndex = ref(0)
const visible = ref(false)
const index = ref(0)

let startX = 0

function onTouchStart(e) {
    startX = e.touches[0].clientX
}

function onTouchEnd(e) {
    const endX = e.changedTouches[0].clientX
    const diff = startX - endX

    if (diff > 50) nextProject()
    if (diff < -50) prevProject()
}

function nextProject() {
    if (currentIndex.value < filteredProjects.value.length - 1) {
        currentIndex.value++
    }
}

function prevProject() {
    if (currentIndex.value > 0) {
        currentIndex.value--
    }
}

watch(selectedCategory, () => {
    currentIndex.value = 0
})

function showLightbox(i) {
    index.value = i
    visible.value = true
}
</script>

<style scoped>
/* SECTION */
.portfolio-section {
    padding: 4rem 2rem;
    padding-top: 120px;
    padding-bottom: 160px;
    background-color: var(--bg-main);
    color: var(--text-main);
    font-family: 'Helvetica Neue', sans-serif;
}

.portfolio-header {
    margin-bottom: 2rem;
    text-align: center;
}

.section-title {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.section-subtitle {
    max-width: 42rem;
    margin: 0 auto;
    font-size: 1.1rem;
    color: var(--text-muted);
}

/* TABS */
.category-tabs {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 2.5rem;
    flex-wrap: wrap;
}

.tab-button {
    padding: 0.6rem 1.4rem;
    border: 2px solid var(--text-main);
    color: var(--text-main);
    border-radius: 999px;
    background: transparent;
    font-weight: bold;
    cursor: pointer;
}

.tab-button.active {
    background-color: var(--text-main);
    color: var(--bg-main);
}

/* CAROUSEL */
.carousel {
    display: flex;
    overflow: hidden;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.carousel-window {
    overflow: hidden;
    width: 50%;
}

.carousel-track {
    display: flex;
    transition: transform 0.4s ease;
}

.carousel-item {
    min-width: 100%;
    height: 260px;
    position: relative;
    border-radius: 0.75rem;
    overflow: hidden;
    cursor: pointer;
    background: var(--card-bg);
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.25);
}

.carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.carousel-item h3 {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    margin: 0;
    padding: 0.75rem;
    font-size: 0.95rem;
    color: #fff;
    background: linear-gradient(to top,
            rgba(0, 0, 0, 0.65),
            transparent);
}

/* ARROWS */
.nav-arrow {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: 2px solid var(--text-main);
    background: var(--card-bg);
    color: var(--text-main);
    font-size: 1.5rem;
    cursor: pointer;
}

.nav-arrow:disabled {
    opacity: 0.3;
}

/* MOBILE */
@media (max-width: 640px) {
    .carousel-item {
        height: 220px;
    }

    .section-title {
        font-size: 2rem;
    }

    .carousel-window {
        width: 100%;
    }

    .nav-arrow {
        display: none;
    }
}
</style>
