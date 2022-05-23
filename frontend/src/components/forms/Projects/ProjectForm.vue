<script setup lang="ts">
import { onBeforeMount, ref } from "vue";
import AlertError from "@/components/alerts/AlertError.vue";
import { usePackageRepository, useProjectRepository } from "@/api";
import type { PackageType } from "@/api";

const projectRepository = useProjectRepository();
const packageRepository = usePackageRepository();

const props = defineProps<{
  invalidData: boolean;
  projectUuid?: string;
}>();

const emit = defineEmits<{
  (
    event: "formSubmit",
    name: string,
    description: string,
    packageUuid: string
  ): void;
}>();

const invalidData = ref<boolean>(false);

const packages = ref<PackageType[]>([]);

const formData = ref<{
  name: string;
  description: string;
  packageUuid: string;
}>({
  name: "",
  description: "",
  packageUuid: "",
});

onBeforeMount(async () => {
  if (props.projectUuid !== undefined) {
    const response = await projectRepository.getByUuid(props.projectUuid);
    formData.value.name = response.name;
    formData.value.description = response.description;
    formData.value.packageUuid = response.package.uuid;
  }

  packages.value = await packageRepository.getAll();
});

const submitForm = (): void => {
  const name = formData.value.name;
  const description = formData.value.description;
  const packageUuid = formData.value.packageUuid;

  if (name === "" || description === "" || packageUuid === "") {
    invalidData.value = true;
    return;
  }

  emit("formSubmit", name, description, packageUuid);
};
</script>

<template>
  <div class="card w-full bg-base-200 shadow-xl mt-8 px-10 pt-8 pb-4">
    <form @submit.prevent="submitForm" class="card-body">
      <AlertError
        v-if="props.invalidData || invalidData"
        :text="'Invalid form data!'"
      />
      <div class="w-full flex flex-row">
        <div
          class="form-control"
          :class="
            props.projectUuid === undefined ? 'basis-1/2 mr-6' : 'basis-full'
          "
        >
          <label class="label">
            <span class="label-text"> Project name </span>
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
        <div
          v-if="props.projectUuid === undefined"
          class="form-control basis-1/2"
        >
          <label class="label">
            <span class="label-text">Package</span>
          </label>
          <select
            class="select select-bordered w-full"
            v-model="formData.packageUuid"
          >
            <option disabled selected :value="''">
              Select package for project
            </option>
            <option
              v-for="processPackage in packages"
              :key="processPackage.uuid"
              :value="processPackage.uuid"
            >
              {{ processPackage.name }}
            </option>
          </select>
        </div>
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
