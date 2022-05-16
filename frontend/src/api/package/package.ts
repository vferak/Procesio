import { useApi } from "@/api";
import type { ApiInterface, ProcessType, WorkspaceType } from "@/api";
import { useWorkspaceStore } from "@/stores";
import type { WorkspaceStoreInterface } from "@/stores";
import type { AxiosResponse } from "axios";

export interface PackageType {
  uuid: string;
  name: string;
  description: string;
  workspace: WorkspaceType;
  comesFrom: PackageType;
  processes: ProcessType[];
}

export interface PackageRepositoryInterface {
  getAll(): Promise<PackageType[]>;
  getByUuid(uuid: string): Promise<PackageType>;
  create(name: string, description: string): Promise<AxiosResponse>;
  edit(name: string, description: string, uuid: string): Promise<AxiosResponse>;
}

export const usePackageRepository = (): PackageRepositoryInterface => {
  const api: ApiInterface = useApi();
  const workspaceStore: WorkspaceStoreInterface = useWorkspaceStore();

  const entityPath = "/package";

  const createFormData = (name: string, description: string): FormData => {
    const formData = new FormData();
    formData.set("name", name);
    formData.set("description", description);
    formData.set("workspace", workspaceStore.getWorkspaceUuid());
    return formData;
  };

  const getAll = async (): Promise<PackageType[]> => {
    const response = await api.getAsync(
      entityPath + "/all/" + workspaceStore.getWorkspaceUuid()
    );
    return response.data.data;
  };

  const getByUuid = async (uuid: string): Promise<PackageType> => {
    const response = await api.getAsync(entityPath + "/" + uuid);
    return response.data.data;
  };

  const create = async (
    name: string,
    description: string
  ): Promise<AxiosResponse> => {
    const formData = createFormData(name, description);
    return await api.postAsync(entityPath, formData);
  };

  const edit = async (
    name: string,
    description: string,
    uuid: string
  ): Promise<AxiosResponse> => {
    const formData = createFormData(name, description);
    return await api.postAsync(entityPath + "/" + uuid, formData);
  };

  return {
    getAll,
    getByUuid,
    create,
    edit,
  };
};
