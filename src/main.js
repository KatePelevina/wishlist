import { createApp } from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
// import store from './vuex/store'

import VIntersection from "@/directives/VIntersection";



import firebase from "firebase/app";

const firebaseConfig = {
  apiKey: "AIzaSyDfplDIUKitdKtl1xinO5lPDJ6Gy5-no6A",
  authDomain: "wishlist-8e38f.firebaseapp.com",
  projectId: "wishlist-8e38f",
  storageBucket: "wishlist-8e38f.appspot.com",
  messagingSenderId: "52069084721",
  appId: "1:52069084721:web:1286774a19cfcd48fb2f10"
};

firebase.initializeApp(firebaseConfig);

const app = createApp(App);

app.directive('intersection', VIntersection)

app
    // .use(store)
    .use(router)
   
    // created() {
    //     const userString = localStorage.getItem('user')

    //     if (userString) {
    //         const userData = JSON.parse(userString)
    //         this.$store.commit('SET_USER_DATA', userData)
    //     }
    // }
    .mount('#app')


    




