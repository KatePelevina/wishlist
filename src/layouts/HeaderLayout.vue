<template>
  <div :class="theme === 'light' ? 'light-theme' : 'dark-theme'">
    <MyHeader />
    <div class="main">
      <button @click="changeTheme()">Тема</button>
      <router-view />
    </div>
    <my-footer />
  </div>
  
</template>

<script>
import MyHeader from '@/components/layout/MyHeader.vue'
import MyFooter from '@/components/layout/MyFooter.vue';



export default {
  name: 'HeaderLayout',
  components: {
    MyHeader,
    MyFooter
  },
  data() {
    return {
      theme: "light"
    }
  },
  methods: {
      changeTheme(){
          this.theme = this.theme === "dark" ? "light" : "dark";
      }
  }
}


</script>

<style>
.main {
  min-height: 100vh;
}


</style>

