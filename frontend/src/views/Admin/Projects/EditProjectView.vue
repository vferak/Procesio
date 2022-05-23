<script setup lang="ts">
import { useRouter } from "vue-router";
import { useProjectRepository } from "@/api";
import BackButton from "@/components/buttons/BackButton.vue";
import { ref } from "vue";
import ProjectForm from "@/components/forms/Projects/ProjectForm.vue";

const router = useRouter();
const projectRepository = useProjectRepository();

const projectUuid = router.currentRoute.value.params.uuid.toString();

const invalidData = ref<boolean>(false);

const submitForm = async (name: string, description: string): Promise<void> => {
  try {
    await projectRepository.edit(name, description, projectUuid);
    await router.push({ name: "projects" });
  } catch (response) {
    invalidData.value = true;
  }
};
</script>

<template>
  <div class="container mx-auto h-full">
    <BackButton :routeName="'projects'" />
    <ProjectForm
      :invalid-data="invalidData"
      @formSubmit="submitForm"
      :project-uuid="projectUuid"
    />
  </div>
</template>
