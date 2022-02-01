<template>

  <router-view/>

  <ServerErrorModal />

</template>

<script lang="ts">
import { defineComponent } from 'vue'
import ServerErrorModal from '@/components/modal/predefined/ServerErrorModal.vue'

export default defineComponent({
  name: 'App',
  components: { ServerErrorModal }
})
</script>
