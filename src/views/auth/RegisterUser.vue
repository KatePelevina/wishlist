<template>
    <div class="msg">
        <router-link to="/my-wish-list-folders" >
            <msg-component class="link"
            :errorMsg="this.errorMsg"
            :successMsg="this.successMsg"
            />            
        </router-link>
    </div>
     

    <div class="wrapper">
        <div class="modal">
           
            <div class="login-form">
                <h1 class="form-title">Регистрация</h1>
                <form @submit.prevent="register">

                    <n-input 
                        label="Email"
                        type="email" 
                        v-model:value="newUser.email" 
                        class="email-input"
                        placeholder="Email"
                    />

                    <n-input 
                        label="Password"
                        type="password" 
                        v-model:value="newUser.password" 
                        class="password-input"
                        placeholder="Password"
                    />


                    <n-button strong secondary type="success" @click="reg()" class="form-button">Зарегистрироваться</n-button>


                    <!-- <ul>
                        <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                    </ul> -->

                    <div class="form-text">
                        <p>Уже есть аккаунт?</p>
                        <router-link to="/login" class="link">
                            Войти
                        </router-link>
                    </div>
                   
                </form>        
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import MsgComponent from '@/components/layout/MsgComponent.vue'
// import router from "@/router"; 

import { NInput } from 'naive-ui';

import { NButton } from 'naive-ui';


export default {
    data(){
        return {
            errorMsg: "",
            successMsg: "",
            newUser: {
                // nickname: '',
                email: '',
                password: '',
            },
            // users: [],        
            errors: null
        }
    },
    components: {
        MsgComponent,
        NInput,
        NButton
    },
    methods: {
        async reg(){
            let formData = this.toFormData(this.newUser);

            await axios.post("http://localhost:8085/public/process.php?action=register", formData)
            .then((response)=>{
                this.newUser = {email: "", password: ""};


                if(response.data.error){
                    this.errorMsg = response.data.message;
                } else {
                    this.successMsg = response.data.message;
                    
                    // this.$router.push('/my-wish-list-folders');
                    // this.getFolders();           
                }
            });
        },
        toFormData(obj){
            let fd = new FormData();
            for(let i in obj){
                fd.append(i,obj[i]);
            }
            return fd;
        },
        
        
        // async addUser(){
        //     let formData = this.toFormData(this.newUser);

        //     await axios.post("http://localhost:8085/public/process.php?action=add-user", formData)
        //     .then((response)=>{
        //         this.newUser = {nickname: "", email: "", password: "" };
                
                

        //         if (response.data.error){
        //             this.errorMsg = response.data.message;
        //         } else {
        //             this.successMsg = response.data.message; 
        //             // this.$router.push('/');   
        //             // this.$router.push({name: '/stop-list'});            
        //         }
        //     });
        // },
        
    
        // register() {
        //     console.log('RegisterUser.register')
        //     this.$store.dispatch('register', {
        //         nickname: this.nickname,
        //         email: this.email,
        //         password: this.password,
        //     })
        //     .then( () => {
        //         // this.$router.push({ name: 'my-wish-list-folders'})
        //     })
        //     .catch(err => {
        //         this.errors = err.response.data.errors
        //     })
        // },

        // routeToDynamicPage() {
        //     router.push({
        //         name: 'home'
        //     })
        // },
        // clearMsg(){
        //     this.errorMsg = "";
        //     this.successMsg = "";
        // },
        // clearUser(){
        //     this.nickname = "";
        //     this.email = "";
        //     this.password = "";
        // },
    }
}

</script>


<style scoped lang="scss">

@import "@/styles/_variables.scss";

.login-form {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
}
.modal {
    width: 25vw;
    margin: 0 auto;
}
.form-title {
    text-align: center;
    margin-bottom: 20px;
}
.email-input {
    margin-bottom: 20px;
}
.password-input {
    margin-bottom: 20px;
}
.form-button  {
    width: 100%;
    margin-bottom: 20px;
}
.form-text {
    text-align: center;
}
.link:hover {
    color: $active;
}
.msg {
    width: 25vw;
    margin: 0 auto; 
    margin-bottom: 20px;
}
</style>