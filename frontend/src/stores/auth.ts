import { acceptHMRUpdate, defineStore } from "pinia";
import { ref } from "vue";

export interface AuthStoreInterface {
  getJwt(): string;
  isAuthenticated(): boolean;
  logIn(token: string): void;
  logOut(): void;
  loadJwtFromStorage(): void;
}

export const useAuthStore = defineStore<"auth", AuthStoreInterface>(
  "auth",
  () => {
    const jwt = ref<string>("");

    const getJwt = (): string => {
      return jwt.value;
    };

    const isAuthenticated = (): boolean => {
      return localStorage.getItem("jwt") !== null;
    };

    function logIn(token: string): void {
      localStorage.setItem("jwt", token);
      jwt.value = token;
    }

    function logOut(): void {
      localStorage.removeItem("jwt");
      jwt.value = "";
    }

    const loadJwtFromStorage = (): void => {
      const _jwt = localStorage.getItem("jwt");
      if (_jwt !== null) {
        jwt.value = _jwt;
      }
    };

    return {
      getJwt,
      isAuthenticated,
      logIn,
      logOut,
      loadJwtFromStorage,
    };
  }
);

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useAuthStore, import.meta.hot));
}
