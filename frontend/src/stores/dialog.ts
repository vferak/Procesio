import { defineStore } from "pinia";
import { ref } from "vue";

export const useDialogStore = defineStore("dialog", () => {
  const open = ref<boolean>(false);

  const OpenDialog = (): void => {
    open.value = true;
  };

  const CloseDialog = (): void => {
    open.value = false;
  };

  return {
    isOpen: open,
    openDialog: OpenDialog,
    closeDialog: CloseDialog,
  };
});
