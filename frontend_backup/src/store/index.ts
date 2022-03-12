import { createStore, useStore as baseUseStore, Store } from 'vuex'
import { InjectionKey } from 'vue'

export interface State {
  errorThrown: boolean,
  loginOpened: boolean,
  isUserAuthenticated: boolean
}

export const store = createStore<State>({
  state: {
    errorThrown: false,
    loginOpened: false,
    isUserAuthenticated: false
  },
  getters: {
    isError: (state): boolean => state.errorThrown,
    isLoginModalOpened: (state): boolean => state.loginOpened,
    isUserAuthenticated: (state): boolean => state.isUserAuthenticated
  },
  mutations: {
    resolveError (state): void {
      state.errorThrown = false
    },
    throwError (state): void {
      state.errorThrown = true
    },
    openLoginModal (state): void {
      state.loginOpened = true
    },
    closeLoginModal (state): void {
      state.loginOpened = false
    },
    login (state): void {
      state.isUserAuthenticated = true
      store.commit('closeLoginModal')
    },
    logout (state): void {
      state.isUserAuthenticated = false
    }
  },
  actions: {
    login (context) {
      context.commit('login')
    }
  },
  modules: {
  }
})

export const key: InjectionKey<Store<State>> = Symbol()

export function useStore () {
  return baseUseStore(key)
}
