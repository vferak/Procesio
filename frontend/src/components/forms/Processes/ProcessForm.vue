<script setup lang="ts">
import AlertError from "@/components/alerts/AlertError.vue";
import AlertSuccess from "@/components/alerts/AlertSuccess.vue";

const props = defineProps<{
  invalidData: boolean;
  dataSaved?: boolean;
  name: string;
  description: string;
}>();

const emit = defineEmits<{
  (event: "formSubmit"): void;
  (event: "update:name", value: string): void;
  (event: "update:description", value: string): void;
}>();
</script>

<template>
  <div class="card w-full bg-base-200 shadow-xl mt-8 px-10 pt-8 pb-4">
    <form @submit.prevent="emit('formSubmit')" class="card-body">
      <AlertError v-if="props.invalidData" :text="'Invalid form data!'" />
      <AlertSuccess
        v-if="props.dataSaved"
        :text="'Data was successfully saved!'"
      />
      <div class="form-control w-full">
        <label class="label">
          <span class="label-text"> Process name </span>
        </label>
        <input
          :value="props.name"
          @input="emit('update:name', $event.target.value)"
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
          :value="props.description"
          @input="emit('update:description', $event.target.value)"
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
</template>
