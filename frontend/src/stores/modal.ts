import { acceptHMRUpdate, defineStore } from "pinia";
import { ref } from "vue";

export interface ModalStore {
  openModal(): void;
  closeModal(): void;
}

export const useModalStore = defineStore("modal", (): ModalStore => {
  const open = ref<boolean>(false);

  const openModal = (): void => {
    open.value = true;
  };

  const closeModal = (): void => {
    open.value = false;
  };

  return {
    openModal,
    closeModal,
  };
});

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useModalStore, import.meta.hot));
}
