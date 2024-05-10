
<template>
    <div>
        <!-- <h1>Login</h1>
        <input type="email" placeholder="Email" v-model="email">
        <input type="password" placeholder="Password" v-model="password">
        <button @click="login">Login</button> -->
    </div>

    <!-- <div class="wrapper">
        <div class="modal">
            
            <div class="login-form">

                <h1 class="form-title">Авторизация</h1>
                
               <form @submit.prevent="login">

                <n-input 
                    label="Email"
                    type="email" 
                    v-model:value="email" 
                    class="email-input"
                    placeholder="Email"
                />

                <n-input 
                    label="Password"
                    type="password" 
                    v-model:value="password" 
                    class="password-input"
                    placeholder="Password"
                />
                    
                <n-button strong secondary type="success" attr-type="submit" class="form-button">Войти</n-button>
            
                <p>{{ error }}</p>

                <div class="form-text">
                    <p>Еще нет аккаунта?</p>
                    <router-link to="/register" class="link">
                        Зарегистрироваться
                    </router-link>
                </div>
               

               </form>

            </div>
        </div>
    </div> -->
</template>

<script>
// import firebase from 'firebase';


// export default {
//     name: 'LoginView',
//     data() {
//         return {
//             email: "",
//             password: "",
//             initials: "",
//         }
//     },
//     methods: {
//         login() {
//             firebase.auth()
//             .signInWithEmailAndPaswword(this.email, this.password)
//             .then(
//                 (user) => {
//                     console.log(user)
//                 },
//                 (err) => {
//                     alert(err)
//                 }
//             )
//         }
//     }
// }
// import { NButton } from 'naive-ui';
// import { NInput } from 'naive-ui';

// export default {
    // components: { 
    //     NButton,
    //     NInput,
    // },
    // data(){
    //     return {
    //         email: '',
    //         password: '',
    //         error: null
    //     }
    // },
    // methods: {
    //     login() {
    //         this.$store.dispatch('login', {
    //             email: this.email,
    //             password: this.password
    //         })
    //         .then( () => {
    //             this.$router.push({ name: 'my-wish-list-folders'})
    //         })
    //         .catch(err => {
    //             this.error = err.response.data.error
    //         })
    //     },
    // },
    // setup () {
    //     function onSubmit () {
    //         alert('Submitted')
    //     }

    //     const { value: email, errorMessage: emailError } = useField('email', function (value) {
    //     if (!value) return 'This field is required'

    //     const regex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
    //     if (!regex.test(value)) {
    //         return 'This field must be a valid email';
    //     }

    //         return true
    //     })

    //     return {
    //         onSubmit,
    //         email: email.value,
    //         emailError: email.errorMessage
    //     }
    // }
// }
</script>

<!-- <style scoped lang="scss">

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
</style> -->

