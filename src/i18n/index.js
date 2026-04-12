import { createI18n } from 'vue-i18n'
import en from './en.json'
import es from './es.json'

// Function to detect user's system language
function detectSystemLanguage() {
  // Check if language was previously saved in localStorage
  const savedLang = localStorage.getItem('lang')
  if (savedLang) {
    return savedLang
  }

  // Get browser language
  const browserLang = navigator.language || navigator.userLanguage
  
  // Extract language code (e.g., 'es' from 'es-ES')
  const langCode = browserLang.split('-')[0].toLowerCase()
  
  // Supported languages
  const supportedLangs = ['en', 'es']
  
  // Return the language if supported, otherwise default to English
  return supportedLangs.includes(langCode) ? langCode : 'en'
}

export default createI18n({
  legacy: false,
  locale: detectSystemLanguage(),
  fallbackLocale: 'en',
  messages: {
    en,
    es,
  },
})
