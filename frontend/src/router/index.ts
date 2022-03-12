import { createRouter, createWebHistory } from "vue-router";
import LandingView from "@/views/LandingView.vue";
import LandingLayout from "@/layouts/LandingLayout.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
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
    // {
    //   path: '/admin',
    //   redirect: '/admin/dashboard',
    //   component: () => import("../views/AdminLayout.vue")
    //   children: [
    //     {
    //       path: '/admin/dashboard',
    //       name: 'dashboard',
    //       component: () => import("../views/DashboardView.vue")
    //     }
    //   ]
    // }
  ],
});

export default router;
