<template>
    <section id="services" class="services-section">
        <h1 class="section-title">{{ t('services.title') }}</h1>
        <p class="subtitle">{{ t('services.subtitle') }}</p>

        <div class="services-grid">
            <div v-for="service in services" :key="service.title" class="service-card">
                <font-awesome-icon :icon="service.icon" class="service-icon" />

                <h3 class="service-title">{{ service.title }}</h3>
                <p class="service-description">{{ service.description }}</p>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

/* 🔹 Services translated */
const services = computed(() => [
    {
        title: t('services.items.webDesign.title'),
        icon: ['fas', 'code'],
        description: t('services.items.webDesign.description')
    },
    {
        title: t('services.items.development.title'),
        icon: ['fas', 'cube'],
        description: t('services.items.development.description')
    },
    {
        title: t('services.items.branding.title'),
        icon: ['fas', 'palette'],
        description: t('services.items.branding.description')
    },
    {
        title: t('services.items.responsive.title'),
        icon: ['fas', 'mobile'],
        description: t('services.items.responsive.description')
    },
    {
        title: t('services.items.pwa.title'),
        icon: ['fas', 'mobile-alt'],
        description: t('services.items.pwa.description')
    },
    {
        title: t('services.items.support.title'),
        icon: ['fas', 'life-ring'],
        description: t('services.items.support.description')
    }
])
</script>

<style scoped>
.services-section {
    padding: 4rem 2rem;
    background-color: var(--bg-main);
    color: var(--text-main);
    text-align: center;
    padding-top: 120px;
    padding-bottom: 160px;
}

.subtitle {
    font-size: 1.2rem;
    color: var(--text-muted);
    margin-bottom: 1rem;
}

.section-title {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
    color: var(--text-main);
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 2rem;
}

.service-card {
    text-align: center;
    padding: 30px 20px;
    margin-bottom: 2rem;
    background-color: var(--card-bg);
    -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    -webkit-transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    -o-transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.service-card:hover {
    -webkit-box-shadow: 0 14px 28px rgba(0, 0, 0, 0.1);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.1);
}

.service-icon {
    width: 48px;
    margin-bottom: 1rem;
    height: 48px;
    color: var(--text-main);
}

.service-title {
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
    color: var(--text-main);
}

.service-description {
    font-size: 0.95rem;
    color: var(--text-muted);
}
</style>