import { createRouter, createWebHistory } from "vue-router";
import LandingView from "@/views/LandingView.vue";
import LandingLayout from "@/layouts/LandingLayout.vue";
import { useAuthStore } from "@/stores/auth";
import { useDialogStore } from "@/stores/dialog";
import { useMetaStore } from "@/stores/meta";

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
        component: () => import("@/views/Admin/DashboardView.vue"),
        meta: {
          title: "Dashboard",
          navIconClass: "fas fa-th-large",
        },
      },
      {
        path: "/admin/projects",
        name: "projects",
        component: () => import("@/views/Admin/Projects/ProjectsView.vue"),
        meta: {
          title: "Projects",
          navIconClass: "fas fa-bookmark",
        },
      },
      {
        path: "/admin/projects/create",
        name: "createProject",
        component: () => import("@/views/Admin/Projects/CreateProjectView.vue"),
        meta: {
          title: "Create project",
        },
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  const metaStore = useMetaStore();

  // eslint-disable-next-line @typescript-eslint/ban-ts-comment
  // @ts-ignore
  const title: string = to.meta.title ? to.meta.title : "";
  metaStore.setTitle(title);

  document.title = metaStore.getSiteTitle();

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
