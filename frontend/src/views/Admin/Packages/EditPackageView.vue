<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";
import { usePackageRepository } from "@/api";
import PackageForm from "@/components/forms/Packages/PackageForm.vue";
import BackButton from "@/components/buttons/BackButton.vue";

const router = useRouter();
const packageRepository = usePackageRepository();

const packageUuid = router.currentRoute.value.params.uuid.toString();

const invalidData = ref<boolean>(false);

const submitForm = async (name: string, description: string): Promise<void> => {
  try {
    await packageRepository.edit(name, description, packageUuid);
    await router.push({ name: "packages" });
  } catch (response) {
    invalidData.value = true;
  }
};
</script>

<template>
  <div class="container mx-auto h-full">
    <BackButton :routeName="'packages'" />
    <PackageForm :invalid-data="invalidData" :package-uuid="packageUuid" @formSubmit="submitForm" />
  </div>
</template>
