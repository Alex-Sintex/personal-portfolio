import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

// ✅ Correct imports
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap-vue-next/dist/bootstrap-vue-next.css'
import { createBootstrap } from 'bootstrap-vue-next'

createApp(App)
  .use(router)
  .use(createBootstrap())
  .mount('#app')
