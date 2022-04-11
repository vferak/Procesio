import { createRouter, createWebHistory } from "vue-router";
import LandingView from "@/views/LandingView.vue";
import LandingLayout from "@/layouts/LandingLayout.vue";
import { useAuthStore } from "@/stores/auth";
import { useModalStore } from "@/stores/modal";
import type { ModalStore } from "@/stores/modal";
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
      {
        path: "/admin/packages",
        name: "packages",
        component: () => import("@/views/Admin/Packages/PackagesView.vue"),
        meta: {
          title: "Packages",
          navIconClass: "fas fa-cubes",
        },
      },
      {
        path: "/admin/packages/create",
        name: "createPackage",
        component: () => import("@/views/Admin/Packages/CreatePackageView.vue"),
        meta: {
          title: "Create package",
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
  const modalStore: ModalStore = useModalStore();

  const publicPages = ["/"];
  const authRequired = !publicPages.includes(to.path);
  const loggedIn = authStore.isAuthenticated();

  if (authRequired && !loggedIn) {
    modalStore.openModal();
    next("/");
  } else {
    next();
  }
});

export default router;
