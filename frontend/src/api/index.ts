export * from "./package/package";

import Axios from "axios";
import type { AxiosInstance } from "axios";

const headers = {};

const axios: AxiosInstance = Axios.create({
  baseURL: "http://localhost:8081/v1",
  headers: headers,
});

// axios.interceptors.response.use(
//   (response) => response,
//   (error) => {
//     if (error.response.statusCode >= 500) {
//       console.log(error.response.data);
//       console.log(error.response.headers);
//
//       // store.commit("throwError");
//     }
//     return Promise.reject(error);
//   }
// );

export type ResponseType = {
  statusCode: number;
  data: any;
};

export interface ApiInterface {
  get(url: string): Promise<ResponseType>;
  post(url: string, formData: FormData): Promise<ResponseType>;
}

export const useApi = (): ApiInterface => {
  const get = (url: string): Promise<ResponseType> => {
    return axios.get(url);
  };

  const post = (url: string, formData: FormData): Promise<ResponseType> => {
    return axios.post(url, formData);
  };

  return {
    get,
    post,
  };
};
