<script setup lang="ts">
import { useRouter } from "vue-router";

const router = useRouter();

const props = defineProps<{
  routeName: string;
}>();
</script>

<template>
  <div class="flex justify-between w-full">
    <a @click="router.push({ name: props.routeName })" class="btn btn-outline">
      Back
    </a>
  </div>
</template>
