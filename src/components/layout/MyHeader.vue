<template>
  <div class="header" :class="theme === 'light' ? 'light-theme' : 'dark-theme'">
    <div class="wrapper">
      <div class="header-inner">
        <div class="header-inner__left">
          <!-- <a href="/">
            <p class="header-link">PelDreams</p>
          </a> -->
          <router-link  to="/">
            Peldreams
          </router-link>
        </div>

        <nav v-if="name">
          <ul class="navtest">
            <li class="navtest-item">
              <router-link to="/ideas-wish-list">ideaWish</router-link>
            </li>
            <li class="navtest-item">
              <router-link to="/ideas-bucket-list">ideaBucket</router-link>
            </li>
          </ul>
        </nav>

       

        <div class="header-inner__right">
          <p>{{ name }}</p>
          <!-- <button @click="Logout">Logout</button> -->
          <button @click="Logout" v-if="name" class="logout-btn">Выйти</button>


          <!-- <a href="#" class="header-link">Катя Пелевина</a> -->
          <!-- <router-link v-if="!loggedIn"  to="/login" class="btn">
            Login
          </router-link>
          <button v-else type="button" class="btn" @click="logout">
            Logout
          </button> -->
        </div>

      </div>
    </div>
  </div>
</template>

<script>
// import { authComputed } from '../../vuex/helpers.js';
import { ref, onBeforeMount } from 'vue';
import firebase from 'firebase';

export default {
  name: 'MyHeader',
  data() {
    return {
      showModal: false,
    }
  },
  // computed: {
  //   ...authComputed
  // },
  // methods: {
  //   logout() {
  //     this.$store.dispatch('logout')
  //   }
  // },
  setup() {

    const name = ref("");

    onBeforeMount(() => {
        const user = firebase.auth().currentUser;

        if(user) {
            name.value = user.email.split('@')[0];
        }
    });

    const Logout = () => {
        firebase
        .auth()
        .signOut()
        .then(() => console.log("Signed out"))
        .then( () => location.reload())
        .catch(err => alert(err.message));
    }


    return { 
        name,
        Logout
      }
    }
}
</script>


<style lang="scss" scoped>
@import "@/styles/_variables.scss";


.navtest {
  display: flex;
}

.navtest-item +.navtest-item {
  padding-left: 30px;
}
.header {
  background-color: $active;
  color: $white;
  width: 100%;
  font-weight: bold;
  letter-spacing: 1.5px;
  margin-bottom: 50px;
  padding: 15px;
  a {
    color: $white;
  }
}
.header-link {
  color: $white;
}
.header-inner {
  @include flex;
}


.hover {
  display: block;
  position: fixed;
  opacity: 0.4;
  width: 100vw;
  height: 100vh;
  background-color: $black;
  left: 0;
  top: 0;
  z-index: 1;
}
.modal {
  position: relative;
  background-color: $white;
  color: $black;
  border-radius: $border-radius;
  display: block;
  width: 100%;
  padding: 15px;
  z-index: 3;
  font-size: 12px;
  font-weight: normal;
  
}
ul {
  li {
    a {
      color: $black;
    }
  }
}

.btn {
  background-color: #fff;
  border-radius: 5px;
  padding: 10px 15px;

}

a.btn {
    color: $active;
}
.logout-btn {
  padding: 5px 15px;
  border: none;
  border-radius: 5px;
  background-color: $bg;
  color: $active;
  font-weight: bold;
  width: 100%;
}
</style>