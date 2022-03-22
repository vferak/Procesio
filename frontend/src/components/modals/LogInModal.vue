<script setup lang="ts">
import { useModalStore } from "@/stores/modal";
import type { ModalStore } from "@/stores/modal";
import { useAuthStore } from "@/stores/auth";
import { ref } from "vue";
import AuthRepository from "@/api/auth";
import { useRouter } from "vue-router";
import AlertError from "@/components/alerts/AlertError.vue";

const authStore = useAuthStore();
const modalStore: ModalStore = useModalStore();

const router = useRouter();

const invalidCredentials = ref<boolean>(false);

const email = ref<string>();
const password = ref<string>();

const logIn = function (): void {
  if (email.value === undefined) {
    return;
  }

  if (password.value === undefined) {
    return;
  }

  AuthRepository.authenticate(email.value, password.value)
    .catch((error) => {
      invalidCredentials.value = true;
      throw error;
    })
    .then((response) => {
      authStore.logIn(response.data.data.token);
      modalStore.closeModal();

      router.push({
        name: "dashboard",
      });
    });
};
</script>

<template>
  <label for="loginModal" class="btn modal-button">Log in</label>

  <input type="checkbox" id="loginModal" class="modal-toggle" />

  <label for="loginModal" class="modal cursor-pointer">
    <label class="modal-box relative" for="">
      <form @submit.prevent="logIn">
        <AlertError v-if="invalidCredentials" :text="'Invalid credentials!'" />
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">E-mail</span>
          </label>
          <input v-model="email" type="text" placeholder="Type here" class="input input-bordered w-full">
        </div>
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">Password</span>
          </label>
          <input v-model="password" type="password" placeholder="Type here" class="input input-bordered w-full">
        </div>
        <input type="submit" class="btn block mt-6 mx-auto" />
      </form>
    </label>
  </label>
</template>
