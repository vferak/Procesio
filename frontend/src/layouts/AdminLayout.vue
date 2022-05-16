<script setup lang="ts">
import AdminNavbar from "@/components/navbars/AdminNavbar.vue";

import { onBeforeMount, onBeforeUnmount } from "vue";
import { useThemeStore } from "@/stores/theme";
import { useWorkspaceStore } from "@/stores";

const themeStore = useThemeStore();
const workspaceStore = useWorkspaceStore();

onBeforeMount(() => {
  themeStore.setTheme();
});

onBeforeUnmount(() => {
  themeStore.setDefaultTheme();
});
</script>
<template>
  <div class="h-screen drawer drawer-mobile w-full">
    <AdminNavbar>
      <router-view :key="workspaceStore.getWorkspaceUuid()" />
    </AdminNavbar>
  </div>
</template>
