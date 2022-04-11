<script setup lang="ts">
import { useModalStore } from "@/stores/modal";
import type { ModalStore } from "@/stores/modal";
import { useAuthStore } from "@/stores/auth";
import { ref } from "vue";
import { useAuthRepository } from "@/api/auth";
import type { AuthRepositoryInterface } from "@/api/auth";
import { useRouter } from "vue-router";
import AlertError from "@/components/alerts/AlertError.vue";

const router = useRouter();
const authStore = useAuthStore();
const modalStore: ModalStore = useModalStore();
const authRepository: AuthRepositoryInterface = useAuthRepository();

const invalidCredentials = ref<boolean>(false);

const formData = ref<{
  email: string;
  password: string;
}>({
  email: "",
  password: "",
});

const submitForm = function (): void {
  const email = formData.value.email;
  const password = formData.value.password;
  if (email === "" || password === "") {
    invalidCredentials.value = true;
    return;
  }

  authRepository
    .authenticate(email, password)
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
    <label class="modal-box relative prose">
      <AlertError v-if="invalidCredentials" :text="'Invalid credentials!'" />
      <h2>Log In</h2>
      <form @submit.prevent="submitForm">
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">E-mail</span>
          </label>
          <input
            v-model="formData.email"
            type="text"
            placeholder="Type here"
            class="input input-bordered w-full"
            required
          />
        </div>
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">Password</span>
          </label>
          <input
            v-model="formData.password"
            type="password"
            placeholder="Type here"
            class="input input-bordered w-full"
            required
          />
        </div>
        <div class="flex justify-center">
          <input type="submit" class="btn mt-6" />
        </div>
      </form>
    </label>
  </label>
</template>
