<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";
import { usePackageRepository } from "@/api";

const router = useRouter();
const packageRepository = usePackageRepository();

const packages = ref<object[]>();

packageRepository.get().then((response) => {
  packages.value = response.data.data;
  console.log(packages.value);
});
</script>

<template>
  <div class="container mx-auto h-full">
    <div class="flex justify-end w-full">
      <a
        @click="router.push({ name: 'createPackage' })"
        class="btn btn-primary"
      >
        New package
      </a>
    </div>
    <table class="table table-zebra w-full mt-6">
      <!-- head -->
      <thead>
        <tr>
          <th>Name</th>
          <th class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="processPackage in packages"
          :key="processPackage.uuid"
          class="hover"
        >
          <td>{{ processPackage.name }}</td>
          <td><div class="btn btn-success">Action</div></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
