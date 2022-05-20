<script setup lang="ts">
import { useRouter } from "vue-router";
import { useProjectRepository } from "@/api";
import type { ProjectType, ProjectRepositoryInterface } from "@/api";
import BackButton from "@/components/buttons/BackButton.vue";
import { onBeforeMount, ref } from "vue";
import AlertInfo from "@/components/alerts/AlertInfo.vue";
import ProjectForm from "@/components/forms/Projects/ProjectForm.vue";

const router = useRouter();
const projectRepository: ProjectRepositoryInterface = useProjectRepository();

const projectUuid = router.currentRoute.value.params.uuid.toString();

const project = ref<ProjectType>();

onBeforeMount(async (): Promise<void> => {
  project.value = await projectRepository.getByUuid(projectUuid);
});

const invalidData = ref<boolean>(false);
const dataSaved = ref<boolean>(false);

const submitForm = async (): Promise<void> => {
  if (project.value === undefined) {
    return;
  }

  try {
    await projectRepository.edit(
      project.value.name,
      project.value.description,
      projectUuid
    );

    dataSaved.value = true;

    setTimeout(() => {
      dataSaved.value = false;
    }, 3000);
  } catch (response) {
    invalidData.value = true;
  }
};
</script>

<template>
  <div v-if="project !== undefined" class="container mx-auto h-full">
    <BackButton :routeName="'projects'" />
    <div class="grid lg:grid-cols-6 md:grid-cols-2 gap-4 mt-6">
      <div class="col-span-2">
        <div class="card w-full bg-primary text-primary-content">
          <div class="card-body">
            <h2 class="card-title">{{ project.name }}</h2>
            <p>{{ project.description }}</p>
          </div>
        </div>
        <ProjectForm
          v-model:name="project.name"
          v-model:description="project.description"
          v-model:invalid-data="invalidData"
          v-model:data-saved="dataSaved"
          @formSubmit="submitForm"
        />
      </div>
      <div class="col-span-4">
        <div class="flex justify-between w-full mb-6">
          <h3 class="text-2xl font-bold pt-2">
            Processes of {{ project.name }} package
          </h3>
          <a
            @click="
              router.push({
                name: '',
                params: { uuid: projectUuid },
              })
            "
            class="btn btn-secondary"
          >
            Update package
          </a>
        </div>
        <AlertInfo
          v-if="project.subprocesses.length === 0"
          :text="'No processes have been added yet. Go ahead and add one!'"
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
              v-for="process in project.processes"
              :key="process.uuid"
              class="hover"
            >
              <th class="text-center">{{ process.priority }}</th>
              <td>{{ process.name }}</td>
              <td>
                <a
                  @click="
                    router.push({
                      name: 'editProcess',
                      params: { uuid: process.uuid },
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
