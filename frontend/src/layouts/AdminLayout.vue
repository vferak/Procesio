<script setup lang="ts">
import AdminNavbar from "@/components/navbars/AdminNavbar.vue";
</script>
<template>
  <AdminNavbar></AdminNavbar>
  <v-main class="h-max">
    <router-view />
  </v-main>
</template>
