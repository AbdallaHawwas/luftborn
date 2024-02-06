// store.js
import { createStore } from 'vuex';

const store = createStore({
  state() {
    return {
      user: null,
    };
  },
  mutations: {
    setUser(state, user) {
      state.user = user;

    },
    clearUser(state) {
      state.user = null;
    },
  },
  actions: {
    loginUser({ commit }, userData) {
      commit('setUser', userData);
    },
    logoutUser({ commit }) {
      commit('clearUser');
    },
  },
  getters: {
    isLoggedIn: (state) => !!state.user,
    getUsername: (state) => state.user ? state.user.name : null,
    getUserToken: (state) => state.user ? state.user.token : null,
  },
});

export default store;
