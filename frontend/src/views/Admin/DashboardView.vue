<script setup lang="ts">
import { onBeforeMount, ref } from "vue";
import AlertBasic from "@/components/alerts/AlertBasic.vue";
import { useRouter } from "vue-router";
import { useUserRepository } from "@/api";
import type { UserStatisticsType, UserType } from "@/api";

const router = useRouter();

const userRepository = useUserRepository();

const user = ref<UserType>({
  uuid: "",
  username: "",
  firstName: "",
  lastName: "",
});

const stats = ref<UserStatisticsType>({
  projects: 0,
  workspaces: 0,
  registered: "0",
  packages: 0,
  processes: 0,
});

onBeforeMount(async () => {
  user.value = await userRepository.getCurrent();
  stats.value = await userRepository.getUserStatistics();
});

const getDate = (): string => {
  return new Date().toLocaleDateString("en-US", {
    month: "long",
    day: "numeric",
    year: "numeric",
    weekday: "long",
  });
};

const getTime = (): string => {
  return new Date().toLocaleTimeString("en-US");
};

const date = ref<string>(getDate());
const time = ref<string>(getTime());

setInterval(() => {
  date.value = getDate();
  time.value = getTime();
}, 500);
</script>
<template>
  <div v-if="stats.workspaces !== 0" class="container mx-auto h-full">
    <AlertBasic
      :text="
        'Welcome back ' +
        user.firstName +
        ', today is ' +
        date +
        ', and it\'s ' +
        time +
        '.'
      "
      class="mb-6"
    />

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
      <div class="card card-side bg-base-200 shadow-xl">
        <figure>
          <i
            class="fas fa-bookmark text-9xl px-10 grid place-items-center h-full bg-primary"
          ></i>
        </figure>
        <div class="card-body">
          <h2 class="card-title text-4xl 2xl:text-5xl mb-4 text-primary">
            Projects
          </h2>
          <div class="stats shadow mb-4">
            <div class="stat">
              <div class="stat-title">Total projects</div>
              <div class="stat-value">{{ stats.projects }}</div>
            </div>
          </div>
          <div class="card-actions justify-end">
            <button
              class="btn btn-primary"
              @click="router.push({ name: 'projects' })"
            >
              Show
            </button>
          </div>
        </div>
      </div>

      <div class="card card-side bg-base-200 shadow-xl">
        <figure>
          <i
            class="fas fa-users text-8xl px-7 grid place-items-center h-full bg-primary"
          ></i>
        </figure>
        <div class="card-body">
          <h2 class="card-title text-4xl 2xl:text-5xl mb-4 text-primary">
            Workspaces
          </h2>
          <div class="stats shadow mb-4">
            <div class="stat">
              <div class="stat-title">Total workspaces</div>
              <div class="stat-value">{{ stats.workspaces }}</div>
            </div>
          </div>
          <div class="card-actions justify-end">
            <button
              class="btn btn-primary"
              @click="router.push({ name: 'workspaces' })"
            >
              Show
            </button>
          </div>
        </div>
      </div>

      <div class="card card-side bg-base-200 shadow-xl">
        <figure>
          <i
            class="fas fa-cubes text-9xl px-6 grid place-items-center h-full bg-primary"
          ></i>
        </figure>
        <div class="card-body">
          <h2 class="card-title text-4xl 2xl:text-5xl mb-4 text-primary">
            Packages
          </h2>
          <div class="stats shadow mb-4">
            <div class="stat">
              <div class="stat-title">Total packages</div>
              <div class="stat-value">{{ stats.packages }}</div>
            </div>
          </div>
          <div class="card-actions justify-end">
            <button
              class="btn btn-primary"
              @click="router.push({ name: 'packages' })"
            >
              Show
            </button>
          </div>
        </div>
      </div>

      <div class="card card-side bg-base-200 shadow-xl">
        <figure>
          <i
            class="fas fa-cube text-9xl px-6 grid place-items-center h-full bg-primary"
          ></i>
        </figure>
        <div class="card-body">
          <h2 class="card-title text-4xl 2xl:text-5xl mb-4 text-primary">
            Processes
          </h2>
          <div class="stats shadow mb-4">
            <div class="stat">
              <div class="stat-title">Total processes</div>
              <div class="stat-value">{{ stats.processes }}</div>
            </div>
          </div>
          <div class="card-actions justify-end">
            <button
              class="btn btn-primary"
              @click="router.push({ name: 'processes' })"
            >
              Show
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
