<template>
  <div id="app" :class="theme === 'light' ? 'light-theme' : 'dark-theme'">
    <component :is="layuot"> 
      <router-view/>
    </component>
  </div>
</template>



<script>
import MainLayout from "@/layouts/MainLayout"
import HeaderLayout from "@/layouts/HeaderLayout"

// import changeTheme from '@/components/changeTheme.vue'

export default {
  name: 'app',
  computed: {
    layuot () {
      console.log(this.$route.meta.layout)
      return this.$route.meta.layout;
    },
  },
  components: {
    MainLayout, 
    HeaderLayout
  },
  data() {
    return {
      theme: "light"
    }
  }
}
</script>




<style lang="scss">

@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');
@import "@/styles/_variables.scss";


* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  text-decoration: none;
  list-style: none;
  font-family: 'Montserrat';
}


body {
  color: $black;
}
.wrapper {
    max-width: 1140px;
    margin: 0 auto;
}

a {
  color: #000;
}
#app {
  // font-family: Avenir, Helvetica, Arial, sans-serif;
  // -webkit-font-smoothing: antialiased;
  // -moz-osx-font-smoothing: grayscale;
  // text-align: center;
  // color: #2c3e50;
  font-family: 'Montserrat';
}


// nav {
//   padding: 30px;

//   a {
//     font-weight: bold;
//     color: #2c3e50;

//     &.router-link-exact-active {
//       color: #42b983;
//     }
//   }
// }

// .n-tabs-rail {
//     --n-color-segment: #6069E0;
//     --n-color-segment: #FCC95F;
// }
// .n-tabs-tab__label {
//     color: #fff;
// }
// .n-tabs-tab--active .n-tabs-tab__label {
//     color: #6069E0;
//     color: #000;
// }


.page-title {
    background-color: #fff;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 10px;
}

.select {
    flex-basis: 49%;
}

</style>
