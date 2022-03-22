<script setup lang="ts">
import { useRouter } from "vue-router";

const router = useRouter();

const projects = [
  {
    uuid: "asdasdas",
    name: "VŠB website",
    createdAt: "02. 02. 2022",
  },
  {
    uuid: "asdasdas",
    name: "VŠB website",
    createdAt: "02. 02. 2022",
  },
  {
    uuid: "asdasdas",
    name: "VŠB website",
    createdAt: "02. 02. 2022",
  },
  {
    uuid: "asdasdas",
    name: "VŠB website",
    createdAt: "02. 02. 2022",
  },
  {
    uuid: "asdasdas",
    name: "VŠB website",
    createdAt: "02. 02. 2022",
  },
];
</script>

<template>
  <div class="container mx-auto h-full">
    <div class="flex justify-end w-full">
      <a @click="router.push({ name: 'createProject' })" class="btn btn-primary"
        >New project</a
      >
    </div>
    <table class="table table-zebra w-full mt-6">
      <!-- head -->
      <thead>
        <tr>
          <th>Name</th>
          <th>Created at</th>
          <th class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="project in projects" :key="project.uuid" class="hover">
          <td>{{ project.name }}</td>
          <td>{{ project.createdAt }}</td>
          <td><div class="btn btn-success">Action</div></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
