<script setup lang="ts">
import { useDialogStore } from "@/stores/dialog";
import { useAuthStore } from "@/stores/auth";
import { ref } from "vue";
import AuthRepository from "@/api/auth";
import router from "@/router";

const authStore = useAuthStore();
const dialogStore = useDialogStore();

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
  <v-row justify="center">
    <v-dialog v-model="dialogStore.isOpen">
      <v-card width="600px">
        <v-card-title>
          <span class="text-h5">Log In</span>
        </v-card-title>
        <v-alert v-show="invalidCredentials" type="error" class="mx-8"
          >Invalid credentials!</v-alert
        >
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="email"
                  label="Email*"
                  variant="contained"
                  hide-details="auto"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="password"
                  label="Password*"
                  type="password"
                  variant="contained"
                  hide-details="auto"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6"> </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions class="pb-6">
          <v-btn
            color="primary darken-1"
            text
            size="large"
            @click="logIn"
            class="mx-auto"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
