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
<h1>Login dialog</h1>
</template>
