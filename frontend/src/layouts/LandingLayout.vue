<script setup lang="ts">
import LandingNavbar from "@/components/navbars/LandingNavbar.vue";
</script>

<template>
  <v-main>
    <div
      class="leading-normal tracking-normal text-white gradient landing-font-family"
    >
      <LandingNavbar />
      <div class="pt-24">
        <router-view />
      </div>
    </div>
  </v-main>
</template>

<style>
.gradient {
  background: linear-gradient(90deg, #d53369 0%, #daae51 100%);
}

.landing-font-family {
  font-family: "Source Sans Pro", sans-serif;
}
</style>
