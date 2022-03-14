import { defineStore } from "pinia";
import { ref } from "vue";

export const useAuthStore = defineStore("auth", () => {
  const jwt = ref<string>("");

  const IsAuthenticated = (): boolean => {
    return localStorage.getItem("jwt") !== null;
  };

  function LogIn(token: string): void {
    localStorage.setItem("jwt", token);
  }

  function LogOut(): void {
    localStorage.removeItem("jwt");
  }

  return {
    jwt,
    isAuthenticated: IsAuthenticated,
    logIn: LogIn,
    logOut: LogOut,
  };
});
