import { useApi } from "@/api";
import type { ApiInterface } from "@/api";
import type { AxiosResponse } from "axios";

export interface UserType {
  uuid: string;
  username: string;
  firstName: string;
  lastName: string;
}

export interface UserStatisticsType {
  projects: number;
  workspaces: number;
  registered: string;
  packages: number;
  processes: number;
}

export interface UserRepositoryInterface {
  getCurrent(): Promise<UserType>;
  edit(
    email: string,
    firstName: string,
    lastName: string
  ): Promise<AxiosResponse>;
  getUserStatistics(): Promise<UserStatisticsType>;
}

export const useUserRepository = (): UserRepositoryInterface => {
  const api: ApiInterface = useApi();

  const entityPath = "/user";

  const createFormData = (
    email: string,
    firstName: string,
    lastName: string
  ): FormData => {
    const formData = new FormData();
    formData.set("email", email);
    formData.set("firstName", firstName);
    formData.set("lastName", lastName);
    return formData;
  };

  const getCurrent = async (): Promise<UserType> => {
    const response = await api.getAsync(entityPath);
    return response.data.data;
  };

  const edit = async (
    email: string,
    firstName: string,
    lastName: string
  ): Promise<AxiosResponse> => {
    const formData = createFormData(email, firstName, lastName);
    return await api.postAsync(entityPath, formData);
  };

  const getUserStatistics = async (): Promise<UserStatisticsType> => {
    const response = await api.getAsync(entityPath + "/statistics");
    return response.data.data;
  };

  return {
    getCurrent,
    edit,
    getUserStatistics,
  };
};
