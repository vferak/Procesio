import { defineStore } from "pinia";
import { ref } from "vue";

export const useMetaStore = defineStore("meta", () => {
  const titleSuffix = "Procesio";

  const title = ref<string>("");

  const GetTitle = () => title.value;

  const GetSiteTile = () =>
    title.value + (title.value === "" ? "" : " - ") + titleSuffix;

  const SetTitle = (titleValue: string) => {
    title.value = titleValue;
  };

  return {
    getTitle: GetTitle,
    getSiteTitle: GetSiteTile,
    setTitle: SetTitle,
  };
});
