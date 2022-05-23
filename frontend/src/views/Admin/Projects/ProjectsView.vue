<script setup lang="ts">
import { onBeforeMount, ref } from "vue";
import { useRouter } from "vue-router";
import { useProjectRepository } from "@/api";
import type { ProjectType } from "@/api";
import AlertInfo from "@/components/alerts/AlertInfo.vue";

const router = useRouter();
const projectRepository = useProjectRepository();

const projects = ref<ProjectType[]>();

onBeforeMount(async () => {
  projects.value = await projectRepository.getAll();
  if (projects.value === undefined) {
    projects.value = [];
  }
});
</script>

<template>
  <div class="container mx-auto h-full">
    <div class="flex justify-end w-full">
      <a
        @click="router.push({ name: 'createProject' })"
        class="btn btn-secondary"
      >
        New project
      </a>
    </div>

    <div v-if="projects !== undefined">
      <AlertInfo
        v-if="projects.length === 0"
        :text="'No projects have been created yet. Go ahead and make one!'"
        class="mt-6"
      />

      <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 mt-6">
        <div
          v-for="project in projects"
          :key="project.uuid"
          class="card w-full bg-primary text-primary-content"
        >
          <div class="card-body">
            <h2 class="card-title">{{ project.name }}</h2>
            <p>{{ project.description }}</p>
            <div class="card-actions justify-end">
              <a
                class="btn"
                @click="
                  router.push({
                    name: 'project',
                    params: { uuid: project.uuid },
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
