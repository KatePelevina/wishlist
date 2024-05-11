<template>
    <div class="wrapper">
        <div class="modal">
            <div class="modal-inner">
                <h1 class="form-title">Регистрация</h1>
                <form @submit.prevent="Register">
                    <input type="email" placeholder="Email" v-model="email" class="form-input">

                    <!-- <label for="email">Email</label>
                    <n-input placeholder="Email" v-model="email" name="email"></n-input> -->


                    <input type="password" placeholder="Password" v-model="password" class="form-input">

                    <!-- <label for="password">Password</label>
                    <n-input placeholder="Password" v-model="password" name="password" type="password"></n-input> -->


                    <!-- <input type="submit" value="Register"> -->
                    <input type="submit" value="Создать аккаунт" class="sign-up-button" @click="$router.push(`/my-wish-list-folders`)">

                    <!-- <n-button strong secondary type="success" attr-type="submit">Создать аккаунт</n-button> -->

                    <p class="form-text">Уже есть аккаунт? <router-link to="/login">Войти</router-link></p>
                </form>
            </div>
        </div>
    </div>
</template>

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

<style lang="scss" scoped>
@import "@/styles/_variables.scss";

.modal {
    width: 40%;
    margin: auto;
    background-color: $white;
    padding: 50px;
}
.form-title {
    text-align: center;
    margin-bottom: 20px;
}
.n-input {
    margin-bottom: 20px;
}
.n-button {
    margin-bottom: 20px;
    width: 100%;
}
.form-text {
    text-align: center;
}
.form-text :hover {
    color: $active;
}
.sign-up-button {
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