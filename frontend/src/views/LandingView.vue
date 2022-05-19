<script setup lang="ts">
import RegisterModal from "@/components/modals/RegisterModal.vue";
import LogInModal from "@/components/modals/LogInModal.vue";
</script>

<template>
  <div
    class="h-screen pb-14 bg-right bg-cover"
    style="background-image: url('../../public/img/bg.svg')"
  >
    <!--Nav-->
    <div class="w-full container mx-auto p-6">
      <div class="w-full flex items-center justify-between">
        <a
          class="flex items-center text-indigo-900 no-underline hover:no-underline font-bold text-2xl lg:text-4xl"
          href="#"
        >
          <img
            src="public/img/logo.png"
            class="h-8 fill-current pr-2"
            alt="Procesio logo"
          />
          <span class="pt-1">Procesio</span>
        </a>

        <div class="flex w-1/2 justify-end content-center">
          <LogInModal />
        </div>
      </div>
    </div>

    <!--Main-->
    <div
      class="container pt-24 md:pt-48 px-6 mx-auto flex flex-wrap flex-col md:flex-row items-center"
    >
      <!--Left Col-->
      <div
        class="flex flex-col w-full xl:w-2/5 justify-center lg:items-start overflow-y-hidden"
      >
        <h1
          class="my-4 mt-0 text-3xl md:text-5xl text-purple-800 font-bold leading-tight text-center md:text-left slide-in-bottom-h1"
        >
          The business process management tool
        </h1>
        <p
          class="leading-normal text-base md:text-2xl mb-8 text-center md:text-left slide-in-bottom-subtitle"
        >
          Easily create, edit and upgrade your current processes with Procesio!
        </p>
        <div
          class="flex w-full justify-center md:justify-start pb-24 lg:pb-0 fade-in"
        >
          <RegisterModal />
        </div>
      </div>

      <!--Right Col-->
      <div class="w-full xl:w-3/5 py-6 overflow-y-hidden">
        <img
          class="w-5/6 mx-auto lg:mr-0 slide-in-bottom"
          src="../../public/img/devices.svg"
        />
      </div>
    </div>
  </div>
</template>
