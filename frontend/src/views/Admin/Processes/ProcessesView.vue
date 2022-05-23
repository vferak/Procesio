<script setup lang="ts">
import { onBeforeMount, ref } from "vue";
import { useRouter } from "vue-router";
import { useProcessRepository } from "@/api";
import type { ProcessType } from "@/api";
import AlertInfo from "@/components/alerts/AlertInfo.vue";

const router = useRouter();
const processRepository = useProcessRepository();

const processes = ref<ProcessType[]>();

onBeforeMount(async () => {
  processes.value = await processRepository.getAll();
});
</script>

<template>
  <div class="container mx-auto h-full">
    <div class="flex justify-end w-full">
      <a
        @click="router.push({ name: 'createProcess' })"
        class="btn btn-secondary"
      >
        New process
      </a>
    </div>

    <div v-if="processes !== undefined">
      <AlertInfo
        v-if="processes.length === 0"
        :text="'No process have been created yet. Go ahead and make one!'"
        class="mt-6"
      />

      <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 mt-6">
        <div
          v-for="process in processes"
          :key="process.uuid"
          class="card w-full bg-primary text-primary-content"
        >
          <div class="card-body">
            <h2 class="card-title">{{ process.name }}</h2>
            <p>{{ process.description }}</p>
            <div class="card-actions justify-end">
              <a
                class="btn"
                @click="
                  router.push({
                    name: 'process',
                    params: { uuid: process.uuid },
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
