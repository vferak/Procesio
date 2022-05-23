import type { AxiosResponse } from "axios";
import { useApi } from "@/api";
import type { PackageType, SubprocessType } from "@/api";

export interface ProcessType {
  uuid: string;
  name: string;
  description: string;
  packages: PackageType[];
  comesFrom: ProcessType | null;
  subprocesses: SubprocessType[];
}

export interface ProcessRepositoryInterface {
  getByUuid(uuid: string): Promise<ProcessType>;
  getAll(): Promise<ProcessType[]>;
  create(name: string, description: string): Promise<AxiosResponse>;
  edit(name: string, description: string, uuid: string): Promise<AxiosResponse>;
}

export const useProcessRepository = (): ProcessRepositoryInterface => {
  const api = useApi();

  const entityPath = "/process";

  const createFormData = (name: string, description: string) => {
    const formData = new FormData();
    formData.set("name", name);
    formData.set("description", description);
    return formData;
  };

  const getAll = async (): Promise<ProcessType[]> => {
    const response = await api.getAsync(entityPath + "/all");

    return response.data.data;
  };

  const getByUuid = async (uuid: string): Promise<ProcessType> => {
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
    getByUuid,
    getAll,
    create,
    edit,
  };
};
