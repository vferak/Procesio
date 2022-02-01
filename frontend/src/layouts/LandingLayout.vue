<template>
  <div class="leading-normal tracking-normal text-white gradient landing-font-family">
    <LandingNavbar />
    <div class="pt-24">
      <router-view/>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import LandingNavbar from '@/components/navbar/LandingNavbar.vue'

export default defineComponent({
  name: 'LandingLayout',
  components: { LandingNavbar }
})
</script>

<style>
.gradient {
  background: linear-gradient(90deg, #d53369 0%, #daae51 100%);
}

.landing-font-family {
  font-family: 'Source Sans Pro', sans-serif;
}
</style>
