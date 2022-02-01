<template>
  <div v-if="show" @click="close" class="fixed table z-50 top-0 left-0 w-full h-full bg-black bg-opacity-50">
    <div class="table-cell align-middle">
      <div @click.stop class="w-1/2 mx-auto py-14 px-16 bg-white text-black text-center divide-y divide-gray-400">
        <div class="text-left mb-4">
          <slot name="header">
            <p>default header</p>
          </slot>
        </div>

        <div class="pt-4 mb-4">
          <slot name="body">
            <p>default body</p>
          </slot>
        </div>

        <div class="pt-4">
          <slot name="footer">
            <p>default footer</p>
            <button @click="close" class="btn-primary">OK</button>
          </slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'ModalComponent',
  props: {
    show: Boolean
  },
  emits: ['close'],
  setup (props, context) {
    return {
      close: () => context.emit('close')
    }
  }
})
</script>
