<script setup lang="ts">
import { onBeforeMount, ref } from "vue";
import { useUserRepository } from "@/api";
import type { UserType, UserStatisticsType } from "@/api";
import AlertSuccess from "@/components/alerts/AlertSuccess.vue";

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

const validData = ref<boolean>(false);

const submitUserDataForm = async (): Promise<void> => {
  await userRepository.edit(
    user.value.username,
    user.value.firstName,
    user.value.lastName
  );

  validData.value = true;
};
</script>

<template>
  <div class="container mx-auto h-full">
    <div class="card w-1/2 min-w-min bg-base-200 shadow-xl mx-auto">
      <figure class="px-10 pt-10">
        <div class="avatar">
          <div class="w-24 mask mask-squircle">
            <img src="https://api.lorem.space/image/face?hash=47449" />
          </div>
        </div>
      </figure>
      <div class="card-body items-center text-center">
        <h2 class="card-title">{{ user.firstName }} {{ user.lastName }}</h2>
        <p>{{ user.username }}</p>
        <div class="stats shadow">
          <div class="stat place-items-center">
            <div class="stat-title">Created projects</div>
            <div class="stat-value">{{ stats.projects }}</div>
          </div>

          <div class="stat place-items-center">
            <div class="stat-title">Registered at</div>
            <div class="stat-value text-secondary">{{ stats.registered }}</div>
          </div>

          <div class="stat place-items-center">
            <div class="stat-title">Current workspaces</div>
            <div class="stat-value">{{ stats.workspaces }}</div>
          </div>
        </div>
      </div>
    </div>
    <div
      class="card w-1/2 min-w-min bg-base-200 shadow-xl mx-auto mt-8 px-10 pt-8"
    >
      <form @submit.prevent="submitUserDataForm" class="card-body min-w-max">
        <AlertSuccess
          v-if="validData"
          :text="'User data was successfully updated!'"
        />
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text"> First name </span>
          </label>
          <input
            v-model="user.firstName"
            type="text"
            placeholder="Type here"
            class="input input-bordered w-full"
            name="name"
            required
          />
        </div>
        <div class="form-control">
          <label class="label">
            <span class="label-text"> Last name </span>
          </label>
          <input
            v-model="user.lastName"
            type="text"
            placeholder="Type here"
            class="input input-bordered w-full"
            name="lastName"
            required
          />
        </div>
        <div class="form-control">
          <label class="label">
            <span class="label-text"> E-mail </span>
          </label>
          <input
            v-model="user.username"
            type="text"
            placeholder="Type here"
            class="input input-bordered w-full"
            name="lastName"
            required
          />
        </div>
        <div class="flex justify-center mt-6">
          <input
            type="submit"
            name="submit"
            value="Save"
            class="btn btn-primary"
          />
        </div>
      </form>
    </div>
  </div>
</template>
