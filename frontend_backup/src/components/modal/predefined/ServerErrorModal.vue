<template>
  <ModalComponent :show="errorHappened" @close="resolveError">
    <template #header>
      <h3 class="text-4xl">500 Server error</h3>
    </template>
    <template #body>
      <p>Oops, something went wrong. Feel free to contact us if the problem persists.</p>
    </template>
    <template #footer>
      <button @click="resolveError" class="btn-primary">OK</button>
    </template>
  </ModalComponent>
</template>

<script lang="ts">
import { computed, defineComponent } from 'vue'
import ModalComponent from '@/components/modal/ModalComponent.vue'
import { useStore } from '@/store'

export default defineComponent({
  name: 'ServerErrorModal',
  components: {
    ModalComponent
  },
  setup () {
    const store = useStore()

    const errorHappened = computed(() => store.getters.isError)

    const resolveError = () => { store.commit('resolveError') }

    return { errorHappened, resolveError }
  }
})
</script>
