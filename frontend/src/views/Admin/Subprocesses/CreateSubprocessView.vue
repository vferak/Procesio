<script setup lang="ts">
import { useRouter } from "vue-router";
import { useSubprocessRepository } from "@/api";
import type { SubprocessType, SubprocessRepositoryInterface } from "@/api";
import BackButton from "@/components/buttons/BackButton.vue";
import { ref } from "vue";
import SubprocessForm from "@/components/forms/Subprocesses/SubprocessForm.vue";

const router = useRouter();
const subprocessRepository: SubprocessRepositoryInterface =
  useSubprocessRepository();

const processUuid = router.currentRoute.value.params.uuid.toString();

const subprocess = ref<SubprocessType>({
  description: "",
  name: "",
  priority: 0,
  process_uuid: "",
  uuid: "",
});

const invalidData = ref<boolean>(false);

const submitForm = async (): Promise<void> => {
  try {
    const process = await subprocessRepository.create(
      subprocess.value.name,
      subprocess.value.description,
      subprocess.value.priority,
      processUuid
    );

    await router.push({ name: "process", params: { uuid: process.uuid } });
  } catch (response) {
    invalidData.value = true;
  }
};
</script>

<template>
  <div class="container mx-auto h-full">
    <BackButton :routeName="'processes'" :params="{ uuid: processUuid }" />
    <SubprocessForm
      v-model:name="subprocess.name"
      v-model:description="subprocess.description"
      v-model:priority="subprocess.priority"
      v-model:invalid-data="invalidData"
      @formSubmit="submitForm"
    />
  </div>
</template>
