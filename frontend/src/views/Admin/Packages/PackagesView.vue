<script setup lang="ts">
import { onBeforeMount, ref } from "vue";
import { useRouter } from "vue-router";
import { usePackageRepository } from "@/api";
import type { PackageType } from "@/api";
import AlertInfo from "@/components/alerts/AlertInfo.vue";

const router = useRouter();
const packageRepository = usePackageRepository();

const packages = ref<PackageType[]>();

onBeforeMount(async () => {
  packages.value = await packageRepository.getAll();
  if (packages.value === undefined) {
    packages.value = [];
  }
});
</script>

<template>
  <div class="container mx-auto h-full">
    <div class="flex justify-end w-full">
      <a
        @click="router.push({ name: 'createPackage' })"
        class="btn btn-secondary"
      >
        New package
      </a>
    </div>

    <div v-if="packages !== undefined">
      <AlertInfo
        v-if="packages.length === 0"
        :text="'No packages have been created yet. Go ahead and make one!'"
        class="mt-6"
      />

      <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 mt-6">
        <div
          v-for="processPackage in packages"
          :key="processPackage.uuid"
          class="card w-full bg-primary text-primary-content"
        >
          <div class="card-body">
            <h2 class="card-title">{{ processPackage.name }}</h2>
            <p>{{ processPackage.description }}</p>
            <div class="card-actions justify-end">
              <a
                class="btn"
                @click="
                  router.push({
                    name: 'package',
                    params: { uuid: processPackage.uuid },
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
