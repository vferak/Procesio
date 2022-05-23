<script setup lang="ts">
import { onBeforeMount, ref } from "vue";
import { useRouter } from "vue-router";
import { useWorkspaceRepository } from "@/api";
import type { WorkspaceType } from "@/api";
import AlertInfo from "@/components/alerts/AlertInfo.vue";

const router = useRouter();
const workspaceRepository = useWorkspaceRepository();

const workspaces = ref<WorkspaceType[]>();

onBeforeMount(async () => {
  workspaces.value = await workspaceRepository.getAll();
});
</script>

<template>
  <div class="container mx-auto h-full">
    <div class="flex justify-end w-full">
      <a
        @click="router.push({ name: 'createWorkspace' })"
        class="btn btn-secondary"
      >
        New workspace
      </a>
    </div>

    <div v-if="workspaces !== undefined">
      <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 mt-6">
        <div
          v-for="workspace in workspaces"
          :key="workspace.uuid"
          class="card w-full bg-primary text-primary-content"
        >
          <div class="card-body">
            <h2 class="card-title">{{ workspace.name }}</h2>
            <p>{{ workspace.description }}</p>
            <div class="card-actions justify-end">
              <a
                class="btn"
                @click="
                  router.push({
                    name: 'workspace',
                    params: { uuid: workspace.uuid },
                  })
                "
                >View</a
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
