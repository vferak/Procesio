<script setup lang="ts">
import { onBeforeMount, ref } from "vue";
import AlertError from "@/components/alerts/AlertError.vue";
import { usePackageRepository } from "@/api";

const packageRepository = usePackageRepository();

const props = defineProps<{
  invalidData: boolean;
  packageUuid?: string;
}>();

const emit = defineEmits<{
  (event: "formSubmit", name: string, description: string): void;
}>();

const invalidData = ref<boolean>(false);

const formData = ref<{
  name: string;
  description: string;
}>({
  name: "",
  description: "",
});

onBeforeMount(async () => {
  if (props.packageUuid !== undefined) {
    const response = await packageRepository.getByUuid(props.packageUuid);
    formData.value.name = response.name;
    formData.value.description = response.description;
  }
});

const submitForm = (): void => {
  const name = formData.value.name;
  const description = formData.value.description;

  if (
    name === "" ||
    description === "" ||
    name.length > 255 ||
    description.length > 255
  ) {
    invalidData.value = true;
    return;
  }

  emit("formSubmit", name, description);
};
</script>

<template>
  <div class="card w-full bg-base-200 shadow-xl mt-8 px-10 pt-8 pb-4">
    <form @submit.prevent="submitForm" class="card-body">
      <AlertError
        v-if="props.invalidData || invalidData"
        :text="'Invalid form data!'"
      />
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
</template>
