import { useApi } from "@/api";
import type { ProcessType } from "@/api";

export interface SubprocessType {
  uuid: string;
  name: string;
  description: string;
  process_uuid: string;
  priority: number;
}

export interface SubprocessRepositoryInterface {
  getByUuid(uuid: string): Promise<SubprocessType>;
  create(
    name: string,
    description: string,
    priority: number,
    processUuid: string
  ): Promise<ProcessType>;
  edit(
    name: string,
    description: string,
    priority: number,
    uuid: string
  ): Promise<SubprocessType>;
  remove(uuid: string): Promise<ProcessType>;
}

export const useSubprocessRepository = (): SubprocessRepositoryInterface => {
  const api = useApi();

  const entityPath = "/subprocess";

  const createFormData = (
    name: string,
    description: string,
    priority: number
  ) => {
    const formData = new FormData();
    formData.set("name", name);
    formData.set("description", description);
    formData.set("priority", priority.toString());
    return formData;
  };

  const getByUuid = async (uuid: string): Promise<SubprocessType> => {
    const response = await api.getAsync(entityPath + "/" + uuid);
    return response.data.data;
  };

  const create = async (
    name: string,
    description: string,
    priority: number,
    processUuid: string
  ): Promise<ProcessType> => {
    const formData = createFormData(name, description, priority);
    formData.set("process", processUuid);

    const response = await api.postAsync(entityPath, formData);

    return response.data.data;
  };

  const edit = async (
    name: string,
    description: string,
    priority: number,
    uuid: string
  ): Promise<SubprocessType> => {
    const formData = createFormData(name, description, priority);
    const response = await api.postAsync(entityPath + "/" + uuid, formData);
    return response.data.data;
  };

  const remove = async (uuid: string): Promise<ProcessType> => {
    const response = await api.getAsync(
      entityPath + "/removeSubprocess/" + uuid
    );
    return response.data.data;
  };

  return {
    getByUuid,
    create,
    edit,
    remove,
  };
};
