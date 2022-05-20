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
        path: "/admin/projects/edit/:uuid",
        name: "editProject",
        component: () => import("@/views/Admin/Projects/EditProjectView.vue"),
        meta: {
          title: "Edit project",
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
      {
        path: "/admin/packages/edit/:uuid",
        name: "editPackage",
        component: () => import("@/views/Admin/Packages/EditPackageView.vue"),
        meta: {
          title: "Edit package",
        },
      },
      {
        path: "/admin/processes",
        name: "processes",
        component: () => import("@/views/Admin/Processes/ProcessesView.vue"),
        meta: {
          title: "Processes",
          navIconClass: "fas fa-cube",
        },
      },
      {
        path: "/admin/processes/create",
        name: "createProcess",
        component: () =>
          import("@/views/Admin/Processes/CreateProcessView.vue"),
        meta: {
          title: "Create process",
        },
      },
      {
        path: "/admin/processes/:uuid",
        name: "process",
        component: () => import("@/views/Admin/Processes/ProcessView.vue"),
        meta: {
          title: "Process",
        },
      },
      {
        path: "/admin/processes/subprocess/create/:uuid",
        name: "createSubprocess",
        component: () =>
          import("@/views/Admin/Subprocesses/CreateSubprocessView.vue"),
        meta: {
          title: "Create subprocess",
        },
      },
      {
        path: "/admin/processes/subprocess/edit/:uuid",
        name: "editSubprocess",
        component: () =>
          import("@/views/Admin/Subprocesses/EditSubprocessView.vue"),
        meta: {
          title: "Edit subprocess",
        },
      },
      {
        path: "/admin/workspaces",
        name: "workspaces",
        component: () => import("@/views/Admin/Workspaces/WorkspacesView.vue"),
        meta: {
          title: "Workspaces",
          navIconClass: "fas fa-users",
        },
      },
      {
        path: "/admin/workspaces/create",
        name: "createWorkspace",
        component: () =>
          import("@/views/Admin/Workspaces/CreateWorkspaceView.vue"),
        meta: {
          title: "Create workspace",
        },
      },
      {
        path: "/admin/workspaces/edit/:uuid",
        name: "editWorkspaces",
        component: () =>
          import("@/views/Admin/Workspaces/EditWorkspaceView.vue"),
        meta: {
          title: "Edit workspace",
        },
      },
      {
        path: "/admin/workspaces/:uuid",
        name: "workspace",
        component: () => import("@/views/Admin/Workspaces/WorkspaceView.vue"),
        meta: {
          title: "Workspace",
        },
      },
      {
        path: "/admin/user",
        name: "user",
        component: () => import("@/views/Admin/Users/UserView.vue"),
        meta: {
          title: "User profile",
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
