<script setup lang="ts">
import { useRoute, useRouter } from "vue-router";
import type { RouteRecordName } from "vue-router";
import ThemeSwap from "@/components/swaps/ThemeSwap.vue";
import { onBeforeMount, ref } from "vue";
import { useAuthStore, useMetaStore, useWorkspaceStore } from "@/stores";
import type { WorkspaceStoreInterface } from "@/stores";
import type { WorkspaceRepositoryInterface, WorkspaceType } from "@/api";
import { useWorkspaceRepository } from "@/api";

const metaStore = useMetaStore();
const authStore = useAuthStore();
const router = useRouter();
const currentRoute = useRoute();
const workspaceStore: WorkspaceStoreInterface = useWorkspaceStore();
const workspaceRepository: WorkspaceRepositoryInterface =
  useWorkspaceRepository();

const routes = router
  .getRoutes()
  .filter((route) => route.path === "/admin")
  .pop()
  ?.children.filter((route) => route.meta?.navIconClass !== undefined);

const isNavDrawerOpen = ref<boolean>(false);

const workspace = ref<WorkspaceType>({
  uuid: "",
  name: "",
  description: "",
  user: null,
  users: [],
});

onBeforeMount(async () => {
  workspace.value = await workspaceStore.getWorkspace();
});

const workspaces = ref<WorkspaceType[]>([]);

const listAvailableWorkspaces = async (): Promise<void> => {
  workspaces.value = await workspaceRepository.getAll();
};

const changeWorkspace = async (
  workspaceObject: WorkspaceType
): Promise<void> => {
  workspaceStore.setWorkspace(workspaceObject);
  workspace.value = workspaceObject;
};

const redirectAndCloseNavDrawer = (route: RouteRecordName): void => {
  router.push({ name: route });
  isNavDrawerOpen.value = false;
};

const logout = () => {
  authStore.logOut();

  router.push({
    name: "landing",
  });
};
</script>

<template>
  <input
    v-model="isNavDrawerOpen"
    id="navigation-drawer"
    type="checkbox"
    class="drawer-toggle"
  />
  <div class="drawer-content flex flex-col">
    <div class="navbar bg-base-100 mb-8 shadow-xl">
      <div class="flex-none lg:hidden">
        <label for="navigation-drawer" class="btn btn-square btn-ghost">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            class="inline-block w-6 h-6 stroke-current"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"
            ></path>
          </svg>
        </label>
      </div>
      <h3 class="flex-1 px-2 mx-2 text-2xl font-bold">
        {{ metaStore.getTitle() }}
      </h3>
      <div class="flex-none gap-4">
        <div class="dropdown dropdown-end">
          <label tabindex="0" class="btn" @click="listAvailableWorkspaces">
            {{ workspace.name }}
          </label>
          <ul
            tabindex="0"
            class="dropdown-content menu p-2 shadow bg-base-100 mt-3 rounded-box"
          >
            <li v-for="workspace in workspaces" :key="workspace.uuid">
              <a
                class="whitespace-nowrap"
                @click="changeWorkspace(workspace)"
                >{{ workspace.name }}</a
              >
            </li>
          </ul>
        </div>

        <ThemeSwap />

        <div class="dropdown dropdown-end">
          <label tabindex="0" class="btn btn-ghost btn-circle avatar">
            <div class="w-10 rounded-full">
              <img src="https://api.lorem.space/image/face?hash=33791" />
            </div>
          </label>
          <ul
            tabindex="0"
            class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52"
          >
            <li><a @click="router.push({ name: 'user' })">Profile</a></li>
            <li><a @click="logout()">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>

    <slot />
  </div>
  <div class="drawer-side shadow-md">
    <label for="navigation-drawer" class="drawer-overlay"></label>
    <aside class="w-80 bg-base-100 text-base-content">
      <div class="pl-10 pt-5 w-full h-16">
        <h2 class="text-2xl font-bold cursor-pointer">
          <a @click="router.push({ name: 'dashboard' })">Procesio</a>
        </h2>
      </div>
      <ul class="menu p-4 overflow-y-auto">
        <li v-for="route in routes" :key="route.name">
          <a
            class="flex"
            :class="{ active: currentRoute.path.includes(route.path) }"
            @click="redirectAndCloseNavDrawer(route.name)"
          >
            <i class="flex-none" :class="route.meta.navIconClass"></i>
            <span class="flex-1">{{ route.meta.title }}</span>
          </a>
        </li>
      </ul>
    </aside>
  </div>
</template>
