import { createStore } from 'vuex'
import auth from './modules/auth';
import axios from "axios";

const store = createStore({
  state: {
  },
  getters: {
  },
  mutations: {
  },
  actions: {
    register(credentials) {
      return axios.post('//localhost:3000/register', credentials)
      .then(({data}) => {
        console.log('user data is:', data)
      })
    }
  },
  modules: {
    auth
  }
});

export default store;

