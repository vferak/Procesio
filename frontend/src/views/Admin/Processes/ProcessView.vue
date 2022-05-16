<script setup lang="ts">
import { useRouter } from "vue-router";
import { useProcessRepository, useSubprocessRepository } from "@/api";
import type {
  ProcessType,
  ProcessRepositoryInterface,
  SubprocessRepositoryInterface,
} from "@/api";
import ProcessForm from "@/components/forms/Processes/ProcessForm.vue";
import BackButton from "@/components/buttons/BackButton.vue";
import { onBeforeMount, ref } from "vue";
import AlertInfo from "@/components/alerts/AlertInfo.vue";

const router = useRouter();
const processRepository: ProcessRepositoryInterface = useProcessRepository();
const subprocessRepository: SubprocessRepositoryInterface =
  useSubprocessRepository();

const processUuid = router.currentRoute.value.params.uuid.toString();

const process = ref<ProcessType>();

onBeforeMount(async (): Promise<void> => {
  process.value = await processRepository.getByUuid(processUuid);
});

const invalidData = ref<boolean>(false);
const dataSaved = ref<boolean>(false);

const submitForm = async (): Promise<void> => {
  if (process.value === undefined) {
    return;
  }

  try {
    await processRepository.edit(
      process.value.name,
      process.value.description,
      processUuid
    );

    dataSaved.value = true;

    setTimeout(() => {
      dataSaved.value = false;
    }, 3000);
  } catch (response) {
    invalidData.value = true;
  }
};

const removeSubprocess = async (subprocessUuid: string): Promise<void> => {
  const isConfirmed = confirm(
    "Are you sure you want to delete this subprocess?"
  );

  if (!isConfirmed) {
    return;
  }

  const response = await subprocessRepository.remove(subprocessUuid);
  process.value = await processRepository.getByUuid(response.uuid);

  await router.push({
    name: "process",
    params: { uuid: response.uuid },
  });
};
</script>

<template>
  <div v-if="process !== undefined" class="container mx-auto h-full">
    <BackButton :routeName="'processes'" />
    <div class="grid grid-cols-2 xl:grid-cols-6 gap-4 mt-6">
      <div class="col-span-2">
        <div class="card w-full bg-primary text-primary-content">
          <div class="card-body">
            <h2 class="card-title">{{ process.name }}</h2>
            <p>{{ process.description }}</p>
          </div>
        </div>
        <ProcessForm
          v-model:name="process.name"
          v-model:description="process.description"
          v-model:invalid-data="invalidData"
          v-model:data-saved="dataSaved"
          @formSubmit="submitForm"
        />
      </div>
      <div class="col-span-4">
        <div class="flex justify-between w-full mb-6">
          <h3 class="text-2xl font-bold pt-2">
            Subprocesses of {{ process.name }}
          </h3>
          <a
            @click="
              router.push({
                name: 'createSubprocess',
                params: { uuid: processUuid },
              })
            "
            class="btn btn-secondary"
          >
            New subprocess
          </a>
        </div>
        <AlertInfo
          v-if="process.subprocesses.length === 0"
          :text="'No subprocesses have been created yet. Go ahead and make one!'"
        />
        <table v-else class="table table-zebra table-fixed w-full">
          <thead>
            <tr>
              <th class="text-center w-24">Priority</th>
              <th>Name</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="subprocess in process.subprocesses"
              :key="subprocess.uuid"
              class="hover"
            >
              <th class="text-center">{{ subprocess.priority }}</th>
              <td>{{ subprocess.name }}</td>
              <td>
                <a
                  @click="removeSubprocess(subprocess.uuid)"
                  class="btn btn-primary float-right"
                  >Remove</a
                >
                <a
                  @click="
                    router.push({
                      name: 'editSubprocess',
                      params: { uuid: subprocess.uuid },
                    })
                  "
                  class="btn btn-primary float-right mr-2"
                  >Edit</a
                >
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
