<template>
     <msg-component
        :errorMsg="this.errorMsg"
        :successMsg="this.successMsg"
    />

    <div class="wrapper">
        <div class="modal">
            <h1>Reg Page</h1>
            <div class="login-form">
                <form @submit.prevent="register">
                    <input type="text" placeholder="username" v-model="nickname">
                    <input type="text" placeholder="email" v-model="email">
                    <input type="password" placeholder="Password" v-model="password">
                    <button class="button" type="submit">Создать аккаунт</button>

                    <ul>
                        <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                    </ul>

                    <router-link to="/login">
                        Уже есть аккаунт? Войти
                    </router-link>
                </form>
                <!-- <div>
                    <p>Уже есть аккаунт?</p>
                    <p>
                        <a href="/login" class="link">Войти</a>
                    </p>
                </div> -->
                <div>
                    <p>Google</p>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
// import axios from 'axios';
import MsgComponent from '@/components/layout/MsgComponent.vue'
// import router from "@/router"; 

export default {
    data(){
        return {
            errorMsg: "",
            successMsg: "",
            // newUser: {
            //     nickname: '',
            //     email: '',
            //     password: '',
            // }
            nickname: '',
            email: '',
            password: '',
            errors: null
        }
    },
    components: {
        MsgComponent
    },
    methods: {
        // reg() {
        //     axios.post("http://localhost:8085/public/process.php?action=create-user", {
        //         nickName: this.nickName,
        //         password: this.password
        //     })
        //     .then((response)=>{
        //         console.log(response);
        //         this.$router.push('/add-wish-list');
        //     })
        //     .catch((error) => {
        //       console.log(error)
        //     })
        // },
        /*
        async addUser(){
            let formData = this.toFormData(this.newUser);

            await axios.post("http://localhost:8085/public/process.php?action=add-user", formData)
            .then((response)=>{
                this.newUser = {nickname: "", email: "", password: "" };
                
                

                if (response.data.error){
                    this.errorMsg = response.data.message;
                } else {
                    this.successMsg = response.data.message; 
                    // this.$router.push('/');   
                    // this.$router.push({name: '/stop-list'});            
                }
            });
        },
        */
        // toFormData(obj){
        //     let fd = new FormData();
        //     for(let i in obj){
        //         fd.append(i,obj[i]);
        //     }
        //     return fd;
        // },
        register() {
            console.log('RegisterUser.register')
            this.$store.dispatch('register', {
                nickname: this.nickname,
                email: this.email,
                password: this.password,
            })
            .then( () => {
                // this.$router.push({ name: 'my-wish-list-folders'})
            })
            .catch(err => {
                this.errors = err.response.data.errors
            })
        },
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

.login-form {
    background-color: #fff;
    padding: 15px;
    display: inline-block;
    width: 20vw;
    margin: 0 auto;
    border-radius: 8px;
    
}
input {
    display: block;
    width: 100%;
    margin: 0 auto;
    margin-bottom: 20px;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
}
button {
    width: 100%;
    padding: 10px 0;
    border-radius: 8px;
    border: none;
}
.modal {
    width: 50vw;
    margin: 0 auto;
    text-align: center;
}
.link {
    color: #6069E0;
}
.button {
    background-color: #6069E0;
    color: #fff;
    border-radius: 10px;
    padding: 15px;
    width: 100%;
    display: block;
    text-align: center;
    margin-bottom: 20px;
    border: none;
}
</style>