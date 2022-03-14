import {createRouter, createWebHistory } from "vue-router";
import LandingView from "@/views/LandingView.vue";
import LandingLayout from "@/layouts/LandingLayout.vue";
import {useAuthStore} from "@/stores/auth";
import {useDialogStore} from "@/stores/dialog";

const routes = [
  {
    path: "/",
    component: LandingLayout,
    children: [
      {
        path: "/",
        name: "landing",
        component: LandingView,
      },
    ],
  },
  {
    path: "/admin",
    redirect: "/admin/dashboard",
    component: () => import("@/layouts/AdminLayout.vue"),
    children: [
      {
        path: "/admin/dashboard",
        name: "dashboard",
        component: () => import("@/views/DashboardView.vue"),
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();
  const dialogStore = useDialogStore();

  const publicPages = ["/"];
  const authRequired = !publicPages.includes(to.path);
  const loggedIn = authStore.isAuthenticated();

  if (authRequired && !loggedIn) {
    dialogStore.openDialog();
    next("/");
  } else {
    next();
  }
});

export default router;
