
// import Vue from 'vue'
// import Vuex from 'vuex'


import { createStore } from 'vuex'

import axios from 'axios'

// Vue.use(Vuex)


// // export default new Vuex.Store({
// //   state: {},
// //   matations: {},
// //   actions: {
// //     // register({ commit }, credentials) {
// //       register(credentials) {
// //       return axios.post('//localhost:3000/register', credentials )
// //       .then(
// //         ({ data})  => {
// //           console.log('user data is:', data)
// //         }
// //       )
// //     }
// //   }
// // })




const store = createStore({
  state: {
    user: null
  },
  getters: {
    loggedIn (state) {
      console.log('store.loggedIn', state.user, !!state.user);
      return !!state.user;
    }
  },
  mutations: {
    SET_USER_DATA(state, userData) {
      state.user = userData
      localStorage.setItem('user', JSON.stringify(userData))
      axios.defaults.headers.common['Authorization'] = `Bearer ${
        userData.token
      }`
    },
    // CLEAR_USER_DATA(state) {
    //   state.user = null
    //   localStorage.removeItem('user')
    //   axios.defaults.headers.common['Authorization'] = null
    // },
    // CLEAR_USER_DATA() {
    //   localStorage.removeItem('user')
    //   location.reload()
    // }
  },
  actions: {
    register({ commit }, credentials) {
        return axios.post('//localhost:3000/register', credentials )
        .then(
          ({ data })  => {
            console.log("store.register", data);
            commit('SET_USER_DATA', data)
          }
        )
    },
    login({ commit }, credentials) {
      return axios.post('//localhost:3000/login', credentials )
      .then(
        ({ data })  => {
          console.log("store.register", data);
          commit('SET_USER_DATA', data)
        }
      )
    },
    logout ({ commit }) {
      commit ('CLEAR_USER_DATA')
    }
  },
  modules: {

  }
});

export default store;

