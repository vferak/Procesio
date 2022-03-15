<script setup lang="ts">
import AdminNavbar from "@/components/navbars/AdminNavbar.vue";
</script>
<template>
  <div class="h-screen drawer drawer-mobile w-full">
    <AdminNavbar>
      <router-view />
    </AdminNavbar>
  </div>
</template>
