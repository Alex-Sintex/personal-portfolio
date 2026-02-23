import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import i18n from './i18n'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {
  faCode,
  faCube,
  faPalette,
  faMobile,
  faMobileAlt,
  faLifeRing,
} from '@fortawesome/free-solid-svg-icons'

// Add icons to the library
library.add(faCode, faCube, faPalette, faMobile, faMobileAlt, faLifeRing)

const app = createApp(App)

app.use(router)
app.use(i18n)
app.component('font-awesome-icon', FontAwesomeIcon)
app.mount('#app')
