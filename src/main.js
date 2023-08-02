import { createApp } from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './vuex/store'




import VIntersection from "@/directives/VIntersection";




const app = createApp(App);


 
app.directive('intersection', VIntersection)



app
    .use(store)
    .use(router)
    //     created() {
    //         const userString = localStorage.getItem('user')

    //         if (userString) {
    //             const userData = JSON.parse(userString)
    //             this.$store.commit('SET_USER_DATA', userData)
    //         }
    //     }

    .mount('#app')

