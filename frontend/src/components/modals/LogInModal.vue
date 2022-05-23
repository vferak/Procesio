<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";
import AlertError from "@/components/alerts/AlertError.vue";
import { useWorkspaceRepository, useAuthRepository } from "@/api";
import { useModalStore, useAuthStore, useWorkspaceStore } from "@/stores";

const router = useRouter();
const authStore = useAuthStore();
const modalStore = useModalStore();
const workspaceStore = useWorkspaceStore();
const authRepository = useAuthRepository();
const workspaceRepository = useWorkspaceRepository();

const invalidCredentials = ref<boolean>(false);

const formData = ref<{
  email: string;
  password: string;
}>({
  email: "",
  password: "",
});

const submitForm = async function (): Promise<void> {
  const email = formData.value.email;
  const password = formData.value.password;
  if (email === "" || password === "") {
    invalidCredentials.value = true;
    return;
  }

  authStore.logOut();

  authRepository
    .authenticate(email, password)
    .catch((error) => {
      invalidCredentials.value = true;
      throw error;
    })
    .then(async (response) => {
      authStore.logIn(response.data.data.token);
      modalStore.closeModal();

      const workspace =
        await workspaceRepository.getDefaultWorkspaceForUserUuid();

      workspaceStore.setWorkspace(workspace);

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
            name="loginEmail"
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
            name="loginPassword"
            required
          />
        </div>
        <div class="flex justify-center">
          <input type="submit" name="loginSubmit" class="btn mt-6" />
        </div>
      </form>
    </label>
  </label>
</template>
