import { createApp } from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store'

// import directives from "@/directives";
import VIntersection from "@/directives/VIntersection";

// import * as appRouter from '../appRouter';


const app = createApp(App);
 
app.directive('intersection', VIntersection)

app
    .use(store)
    .use(router)
    // .use(appRouter)
    .mount('#app')

// createApp(App).use(store).use(router).mount('#app')