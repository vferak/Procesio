import { useAuthStore } from "@/stores";
import type { AuthStoreInterface } from "@/stores";

export * from "./auth/index";
export * from "./package/package";

import Axios from "axios";
import type { AxiosResponse, AxiosInstance } from "axios";

const axios: AxiosInstance = Axios.create({
  baseURL: "http://localhost:8081/v1",
});

axios.interceptors.request.use(
  (config) => {
    const authStore: AuthStoreInterface = useAuthStore();
    const jwt = authStore.getJwt();
    if (jwt !== "") {
      // eslint-disable-next-line @typescript-eslint/ban-ts-comment
      // @ts-ignore
      config.headers.Authorization = "Bearer " + jwt;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

axios.interceptors.response.use(
  (response) => {
    console.log(response);
    return response;
  },
  (error) => {
    // if (error.response.statusCode >= 500) {
    //   console.log(error.response.data);
    //   console.log(error.response.headers);
    //
    //   // store.commit("throwError");
    // }
    return Promise.reject(error);
  }
);

export type ResponseType = {
  statusCode: number;
  data: any;
};

export interface ApiInterface {
  get(url: string): Promise<ResponseType>;
  post(url: string, formData: FormData): Promise<ResponseType>;
  getAsync(url: string): Promise<AxiosResponse>;
  postAsync(url: string, formData: FormData): Promise<AxiosResponse>;
}

export const useApi = (): ApiInterface => {
  const get = (url: string): Promise<ResponseType> => {
    return axios.get(url);
  };

  const post = (url: string, formData: FormData): Promise<ResponseType> => {
    return axios.post(url, formData);
  };

  const getAsync = async (url: string): Promise<AxiosResponse> => {
    return await axios.get(url);
  };

  const postAsync = async (
    url: string,
    formData: FormData
  ): Promise<AxiosResponse> => {
    return await axios.post(url, formData);
  };

  return {
    get,
    post,
    getAsync,
    postAsync,
  };
};
