import { createRouter, createWebHashHistory } from "vue-router";

import SettingsPage from "./pages/settings.vue";

const routes = [
  {
    path: "/",
    name: "Settings",
    component: SettingsPage,
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  if (!document.startViewTransition) return next();

  document.startViewTransition(() => {
    next(); // continue navigation
  });
});

export default router;
