<template>
  <form v-if="isModalOpened" @submit.prevent="submitForm" class="mb-4">
    <ModalComponent :show="isModalOpened" @close="closeModal">
      <template #header>
        <div class="text-center">
          <h1 class="text-3xl font-semibold text-gray-700">Sign in</h1>
          <p class="text-gray-500">Sign in to access your account</p>
        </div>
      </template>
      <template #body>
        <div class="m-6 text-left">
            <div class="mb-6">
              <label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Email Address</label>
              <input v-model="email" type="email" name="email" id="email" placeholder="Your email address" required class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
            </div>
            <div class="mb-6">
              <div class="flex justify-between mb-2">
                <label for="password" class="text-sm text-gray-600 dark:text-gray-400">Password</label>
                <a href="#!" class="text-sm text-gray-400 focus:outline-none focus:text-indigo-500 hover:text-indigo-500 dark:hover:text-indigo-300">Forgot password?</a>
              </div>
              <input v-model="password" type="password" name="password" id="password" placeholder="Your password" required class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
            </div>
        </div>
      </template>
      <template #footer>
        <div class="mb-6">
          <input type="submit" value="Sign in" class="bg-yellow-200 w-full px-3 py-4 text-lg text-black rounded-md cursor-pointer focus:outline-none duration-100 ease-in-out">
        </div>
        <p class="text-sm text-center text-gray-400">
          Don&#x27;t have an account yet?
          <a href="#!" class="font-semibold text-indigo-500 focus:text-indigo-600 focus:outline-none focus:underline">Sign up</a>.
        </p>
      </template>
    </ModalComponent>
  </form>
</template>

<script lang="ts">
import { computed, defineComponent, ref } from 'vue'
import AuthRepository from '@/api/auth'
import ModalComponent from '@/components/modal/ModalComponent.vue'
import { useStore } from '@/store'
import { useRouter } from 'vue-router'

export default defineComponent({
  name: 'LogInModal',
  components: {
    ModalComponent
  },
  setup () {
    const store = useStore()
    const router = useRouter()

    const email = ref('')
    const password = ref('')

    const isModalOpened = computed(() => store.getters.isLoginModalOpened)
    const closeModal = () => {
      store.commit('closeLoginModal')
      email.value = ''
      password.value = ''
    }

    const submitForm = (): void => {
      AuthRepository.authenticate(email.value, password.value)
        .then((response) => {
          localStorage.setItem('jwt', response.data.data.token)
        })

      store.commit('login')

      router.push({
        name: 'dashboard'
      })
    }

    return { isModalOpened, closeModal, email, password, submitForm }
  }
})
</script>
