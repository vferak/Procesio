import type { AxiosResponse } from "axios";
import { useApi } from "@/api";
import type { PackageType, UserType, WorkspaceType } from "@/api";
import { useWorkspaceStore } from "@/stores";

export interface ProjectType {
  uuid: string;
  name: string;
  description: string;
  createdAt: string;
  createdBy: UserType;
  workspace: WorkspaceType;
  package: PackageType;
}

export interface ProjectRepositoryInterface {
  getByUuid(uuid: string): Promise<ProjectType>;
  getAll(): Promise<ProjectType[]>;
  create(
    name: string,
    description: string,
    packageUuid: string
  ): Promise<AxiosResponse>;
  edit(name: string, description: string, uuid: string): Promise<AxiosResponse>;
}

export const useProjectRepository = (): ProjectRepositoryInterface => {
  const api = useApi();
  const workspaceStore = useWorkspaceStore();

  const entityPath = "/project";

  const createFormData = (name: string, description: string) => {
    const formData = new FormData();
    formData.set("name", name);
    formData.set("description", description);
    return formData;
  };

  const getAll = async (): Promise<ProjectType[]> => {
    const response = await api.getAsync(
      entityPath + "/all/" + workspaceStore.getWorkspaceUuid()
    );

    return response.data.data;
  };

  const getByUuid = async (uuid: string): Promise<ProjectType> => {
    const response = await api.getAsync(entityPath + "/" + uuid);
    return response.data.data;
  };

  const create = async (
    name: string,
    description: string,
    packageUuid: string
  ): Promise<AxiosResponse> => {
    const formData = createFormData(name, description);
    formData.set("package_uuid", packageUuid);
    formData.set("workspace_uuid", workspaceStore.getWorkspaceUuid());

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
    getByUuid,
    getAll,
    create,
    edit,
  };
};
