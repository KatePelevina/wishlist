// import { createStore } from "vuex";
// import router from "@/router";

// import { auth } from '@/firebase';


// import { 
//     createUserWithEmailAndPassword, 
//     signInWithEmailAndPassword, 
//     signOut 
// } from 'firebase/auth';


// export default createStore ({
//     state: {
//         user: null
//     },
//     mutations: {
//         SET_USER (state, user) {
//             state.user = user
//         },
//         CLEAR_USER (state) {
//             state.user = null
//         }
//     },
//     actions: {
//         async login({ commit }, details)  {
//             const { email, password } = details

//             try {
//                 await signInWithEmailAndPassword( auth, email, password )
//             } catch (error) {
//                 switch(error.code) {
//                     case 'auth/user-not-found':
//                         alert("Пользователь не найден")
//                         break
//                     case 'auth/wrong-password':
//                         alert('Неправильный пароль')
//                         break
//                     default:
//                         alert('Что-то пошло не так')
//                 }

//                 return
//             }

//             commit('SET_USER', auth.currentUser)

//             router.push('/')
//         },
//         async register({ commit }, details)  {
//             const { email, password } = details;

//             try {
//                 await createUserWithEmailAndPassword( auth, email, password )
//             } catch (error) {
//                 switch(error.code) {
//                     case 'auth/mail-already-in-user':
//                         alert("Данный email уже существует")
//                         break
//                     case 'auth/invalid-email':
//                         alert("Невалидный email")
//                         break
//                     case 'auth/operation-not-allowd':
//                         alert("Операция не разрешена")
//                         break
//                     case 'auth/weak-password':
//                         alert("Слабый пароль")
//                         break
//                     default:
//                         alert('Что-то пошло не так')
//                 }

//                 return
//             }

//             commit('SET_USER', auth.currentUser)

//             router.push('/')
//         },
//         async logout({ commit })  {

//             await signOut(auth)

//             commit('CLEAR_USER')

//             router.push('/login')
//         },
//         fetchUser ({ commit }) {
//             auth.onAuthStateChanged( async user => {
//                 if(user === null) {
//                     commit('CLEAR_USER')
//                 } else {
//                     commit('SET_USER', user)

//                     if (router.isReady() && router.currentRoute.value.path === '/login') {
//                         router.push('/')
//                     }
//                 }
//             })
//         }
//     }
// })