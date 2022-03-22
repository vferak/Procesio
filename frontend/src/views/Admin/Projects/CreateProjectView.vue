<script setup lang="ts">
import { useRouter } from "vue-router";

const router = useRouter();

const submitForm = (): void => {
  return;
};
</script>

<template>
  <div class="container mx-auto h-full">
    <div class="flex justify-between w-full">
      <a @click="router.push({ name: 'projects' })" class="btn btn-outline">
        Back
      </a>
    </div>
    <div class="card w-full bg-base-200 shadow-xl mt-8 px-10 pt-8 pb-4">
      <form @submit.prevent="submitForm" class="card-body">
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text"> Project name </span>
          </label>
          <input
            type="text"
            placeholder="Type here"
            class="input input-bordered w-full"
            required
          />
        </div>
        <div class="form-control">
          <label class="label">
            <span class="label-text">Description</span>
          </label>
          <textarea
            class="textarea textarea-bordered h-32"
            placeholder="Type here"
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
