import TabMenu from "@/components/TabMenu.vue";
import { createRouter, createWebHistory } from '@ionic/vue-router'
import type { RouteRecordRaw } from "vue-router";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    redirect: "/home",
  },
  {
    path: "/",
    component: TabMenu,
    children: [
      {
        path: "",
        redirect: "/home",
      },
      {
        path: "home",
        component: () => import("@/views/HomePage.vue"),
      },
      {
        path: "radio",
        component: () => import("@/views/RadioPage.vue"),
      },
      {
        path: "library",
        component: () => import("@/views/LibraryPage.vue"),
      },
      {
        path: "search",
        component: () => import("@/views/SearchPage.vue"),
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
