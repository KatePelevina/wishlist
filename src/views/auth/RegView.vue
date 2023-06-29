<template>
     <msg-component
        :errorMsg="this.errorMsg"
        :successMsg="this.successMsg"
    />

    <div class="wrapper">
        <div class="modal">
            <h1>Reg Page</h1>
            <div class="login-form">
                <form action="">
                    <!-- <input 
                        type="text" 
                        name="username" 
                        id="username" 
                        v-model="username"
                        placeholder="username"
                    > -->
                    <input type="text" placeholder="username" v-model="newUser.nickname">
                    <!-- <input 
                        type="text" 
                        name="Email" 
                        id="Email" 
                        v-model="email"
                        placeholder="Email"
                    > -->
                    <!-- <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        v-model="password"
                        placeholder="Password"
                    > -->
                    <input type="password" placeholder="Password" v-model="newUser.password">
                    <!-- <input 
                        type="password" 
                        name="confirm_password" 
                        id="password" 
                        v-model="confirm_password"
                        placeholder="Password"
                    > -->
                    <button class="button" @click="addUser(); routeToDynamicPage(); clearUser(); clearMsg();">Создать аккаунт</button>
                </form>
                <div>
                    <p>Уже есть аккаунт?</p>
                    <p>
                        <a href="/login" class="link">Войти</a>
                    </p>
                </div>
                <div>
                    <p>Google</p>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import MsgComponent from '@/components/layout/MsgComponent.vue'
import router from "@/router"; 

export default {
    data(){
        return {
            errorMsg: "",
            successMsg: "",
            newUser: {
                nickname: '',
                password: '',
            }
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
        async addUser(){
            let formData = this.toFormData(this.newUser);

            await axios.post("http://localhost:8085/public/process.php?action=add-user", formData)
            .then((response)=>{
                this.newUser = {nickname: "", password: "" };
                
                

                if (response.data.error){
                    this.errorMsg = response.data.message;
                } else {
                    this.successMsg = response.data.message; 
                    // this.$router.push('/');   
                    // this.$router.push({name: '/stop-list'});            
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
        routeToDynamicPage() {
            router.push({
                name: 'home'
            })
        },
        clearMsg(){
            this.errorMsg = "";
            this.successMsg = "";
        },
        clearUser(){
            this.nickname = "";
            this.password = "";
        },
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