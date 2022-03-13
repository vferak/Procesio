import Axios from "axios";

const headers = {};

const axios = Axios.create({
  baseURL: "http://localhost:8081/v1",
  headers: headers,
});

axios.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response.status >= 500) {
      console.log(error.response.data);
      console.log(error.response.headers);

      // store.commit("throwError");
    }
    return Promise.reject(error);
  }
);

const Api = {
  get(url: string) {
    return axios.get(url);
  },
  post(url: string, formData: FormData) {
    return axios.post(url, formData);
  },
};

export default Api;
