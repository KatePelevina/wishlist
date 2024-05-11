<template>
    <div class="wrapper">
        <div class="modal">
            <div class="modal-inner">
                <h1 class="form-title">Авторизация</h1>
                <form @submit.prevent="Login">
                    <!-- <label for="email">Email</label> -->
                    <input type="email" placeholder="Email" v-model="email" class="form-input" name="email">
<!-- 
                    <label for="email">Email</label>
                    <n-input v-model:value="email" placeholder="Email" name="email"></n-input> -->

                    <!-- <label for="password">Password</label> -->
                    <input type="password" placeholder="Password" v-model="password" class="form-input">

                    <!-- <label for="password">Password</label>
                    <n-input v-model:value="password" placeholder="Password" name="password"></n-input> -->

                    <!-- <n-button strong secondary type="success">Login</n-button> -->
                    <input type="submit" value="Войти" @click="$router.push(`/my-wish-list-folders`)" class="login-button">

                    <p class="form-text">Еще нет аккаунта? <router-link to="/signup">Создать аккаунт</router-link></p>
                </form>

            </div>
        </div>
    </div>
</template>


<!-- <template>
    <div>
        <h1>Login</h1> -->
        <!-- <form @submit.prevent="submit"> -->
            <!-- <input type="email" placeholder="Email" v-model="data.email">
            <input type="password" placeholder="Password" v-model="data.password"> -->
            <!-- <button @click="login">Login</button> -->
            <!-- <button type="sibmit">{{ mode === 'Login' ? 'Login' : 'Register'}}</button>
            <div @click="toggleMode( mode === 'login' ? 'register' : 'login')">{{ mode === 'login' ? 'Not a user? Register' : 'Already a user? Login' }}</div> -->
        <!-- </form> -->
        


        <!-- <p>Еще нет аккаунта? <router-link to="/signup">Зарегистрироваться</router-link></p> -->
    <!-- </div>
</template> -->

<script>
import { ref } from 'vue';
import firebase from 'firebase';

// import { NButton } from 'naive-ui';
// import { NInput } from 'naive-ui';

export default {
    components: {
        // NButton,
        // NInput
    },
    setup() {
        const email = ref("");
        const password = ref("");

        const Login = () => {
            firebase
            .auth()
            .signInWithEmailAndPassword(email.value, password.value)
            .then(data => console.log(data))
            
            // .then(this.$router.push('/my-wish-list-folders'))
            // .then( () => location.reload())
            .catch(err => alert(err.message));

        }

        return {
            Login,
            email,
            password
        }
    }
}


// import firebase from 'firebase';


// export default {
//     name: 'LoginFirebase',
//     data() {
//         return {
//             email: "",
//             password: "",
//             initials: ""
//         }
//     },
//     methods: {
//         login() {
//             firebase
//             .auth()
//             .signInWithEmailAndPassword(this.email, this.password)
//             .then(
//                 (user) => {
//                     console.log(user);
//                     this.$router.push('/my-wish-list-folders');
//                 },
//                 (err) => {
//                     console.log(err)
//                 }
//             )
//         }
//     }
// }

</script>



<style lang="scss" scoped>
@import "@/styles/_variables.scss";

.modal {
    width: 40%;
    margin: auto;
    background-color:#fff;
    padding: 50px;
}
.form-title {
    text-align: center;
    margin-bottom: 20px;
}
.n-input {
    margin-bottom: 20px;
}
.form-text {
    text-align: center;
}
.form-text :hover {
    color: #6069E0;
}
.login-button {
    width: 100%;
    border: none;
    padding: 10px;
    background-color: #DFF0E4;
    color: #18A058;
    cursor: pointer;
    margin-bottom: 20px;
}
.form-input {
    width: 100%;
    margin-bottom: 20px;
    padding: 10px;
}
</style>