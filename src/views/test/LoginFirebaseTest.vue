<template>
    <h1>Login</h1>
    <form @submit.prevent="Login">
        <input type="email" placeholder="Email" v-model="email">
        <input type="password" placeholder="Password" v-model="password">
        <input type="submit" value="Login">
        <p>Need an acount? <router-link to="/signup">Register</router-link></p>
    </form>
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

export default {
    setup() {
        const email = ref("");
        const password = ref("");

        const Login = () => {
            firebase
            .auth()
            .signInWithEmailAndPassword(email.value, password.value)
            .then(data => console.log(data))
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



<style>
</style>