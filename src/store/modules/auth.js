import {jwtDecrypt, tokenAlive} from '../../shared/jwtHelper';
import axios from 'axios';

const state = () => ({
    authData: {
        token: '',
        refresh_token: '',
        // nickname: '',
        username: '',
        userid: '',
        exp: ''
    },
    loginApiStatus: ''
});

const getters = {
    getLoginApiStatus(state) {
        return state.loginApiStatus;
    },
    getAuthData(state) {
        return state.authData;
    },
    isTokenAlive(state) {
        if(!state.authData.exp) {
            return false;
        }
        return tokenAlive(state.authData.exp);
    }
};

const actions = {
    async login({commit}, payload){
        console.log(payload);
        const newPayload = {
            username: payload.username,
            password: payload.password
        }
        let response = await axios.post("http://localhost:3000/auth/login", newPayload )
        .catch(err => {
            console.log(err)
        })
        if(response && response.data) {
            commit('setAuthData', response.data);
            commit('setLoginApiStatus', 'success');
        } else {
            commit('setLoginApiStatus', 'failured');
        }
    }
};

const mutations = {
    setAuthData(state, data) {
        const decryptedAuth = jwtDecrypt(data.access_token);
        console.log(decryptedAuth);

        localStorage.setItem('access_token', data.access_token);
        localStorage.setItem('refresh_token', data.refresh_token);

        const newAuthData = {
            token: data.access_token,
            refresh_token: data.refresh_token,
            // nickname: decryptedAuth.nickname,
            username: decryptedAuth.username,
            userid: decryptedAuth.sub,
            exp: decryptedAuth.exp
        };
        state.authData = newAuthData;
    },
    setLoginApiStatus(state,data) {
        state.loginApiStatus = data;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
}
