<script setup lang="ts">
import { useRouter } from "vue-router";
import { useWorkspaceRepository } from "@/api";
import type { WorkspaceType, WorkspaceRepositoryInterface } from "@/api";
import BackButton from "@/components/buttons/BackButton.vue";
import { ref } from "vue";
import WorkspaceForm from "@/components/forms/Workspaces/WorkspaceForm.vue";

const router = useRouter();
const workspaceRepository: WorkspaceRepositoryInterface =
  useWorkspaceRepository();

const workspace = ref<WorkspaceType>({
  description: "",
  name: "",
  user: null,
  users: [],
  uuid: "",
});

const invalidData = ref<boolean>(false);

const submitForm = async (): Promise<void> => {
  try {
    await workspaceRepository.create(
      workspace.value.name,
      workspace.value.description
    );
    await router.push({ name: "workspaces" });
  } catch (response) {
    invalidData.value = true;
  }
};
</script>

<template>
  <div class="container mx-auto h-full">
    <BackButton :routeName="'workspaces'" />
    <WorkspaceForm
      :invalid-data="invalidData"
      v-model:name="workspace.name"
      v-model:description="workspace.description"
      @formSubmit="submitForm"
    />
  </div>
</template>
