
<template>
    <div class="wrapper">
        <div class="modal">
            <h1>Login Page</h1>
            <div class="login-form">
               
               <form @submit.prevent="login">
                <input v-model="email" type="email" name="email">
                <input v-model="password" type="password" name="password">
                <button type="submit" name="button">Login</button>

                <p>{{ error }}</p>

                <router-link to="/register">
                    Еще нет аккаунта? Зарегистрироваться
               </router-link>

               </form>

               

                <!-- <p>Еще нет аккаунта?</p>
                <p><a href="/register" class="link">Зарегистрироваться</a></p> -->

            </div>
        </div>
    </div>
</template>

<script>
// import axios from 'axios';


export default {
    data(){
        return {
            email: '',
            password: '',
            error: null
        }
    },
    methods: {
        login() {
            this.$store.dispatch('login', {
                email: this.email,
                password: this.password
            })
            .then( () => {
                this.$router.push({ name: 'my-wish-list-folders'})
            })
            .catch(err => {
                this.error = err.response.data.error
            })
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

