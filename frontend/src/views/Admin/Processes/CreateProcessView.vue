<script setup lang="ts">
import { useRouter } from "vue-router";
import { useProcessRepository } from "@/api";
import type { ProcessType, ProcessRepositoryInterface } from "@/api";
import ProcessForm from "@/components/forms/Processes/ProcessForm.vue";
import BackButton from "@/components/buttons/BackButton.vue";
import { ref } from "vue";

const router = useRouter();
const processRepository: ProcessRepositoryInterface = useProcessRepository();

const process = ref<ProcessType>({
  comesFrom: null,
  description: "",
  name: "",
  packages: [],
  subprocesses: [],
  uuid: "",
});

const invalidData = ref<boolean>(false);

const submitForm = async (): Promise<void> => {
  try {
    await processRepository.create(
      process.value.name,
      process.value.description
    );
    await router.push({ name: "processes" });
  } catch (response) {
    invalidData.value = true;
  }
};
</script>

<template>
  <div class="container mx-auto h-full">
    <BackButton :routeName="'processes'" />
    <ProcessForm
      :invalid-data="invalidData"
      v-model:name="process.name"
      v-model:description="process.description"
      @formSubmit="submitForm"
    />
  </div>
</template>
