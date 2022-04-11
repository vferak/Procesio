<script setup lang="ts">
import { useRouter } from "vue-router";
import { usePackageRepository } from "@/api";
import { ref } from "vue";
import AlertError from "@/components/alerts/AlertError.vue";

const router = useRouter();
const packageRepository = usePackageRepository();

const formData = ref<{
  name: string;
  description: string;
}>({
  name: "",
  description: "",
});

const invalidCredentials = ref<boolean>(false);

const submitForm = (): void => {
  const name = formData.value.name;
  const description = formData.value.description;

  if (
    name === "" ||
    description === "" ||
    name.length > 255 ||
    description.length > 255
  ) {
    invalidCredentials.value = true;
    return;
  }

  packageRepository.create(name, description).then(() => {
    router.push({ name: "packages" });
  });
};
</script>

<template>
  <div class="container mx-auto h-full">
    <div class="flex justify-between w-full">
      <a @click="router.push({ name: 'packages' })" class="btn btn-outline">
        Back
      </a>
    </div>
    <div class="card w-full bg-base-200 shadow-xl mt-8 px-10 pt-8 pb-4">
      <form @submit.prevent="submitForm" class="card-body">
        <AlertError v-if="invalidCredentials" :text="'Invalid form data!'" />
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text"> Package name </span>
          </label>
          <input
            v-model="formData.name"
            type="text"
            placeholder="Type here"
            class="input input-bordered w-full"
            name="name"
            required
          />
        </div>
        <div class="form-control">
          <label class="label">
            <span class="label-text">Description</span>
          </label>
          <textarea
            v-model="formData.description"
            class="textarea textarea-bordered h-32"
            placeholder="Type here"
            name="description"
            required
          ></textarea>
        </div>
        <div class="flex justify-center mt-6">
          <input
            type="submit"
            name="submit"
            value="Save"
            class="btn btn-primary"
          />
        </div>
      </form>
    </div>
  </div>
</template>
