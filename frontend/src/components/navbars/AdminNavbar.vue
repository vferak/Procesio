<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { useMetaStore } from "@/stores/meta";

const metaStore = useMetaStore();
const authStore = useAuthStore();
const router = useRouter();

const rail = ref<boolean>(false);

const logout = () => {
  authStore.logOut();

  router.push({
    name: "landing",
  });
};
</script>

<template>
  <v-navigation-drawer :rail="rail" permanent @click="rail = false">
    <v-list-item
      prepend-avatar="https://randomuser.me/api/portraits/men/85.jpg"
      title="John Leider"
    >
      <template v-slot:append>
        <v-btn
          variant="text"
          icon="mdi-chevron-left"
          @click.stop="rail = !rail"
        ></v-btn>
      </template>
    </v-list-item>

    <v-divider></v-divider>

    <v-list density="compact" nav>
      <v-list-item
        prepend-icon="mdi-view-dashboard"
        title="Dashboard"
        value="dashboard"
        @click="router.push({ name: 'dashboard' })"
      ></v-list-item>
      <v-list-item
        prepend-icon="mdi-book-multiple"
        title="Projects"
        value="projects"
        @click="router.push({ name: 'projects' })"
      ></v-list-item>
    </v-list>
    <template v-slot:append>
      <v-divider></v-divider>
      <v-list density="compact">
        <v-list-item
          prepend-icon="mdi-logout"
          title="Log out"
          value="logout"
          @click="logout"
        ></v-list-item>
      </v-list>
    </template>
  </v-navigation-drawer>

  <v-app-bar>
    <v-toolbar-title>{{ metaStore.getTitle() }}</v-toolbar-title>
  </v-app-bar>
</template>
