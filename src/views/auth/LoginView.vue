
<template>
    <div class="wrapper">
        <div class="modal">
            <h1>Login Page</h1>
            <div class="login-form">
                <form action="">

                    <input 
                        type="text" 
                        name="username" 
                        id="username" 
                        v-model="username"
                        placeholder="Username"
                    >

                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        v-model="username"
                        placeholder="Password"
                    >

                    <button class="button" @click="login()">Login</button>
                </form>

                <p>Еще нет аккаунта?</p>
                <p><a href="/reg" class="link">Зарегистрироваться</a></p>

            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
    data(){
        return {
            username: '',
            password: ''
        }
    },
    computed: {
        ...mapGetters('auth',{
            gettersLoginApiStatus: 'getLoginApiStatus'
        })
    },
    methods: {
        ...mapActions('auth',{
            actionLogin: 'login'
        }),
        async login() {
            console.log(this.username, this.password);
            await this.actionLogin({username: this.username, password: this.password});
            if(this.gettersLoginApiStatus === 'success') {
                this.$router.push('/dashboard');
            } else {
                alert('failed to login');
            }
        }
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

