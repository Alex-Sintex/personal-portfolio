<template>
    <section id="contact" class="contact-section">
        <div class="contact-header">
            <h2 class="contact-title">{{ $t('contact.title') }}</h2>
            <p class="contact-subtitle">{{ $t('contact.subtitle') }}</p>
            <p class="contact-message">{{ $t('contact.message') }}</p>
        </div>

        <form class="contact-form" @submit.prevent="submitForm" novalidate>
            <div class="contact-row">
                <div class="input-group">
                    <input type="text" class="contact-input" :placeholder="$t('contact.form.name')" v-model="form.name"
                        maxlength="50" aria-label="Name" />
                </div>

                <div class="input-group">
                    <input type="email" class="contact-input" :placeholder="$t('contact.form.email')"
                        v-model="form.email" maxlength="100" aria-label="Email" />
                </div>
            </div>

            <div class="input-group">
                <textarea class="contact-textarea" :placeholder="$t('contact.form.message')" v-model="form.message"
                    maxlength="500" aria-label="Message"></textarea>
                <small class="char-count">{{ form.message.length }}/500</small>
            </div>

            <button class="contact-button" :disabled="loading">
                {{ loading ? $t('contact.form.sending') : $t('contact.form.submit') }}
            </button>
        </form>
    </section>
</template>

<script setup>
import { ref, inject } from 'vue'
import { useI18n } from 'vue-i18n'
import emailjs from '@emailjs/browser'

// --------------------
// GLOBAL TOAST & SOUNDS
// --------------------
const showToast = inject('showToast')
const { t } = useI18n()
const successSound = new Audio('/sounds/success.mp3')
const errorSound = new Audio('/sounds/error.mp3')

// --------------------
// FORM STATE
// --------------------
const form = ref({
    name: '',
    email: '',
    message: ''
})
const loading = ref(false)

// --------------------
// EMAIL VALIDATION
// --------------------
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/

// --------------------
// SUBMIT FORM
// --------------------
const maxNameLength = 50
const maxEmailLength = 100
const maxMessageLength = 500
function submitForm() {

    // BASIC VALIDATION
    if (loading.value) return

    if (form.value.name.length > maxNameLength) {
        showToast('error', t('contact.toast.maxName', { max: maxNameLength }))
        errorSound.play()
        return
    } else if (form.value.email.length > maxEmailLength) {
        showToast('error', t('contact.toast.maxEmail', { max: maxEmailLength }))
        errorSound.play()
        return
    } else if (form.value.message.length > maxMessageLength) {
        showToast('error', t('contact.toast.maxMessage', { max: maxMessageLength }))
        errorSound.play()
        return
    }

    if (!form.value.name.trim() || !form.value.email.trim() || !form.value.message.trim()) {
        showToast('error', t('contact.toast.required'))
        errorSound.play()
        return
    }

    if (!emailRegex.test(form.value.email.trim())) {
        showToast('error', t('contact.toast.invalidEmail'))
        errorSound.play()
        return
    }

    loading.value = true

    const payload = {
        from_name: form.value.name.trim(),
        from_email: form.value.email.trim(),
        message: form.value.message.trim()
    }

    emailjs
        .send(
            import.meta.env.VITE_EMAILJS_SERVICE_ID,
            import.meta.env.VITE_EMAILJS_TEMPLATE_ID,
            payload,
            import.meta.env.VITE_EMAILJS_PUBLIC_KEY
        )
        .then(() => {
            showToast('success', t('contact.toast.success'))
            successSound.play()

            // reset form
            form.value.name = ''
            form.value.email = ''
            form.value.message = ''
        })
        .catch(() => {
            showToast('error', t('contact.toast.error'))
            errorSound.play()
        })
        .finally(() => {
            loading.value = false
        })
}
</script>

<style scoped>
.contact-section {
    padding: 4rem 2rem;
    padding-top: 80px;
    background-color: var(--bg-main);
    color: var(--text-main);
    text-align: center;
    margin: 0 auto;
}

.contact-header {
    width: 100%;
    margin: 0 auto 2rem;
}

.contact-title {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
    color: var(--text-main);
}

.contact-subtitle {
    font-size: 1.2rem;
    color: var(--text-muted);
    margin-bottom: 1rem;
}

.contact-message {
    font-size: 1rem;
    color: var(--text-muted);
    margin-bottom: 2rem;
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    max-width: 600px;
    margin: 0 auto;
}

.contact-row {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.contact-input {
    background-color: var(--card-bg);
    color: var(--text-main);
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    flex: 1;
    min-width: 240px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.contact-input:focus {
    border-color: var(--text-main);
    outline: none;
}


.input-group {
    flex: 1;
    display: flex;
    flex-direction: column;
    position: relative;
}

.contact-input:focus,
.contact-textarea:focus {
    border-color: var(--text-main);
}

.contact-textarea {
    padding: 0.75rem 1rem;
    background-color: var(--card-bg);
    color: var(--text-main);
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    font-size: 1rem;
    min-height: 120px;
    resize: none;
}

.char-count {
    font-size: 0.75rem;
    color: var(--text-muted);
    text-align: right;
    margin-top: 2px;
}

.contact-button {
    background-color: var(--card-bg);
    color: var(--text-main);
    border: 1px solid var(--text-main);
    padding: 0.75rem 1.25rem;
    border-radius: 0.5rem;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.contact-button:hover {
    border: 1px solid #000;
    background: var(--text-main);
    color: var(--bg-main);
    text-decoration: none;
    outline: none;
    cursor: pointer;
}

.contact-input::placeholder,
.contact-textarea::placeholder {
    color: var(--text-muted);
}

/* TOAST BASE */
.toast {
    position: fixed;
    top: 1.5rem;
    right: 1.5rem;
    padding: 0.9rem 1.3rem;
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 0.75rem;
    font-size: 0.95rem;
    font-weight: 500;
    z-index: 9999;
    min-width: 240px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

/* TYPES */
.toast.success {
    background: var(--toast-success);
    color: #fff;
}

.toast.error {
    background: var(--toast-error);
    color: #fff;
}

/* SLIDE ANIMATION */
.toast-enter-from {
    transform: translateX(120%);
    opacity: 0;
}

.toast-enter-to {
    transform: translateX(0);
    opacity: 1;
}

.toast-leave-from {
    transform: translateX(0);
    opacity: 1;
}

.toast-leave-to {
    transform: translateX(120%);
    opacity: 0;
}

.toast-enter-active,
.toast-leave-active {
    transition: all 0.4s ease;
}

.contact-button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.contact-button:hover:not(:disabled) {
    background-color: var(--text-highlight);
    color: var(--bg-main);
    border: 1px solid var(--text-highlight);
}
</style>
