import { useApi } from "@/api";
import type { ApiInterface, ResponseType } from "@/api";
import { useWorkspaceStore } from "@/stores";
import type { WorkspaceStore } from "@/stores";

export interface PackageRepositoryInterface {
  get(): Promise<ResponseType>;
  create(name: string, description: string): Promise<ResponseType>;
}

export const usePackageRepository = (): PackageRepositoryInterface => {
  const api: ApiInterface = useApi();
  const workspaceStore: WorkspaceStore = useWorkspaceStore();

  const get = (): Promise<ResponseType> => {
    return api.get("/package");
  };

  const create = (name: string, description: string): Promise<ResponseType> => {
    const formData = new FormData();
    formData.set("name", name);
    formData.set("description", description);
    formData.set("workspace", workspaceStore.getWorkspace() ?? "");

    return api.post("/package", formData);
  };

  return {
    get,
    create,
  };
};
