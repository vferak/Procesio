import { acceptHMRUpdate, defineStore } from "pinia";
import type { WorkspaceType } from "@/api";
import { useWorkspaceRepository } from "@/api";

export interface WorkspaceStoreInterface {
  getWorkspaceUuid(): string;
  getWorkspace(): Promise<WorkspaceType>;
  setWorkspace(workspace: WorkspaceType): void;
}

export const useWorkspaceStore = defineStore<
  "workspace",
  WorkspaceStoreInterface
>("workspace", () => {
  const workspaceRepository = useWorkspaceRepository();

  let _workspace: WorkspaceType | null;

  const getWorkspaceUuid = (): string => {
    const workspaceUuid = localStorage.getItem("workspace");
    if (workspaceUuid == null) {
      throw new Error("Workspace has not been set!");
    }

    return workspaceUuid;
  };

  const getWorkspace = async (): Promise<WorkspaceType> => {
    if (_workspace == null) {
      return _setWorkspaceFromLocalStorage().then((workspace) => {
        _workspace = workspace;
        return _workspace;
      });
    }

    return _workspace;
  };

  const setWorkspace = (workspace: WorkspaceType): void => {
    _workspace = workspace;
    localStorage.setItem("workspace", _workspace.uuid);
  };

  const _setWorkspaceFromLocalStorage = async (): Promise<WorkspaceType> => {
    const workspaceUuid = getWorkspaceUuid();
    const workspace = await workspaceRepository.getByUuid(workspaceUuid);
    setWorkspace(workspace);

    return workspace;
  };

  return {
    getWorkspaceUuid,
    getWorkspace,
    setWorkspace,
  };
});

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useWorkspaceStore, import.meta.hot));
}
