<script setup lang="ts">
import { useDialogStore } from "@/stores/dialog";
import { useAuthStore } from "@/stores/auth";
import { ref } from "vue";
import AuthRepository from "@/api/auth";
import { useRouter } from "vue-router";

const authStore = useAuthStore();
const dialogStore = useDialogStore();

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
      dialogStore.closeDialog();

      router.push({
        name: "dashboard",
      });
    });
};
</script>

<template>
  <input type="checkbox" id="my-modal" class="modal-toggle">
  <label for="my-modal" class="modal cursor-pointer">
    <label class="modal-box relative" for="">
      <form @submit.prevent="logIn">
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
        <input type="submit" class="btn block mt-6 mx-auto">
      </form>
    </label>
  </label>
</template>
