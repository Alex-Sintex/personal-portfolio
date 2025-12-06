import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import DetailView from "@/views/DetailView.vue";
import LoginView from "@/views/LoginView.vue";
import { useAuth } from "@/store/useAuth";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomeView,
    meta: {
      requiredAuth: true,
    },
  },
  {
    path: "/detail/:id",
    name: "detail",
    component: DetailView,
    meta: {
      requiredAuth: true,
    },
  },
  {
    path: "/login",
    name: "login",
    component: LoginView,
    meta: {
      requiredAuth: false,
    },
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  const store = useAuth();
  if (!store.is_auth && to.meta.requiredAuth) {
    next({ name: "login" });
  } else {
    next();
  }
});

export default router;
