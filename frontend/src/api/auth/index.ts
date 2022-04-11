import { useApi } from "@/api";
import type { ApiInterface } from "@/api";
import type { ResponseType } from "@/api";

export interface AuthRepositoryInterface {
  authenticate(email: string, password: string): Promise<ResponseType>;
  register(
    email: string,
    firstName: string,
    lastName: string,
    password: string
  ): Promise<ResponseType>;
}

export const useAuthRepository = (): AuthRepositoryInterface => {
  const api: ApiInterface = useApi();

  const authenticate = (
    email: string,
    password: string
  ): Promise<ResponseType> => {
    const formData = new FormData();
    formData.set("email", email);
    formData.set("password", password);

    return api.post("/login", formData);
  };

  const register = (
    email: string,
    firstName: string,
    lastName: string,
    password: string
  ): Promise<ResponseType> => {
    const formData = new FormData();
    formData.set("email", email);
    formData.set("firstName", firstName);
    formData.set("lastName", lastName);
    formData.set("password", password);

    return api.post("/register", formData);
  };

  return {
    authenticate,
    register,
  };
};
