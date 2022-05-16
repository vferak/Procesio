<script setup lang="ts">
import { useRouter } from "vue-router";
import { useSubprocessRepository } from "@/api";
import type { SubprocessType, SubprocessRepositoryInterface } from "@/api";
import BackButton from "@/components/buttons/BackButton.vue";
import { onBeforeMount, ref } from "vue";
import SubprocessForm from "@/components/forms/Subprocesses/SubprocessForm.vue";

const router = useRouter();
const subprocessRepository: SubprocessRepositoryInterface =
  useSubprocessRepository();

const subprocessUuid = router.currentRoute.value.params.uuid.toString();

const subprocess = ref<SubprocessType>({
  description: "",
  name: "",
  priority: 0,
  process_uuid: "",
  uuid: "",
});

onBeforeMount(async (): Promise<void> => {
  subprocess.value = await subprocessRepository.getByUuid(subprocessUuid);
});

const invalidData = ref<boolean>(false);

const submitForm = async (): Promise<void> => {
  try {
    const response = await subprocessRepository.edit(
      subprocess.value.name,
      subprocess.value.description,
      subprocess.value.priority,
      subprocess.value.uuid
    );

    await router.push({
      name: "process",
      params: { uuid: response.process_uuid },
    });
  } catch (response) {
    invalidData.value = true;
  }
};
</script>

<template>
  <div v-if="subprocess.uuid !== ''" class="container mx-auto h-full">
    <BackButton
      :routeName="'process'"
      :params="{ uuid: subprocess.process_uuid }"
    />
    <SubprocessForm
      v-model:name="subprocess.name"
      v-model:description="subprocess.description"
      v-model:priority="subprocess.priority"
      v-model:invalid-data="invalidData"
      @formSubmit="submitForm"
    />
  </div>
</template>
