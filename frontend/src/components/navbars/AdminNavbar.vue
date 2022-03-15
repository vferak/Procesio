<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { useMetaStore } from "@/stores/meta";

const metaStore = useMetaStore();
const authStore = useAuthStore();
const router = useRouter();

const rail = ref<boolean>(false);

const logout = () => {
  authStore.logOut();

  router.push({
    name: "landing",
  });
};
</script>

<template>
<h1>Admin navbar</h1>
</template>
