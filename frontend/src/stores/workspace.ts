import { acceptHMRUpdate, defineStore } from "pinia";

export interface WorkspaceStore {
  getWorkspace(): string | null;
}

export const useWorkspaceStore = defineStore<"workspace", WorkspaceStore>(
  "workspace",
  () => {
    const getWorkspace = (): string | null => {
      return localStorage.getItem("workspace");
    };

    return {
      getWorkspace,
    };
  }
);

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useWorkspaceStore, import.meta.hot));
}
