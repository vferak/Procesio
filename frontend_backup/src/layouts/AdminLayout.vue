<template>
  <div class="bg-gray-800 font-sans leading-normal tracking-normal mt-12">
    <router-view/>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'AdminLayout'
})
</script>
