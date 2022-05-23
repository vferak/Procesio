<script setup lang="ts">
import { ref } from "vue";
import { useAuthRepository } from "@/api";
import type { AuthRepositoryInterface } from "@/api/auth";

import AlertError from "@/components/alerts/AlertError.vue";
import AlertSuccess from "@/components/alerts/AlertSuccess.vue";

const authRepository: AuthRepositoryInterface = useAuthRepository();

const invalidFormData = ref<boolean>(false);
const formSuccessful = ref<boolean>(false);

const formData = ref<{
  email: string;
  firstName: string;
  lastName: string;
  password: string;
  passwordAgain: string;
}>({
  email: "",
  firstName: "",
  lastName: "",
  password: "",
  passwordAgain: "",
});

const submitForm = function (): void {
  const email = formData.value.email;
  const password = formData.value.password;
  const passwordAgain = formData.value.passwordAgain;
  const firstName = formData.value.firstName;
  const lastName = formData.value.lastName;

  if (email === "" || password === "" || firstName === "" || lastName === "" || passwordAgain === "" || password !== passwordAgain) {
    invalidFormData.value = true;
    return;
  }

  authRepository
    .register(email, firstName, lastName, password)
    .catch((error) => {
      invalidFormData.value = true;
      throw error;
    })
    .then((response) => {
      invalidFormData.value = false;
      formSuccessful.value = true;
    });
};
</script>

<template>
  <label for="registerModal" class="btn btn-primary modal-button">
    Register
  </label>

  <input type="checkbox" id="registerModal" class="modal-toggle" />

  <label for="registerModal" class="modal cursor-pointer">
    <label class="modal-box relative prose">
      <AlertError v-if="invalidFormData" :text="'Registration failed, please check your data.'" />
      <h2>Register</h2>
      <AlertSuccess v-if="formSuccessful" :text="'Registration successful, please log in.'" />
      <form v-if="!formSuccessful" @submit.prevent="submitForm">
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">E-mail</span>
          </label>
          <input
            v-model="formData.email"
            type="text"
            placeholder="Type here"
            class="input input-bordered w-full"
            name="email"
            required
          />
        </div>
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">First name</span>
          </label>
          <input
            v-model="formData.firstName"
            type="text"
            placeholder="Type here"
            class="input input-bordered w-full"
            name="firstName"
            required
          />
        </div>
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">Last name</span>
          </label>
          <input
            v-model="formData.lastName"
            type="text"
            placeholder="Type here"
            class="input input-bordered w-full"
            name="lastName"
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
            name="password"
            required
          />
        </div>
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">Password again</span>
          </label>
          <input
            v-model="formData.passwordAgain"
            type="password"
            placeholder="Type here"
            class="input input-bordered w-full"
            name="passwordAgain"
            required
          />
        </div>
        <div class="flex justify-center">
          <input type="submit" class="btn mt-6" name="registerSubmit" />
        </div>
      </form>
    </label>
  </label>
</template>
