<script setup lang="ts">
// import ServerErrorModal from "@/components/modal/predefined/ServerErrorModal.vue";
import { onBeforeMount } from "vue";
import { useThemeStore } from "@/stores/theme";

const themeStore = useThemeStore();

onBeforeMount(() => {
  themeStore.setTheme();
});
</script>

<template>
  <router-view />
  <!--  <ServerErrorModal />-->
</template>
