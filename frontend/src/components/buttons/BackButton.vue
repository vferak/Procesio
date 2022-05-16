<script setup lang="ts">
import { useRouter } from "vue-router";
import type { RouteParamsRaw } from "vue-router";

const router = useRouter();

const props = defineProps<{
  routeName: string;
  params?: RouteParamsRaw | undefined;
}>();
</script>

<template>
  <div class="flex justify-between w-full">
    <a
      @click="
        router.push({
          name: props.routeName,
          params: props.params,
        })
      "
      class="btn btn-outline"
    >
      Back
    </a>
  </div>
</template>
