<script setup lang="ts">
// import ServerErrorModal from "@/components/modal/predefined/ServerErrorModal.vue";
import { onBeforeMount } from "vue";
import type { AuthStoreInterface } from "@/stores";
import { useAuthStore } from "@/stores";

const authStore: AuthStoreInterface = useAuthStore();

onBeforeMount(() => {
  authStore.loadJwtFromStorage();
});
</script>

<template>
  <router-view />
  <!--  <ServerErrorModal />-->
</template>
