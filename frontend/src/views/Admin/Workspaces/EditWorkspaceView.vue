<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useWorkspaceRepository } from "@/api";
import WorkspaceForm from "@/components/forms/Workspaces/WorkspaceForm.vue";
import BackButton from "@/components/buttons/BackButton.vue";

const router = useRouter();
const workspaceRepository = useWorkspaceRepository();

const workspaceUuid = router.currentRoute.value.params.uuid.toString();

const invalidData = ref<boolean>(false);

const submitForm = async (name: string, description: string): Promise<void> => {
  try {
    await workspaceRepository.edit(name, description, workspaceUuid);
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
      :workspace-uuid="workspaceUuid"
      @formSubmit="submitForm"
    />
  </div>
</template>
