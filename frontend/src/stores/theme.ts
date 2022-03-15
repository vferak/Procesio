import { defineStore } from "pinia";

interface ThemeStore {
  setTheme(): void;
  getCurrentTheme(): string;
  toggleTheme(): void;
  getCheckboxValue(): boolean;
}

export const useThemeStore = defineStore<"theme", ThemeStore>("theme", () => {
  const localStorageKey = "theme";

  const lightTheme = "light";
  const darkTheme = "dark";

  const getCurrentTheme = (): string => {
    const localTheme: string | null = localStorage.getItem(localStorageKey);
    return localTheme === null ? lightTheme : localTheme;
  };

  const toggleTheme = (): void => {
    const newTheme: string =
      getCurrentTheme() == lightTheme ? darkTheme : lightTheme;

    localStorage.setItem(localStorageKey, newTheme);

    setTheme();
  };

  const setTheme = (): void => {
    const htmlElement = document.querySelector("html");
    if (htmlElement !== null) {
      htmlElement.dataset.theme = getCurrentTheme();
    }
  };

  const getCheckboxValue = (): boolean => {
    return getCurrentTheme() != lightTheme;
  };

  return {
    setTheme,
    getCurrentTheme,
    toggleTheme,
    getCheckboxValue,
  };
});
