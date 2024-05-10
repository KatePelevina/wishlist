<template>
    <h1>Register</h1>
    <form @submit.prevent="Register">
        <input type="email" placeholder="Email" v-model="email">
        <input type="password" placeholder="Password" v-model="password">
        <input type="submit" value="Register">
        <p>Have an acount? <router-link to="/login">Login</router-link></p>
    </form>
</template>

<script>
import { ref } from 'vue';
import firebase from 'firebase';

export default {
    setup() {
        const email = ref("");
        const password = ref("");

        const Register = () => {
            firebase
            .auth()
            .createUserWithEmailAndPassword(email.value, password.value)
            .then(user => {
                alert(user);
            })
            .catch(err => alert(err.message));
        }

        return {
            Register,
            email,
            password
        }
    }
}

</script>

<!-- <template>
    <div>
        <h1>Sign Up</h1>
        <input type="email" placeholder="Email" v-model="email">
        <input type="password" placeholder="Password" v-model="password">
        <button @click="signup">Sign Up</button>
        <p>Уже есть аккаунт? <router-link to="/login">Войти</router-link></p>

    </div>
</template> -->

<!-- <script>
import firebase from 'firebase';

export default {
    name: 'SignUpFirebase',
    data() {
        return {
            email: "",
            password: "",
            initials: ""
        }
    },
    methods: {
        signup() {
            firebase.auth().createUserWithEmailAndPassword(this.email, this.password).then(
                (user) => {
                    console.log(user)
                },
                (err) => {
                    console.log(err)
                }
            )
        }
    }
}

</script> -->

