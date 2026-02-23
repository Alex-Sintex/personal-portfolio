import { createRouter, createWebHistory } from 'vue-router'
import App from '../App.vue'

const routes = [{ path: '/', component: App }]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to) {
    if (to.hash) {
      return {
        el: to.hash,
        behavior: 'smooth',
      }
    }
    return { top: 0 }
  },
})

export default router
