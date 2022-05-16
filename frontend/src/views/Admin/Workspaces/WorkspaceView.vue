<script setup lang="ts">
import { useRouter } from "vue-router";
import { useWorkspaceRepository } from "@/api";
import type {
  WorkspaceType,
  WorkspaceRepositoryInterface,
  UserType,
} from "@/api";
import WorkspaceForm from "@/components/forms/Workspaces/WorkspaceForm.vue";
import BackButton from "@/components/buttons/BackButton.vue";
import { onBeforeMount, ref } from "vue";

const router = useRouter();
const workspaceRepository: WorkspaceRepositoryInterface =
  useWorkspaceRepository();

const workspaceUuid = router.currentRoute.value.params.uuid.toString();

const workspace = ref<WorkspaceType>();

onBeforeMount(async (): Promise<void> => {
  workspace.value = await workspaceRepository.getByUuid(workspaceUuid);
});

const availableUsers = ref<UserType[]>();
const loadAvailableUsers = async (): Promise<void> => {
  availableUsers.value = await workspaceRepository.listUsersNotInWorkspace(
    workspaceUuid
  );
};

const selectedUser = ref<UserType>({
  firstName: "",
  lastName: "",
  username: "",
  uuid: "default",
});
const addUserToWorkspace = async (): Promise<void> => {
  const userUuid = selectedUser.value.uuid;

  if (userUuid === "default") {
    return;
  }

  await workspaceRepository.addUserToWorkspace(workspaceUuid, userUuid);
  workspace.value = await workspaceRepository.getByUuid(workspaceUuid);

  selectedUser.value.uuid = "";
  availableUsers.value = undefined;
  setTimeout(() => {
    selectedUser.value.uuid = "default";
  }, 750);
};

const removeUserFromWorkspace = async (userUuid: string): Promise<void> => {
  await workspaceRepository.removeUserFromWorkspace(workspaceUuid, userUuid);
  workspace.value = await workspaceRepository.getByUuid(workspaceUuid);
  availableUsers.value = undefined;
};

const invalidData = ref<boolean>(false);
const dataSaved = ref<boolean>(false);

const submitForm = async (): Promise<void> => {
  if (workspace.value === undefined) {
    return;
  }

  try {
    await workspaceRepository.edit(
      workspace.value.name,
      workspace.value.description,
      workspaceUuid
    );

    dataSaved.value = true;

    setTimeout(() => {
      dataSaved.value = false;
    }, 3000);
  } catch (response) {
    invalidData.value = true;
  }
};
</script>

<template>
  <div v-if="workspace !== undefined" class="container mx-auto h-full">
    <BackButton :routeName="'workspaces'" />
    <div class="grid grid-cols-2 xl:grid-cols-6 gap-4 mt-6">
      <div class="col-span-2">
        <div class="card w-full bg-primary text-primary-content">
          <div class="card-body">
            <h2 class="card-title">{{ workspace.name }}</h2>
            <p>{{ workspace.description }}</p>
          </div>
        </div>
        <WorkspaceForm
          v-model:name="workspace.name"
          v-model:description="workspace.description"
          v-model:invalid-data="invalidData"
          v-model:data-saved="dataSaved"
          @formSubmit="submitForm"
        />
      </div>
      <div class="col-span-4">
        <div class="flex justify-between w-full mb-6">
          <h3 class="text-2xl font-bold pt-2">
            Users in workspace {{ workspace.name }}
          </h3>
          <a
            v-show="availableUsers === undefined && selectedUser.uuid === 'default'"
            @click="loadAvailableUsers()"
            class="btn btn-primary float-right mr-2"
            >Add users</a
          >
          <div
            v-if="availableUsers !== undefined"
            class="input-group float-right mr-2 w-auto"
          >
            <select
              class="select select-bordered"
              v-model="selectedUser.uuid"
            >
              <option value="default" disabled selected>Select user</option>
              <option
                v-for="user in availableUsers"
                :key="user.uuid"
                :value="user.uuid"
              >
                {{ user.firstName }} {{ user.lastName }}
              </option>
            </select>
            <button
              @click="addUserToWorkspace()"
              class="btn btn-secondary"
            >
              Add
            </button>
          </div>
          <a
            v-show="selectedUser.uuid === ''"
            class="btn btn-success float-right mr-2"
          >
            <i class="fas fa-check"></i>
          </a>
        </div>
        <table class="table table-zebra table-auto w-full">
          <thead>
            <tr>
              <th>Priority</th>
              <th>Name</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="user in workspace.users"
              :key="user.uuid"
              class="hover"
            >
              <th>{{ user.username }}</th>
              <td>{{ user.firstName }} {{ user.lastName }}</td>
              <td>
                <a
                  v-if="workspace.user === null || user.uuid !== workspace.user.uuid"
                  @click="removeUserFromWorkspace(user.uuid)"
                  class="btn btn-primary float-right"
                  >Remove</a
                >
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
