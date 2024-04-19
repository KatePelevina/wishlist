
<template>
    <div class="wrapper">
        <div class="modal">
            <h1>Login Page</h1>
            <div class="login-form">
               
               <form @submit.prevent="login">

                <input 
                    label="Email"
                    type="email" 
                    v-model="email" 
                    :error="emailError"
                >

                <!-- <n-input 
                    label="Email"
                    type="email" 
                    v-model:value="email" 
                    :error="emailError"
                /> -->
                    
                <!-- <BaseInput
                    v-model="email"
                    label="email"
                    type="email" 
                /> -->

                <input 
                    v-model="password" 
                    type="password" 
                    name="password"
                >

                <!-- <n-input v-model:value="password" type="password" placeholder="password"/> -->

                <!-- <BaseInput 
                    v-model="password"
                    type="text"
                    label="Password"
                /> -->

                <!-- <button type="submit">Login</button> -->
                <n-button strong secondary type="success" attr-type="submit">Login</n-button>
               

                <p>{{ error }}</p>

                <router-link to="/register">
                    Еще нет аккаунта? Зарегистрироваться
               </router-link>

               </form>

            </div>
        </div>
    </div>
</template>

<script>
// import BaseInput from '@/components/forms/BaseInput.vue';
import { NButton } from 'naive-ui';
// import { NInput } from 'naive-ui';
// import { useField } from 'vee-validate';


export default {
    components: { 
        // BaseInput,
        NButton,
        // NInput,
        
    },
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
        },
    },
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
}
</script>







<style scoped lang="scss">


.login-form {
    background-color: #fff;
    padding: 30px;
    display: inline-block;
    width: 20vw;
    margin: 0 auto;
    border-radius: 8px;
    
}
// input {
//     display: block;
//     width: 100%;
//     margin: 0 auto;
//     margin-bottom: 20px;
//     padding: 10px;
//     border-radius: 8px;
//     border: 1px solid #ccc;
// }
button {
    width: 100%;
    // padding: 10px 0;
    // border-radius: 8px;
    // border: none;
}
.modal {
    width: 25vw;
    margin: 0 auto;
    // margin-left: 0 auto;
    // text-align: center;
}
// .link {
//     color: #6069E0;
// }
// .button {
//     background-color: #6069E0;
//     color: #fff;
//     border-radius: 10px;
//     padding: 15px;
//     width: 100%;
//     display: block;
//     text-align: center;
//     margin-bottom: 20px;
//     border: none;
// }
</style>

