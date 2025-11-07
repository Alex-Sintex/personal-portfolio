import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import NoteListView from "@/views/NoteListView.vue";
import LoginView from "@/views/LoginView.vue";
import RegisterView from "@/views/RegisterView.vue";
import NoteCreateView from "@/views/NoteCreateView.vue";
import useAuth from "@/store/auth";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    name: "list",
    component: NoteListView,
    meta: { requiresAuth: true },
  },
  {
    path: "/login",
    name: "login",
    component: LoginView,
    meta: { requiresAuth: false },
  },
  {
    path: "/register",
    name: "register",
    component: RegisterView,
    meta: { requiresAuth: false },
  },
  {
    path: "/create",
    name: "create",
    component: NoteCreateView,
    meta: { requiresAuth: true },
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  const auth = useAuth();
  const isAuth = auth.token;

  if (to.meta.requiresAuth && !isAuth) {
    next({ name: "login" });
  } else {
    next();
  }
});

export default router;
