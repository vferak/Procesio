import { useApi } from "@/api";
import type { UserType } from "@/api";
import type { AxiosResponse } from "axios";
import { useWorkspaceStore } from "@/stores";
import type { WorkspaceStoreInterface } from "@/stores";

export interface WorkspaceType {
  uuid: string;
  name: string;
  description: string;
  user: UserType | null;
  users: UserType[];
}

export interface WorkspaceRepositoryInterface {
  getByUuid(uuid: string): Promise<WorkspaceType>;
  getAll(): Promise<WorkspaceType[]>;
  create(name: string, description: string): Promise<AxiosResponse>;
  edit(name: string, description: string, uuid: string): Promise<AxiosResponse>;
  listUsersNotInWorkspace(uuid: string): Promise<UserType[]>;
  addUserToWorkspace(uuid: string, userUuid: string): Promise<AxiosResponse>;
  removeUserFromWorkspace(
    uuid: string,
    userUuid: string
  ): Promise<AxiosResponse>;
  deleteWorkspace(uuid: string): Promise<AxiosResponse>;
  getDefaultWorkspaceForUserUuid(): Promise<WorkspaceType>;
}

export const useWorkspaceRepository = (): WorkspaceRepositoryInterface => {
  const api = useApi();
  const workspaceStore: WorkspaceStoreInterface = useWorkspaceStore();

  const entityPath = "/workspace";

  const createFormData = (name: string, description: string) => {
    const formData = new FormData();
    formData.set("name", name);
    formData.set("description", description);
    return formData;
  };

  const getAll = async (): Promise<WorkspaceType[]> => {
    const response = await api.getAsync(
      entityPath + "/all/" + workspaceStore.getWorkspaceUuid()
    );

    return response.data.data;
  };

  const getByUuid = async (uuid: string): Promise<WorkspaceType> => {
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

  const listUsersNotInWorkspace = async (uuid: string): Promise<UserType[]> => {
    const response = await api.getAsync(entityPath + "/notInWorkspace/" + uuid);
    return response.data.data;
  };

  const addUserToWorkspace = async (
    uuid: string,
    userUuid: string
  ): Promise<AxiosResponse> => {
    const formData = new FormData();
    formData.set("workspace_uuid", uuid);
    formData.set("user_uuid", userUuid);
    return await api.postAsync(entityPath + "/addUserToWorkspace", formData);
  };

  const removeUserFromWorkspace = async (
    uuid: string,
    userUuid: string
  ): Promise<AxiosResponse> => {
    const formData = new FormData();
    formData.set("workspace_uuid", uuid);
    formData.set("user_uuid", userUuid);
    return await api.postAsync(
      entityPath + "/removeUserFromWorkspace",
      formData
    );
  };

  const deleteWorkspace = async (uuid: string): Promise<AxiosResponse> => {
    const response = await api.deleteAsync(entityPath + "/" + uuid);
    return response.data.data;
  };

  const getDefaultWorkspaceForUserUuid = async (): Promise<WorkspaceType> => {
    const response = await api.getAsync(entityPath + "/defaultUserWorkspace");
    return response.data.data;
  };

  return {
    getByUuid,
    getAll,
    create,
    edit,
    listUsersNotInWorkspace,
    addUserToWorkspace,
    removeUserFromWorkspace,
    deleteWorkspace,
    getDefaultWorkspaceForUserUuid,
  };
};
