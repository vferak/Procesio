import { defineStore } from "pinia";
import { ref } from "vue";

export const useAuthStore = defineStore("auth", () => {
  const jwt = ref<string>("");

  const IsAuthenticated = (): boolean => {
    return jwt.value == "";
  };

  function LogIn(token: string): void {
    localStorage.setItem("jwt", token);
  }

  return {
    jwt,
    isAuthenticated: IsAuthenticated,
    logIn: LogIn,
  };
});
