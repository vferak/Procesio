<template>
  <div id="myDropdown" ref="dropdown"
       class="dropdownlist absolute bg-gray-800 text-white right-0 mt-3 p-3 overflow-auto z-30">
    <a href="#"
       class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block whitespace-nowrap"><i
      class="fa fa-user fa-fw inline mr-2"></i> Profile</a>
    <a href="#"
       class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block whitespace-nowrap"><i
      class="fa fa-cog fa-fw inline mr-2"></i> Settings</a>
    <div class="border border-gray-800"></div>
    <a @click="logout" href="#"
       class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block whitespace-nowrap"><i
      class="fas fa-sign-out-alt fa-fw inline mr-2"></i> Log Out</a>
  </div>
</template>

<script lang="ts">
import { defineComponent, onBeforeUnmount, onMounted, ref } from 'vue'

export default defineComponent({
  name: 'AdminNavbarUserDropdown',
  emits: ['close', 'logout'],
  setup (props, context) {
    const dropdown = ref()

    const hideUserDropdown = (e: Event) => {
      const $el = dropdown.value as HTMLDivElement
      const $target = e.target as Node

      if (!$el.contains($target)) {
        context.emit('close')
      }
    }

    const logout = () => {
      context.emit('logout')
    }

    onMounted(() => {
      document.addEventListener('click', hideUserDropdown)
    })

    onBeforeUnmount(() => {
      document.removeEventListener('click', hideUserDropdown)
    })

    return {
      dropdown,
      logout
    }
  }
})
</script>
