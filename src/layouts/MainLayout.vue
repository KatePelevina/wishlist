<template>
  <div :class="theme === 'light' ? 'light-theme' : 'dark-theme'">
    <div class="header">
      <MyHeader />
      
      
    </div>
    
    <div class="flex wrapper">

      <div class="left-aside">
        <MyProfile />
        <AddButton />
        <PelNavigation />
      </div>

      <div class="center">
          <!-- <SearchInput /> -->
          <div class="cards">
            <router-view />
            <!-- <MyWishListFolders /> -->
          </div>
      </div>

      <div class="right-aside">
        <!-- <button @click="changeTheme()" class="theme">Изменить тему</button> -->
        <!-- <button @click="changeTheme()" >Изменить тему</button> -->

        <!-- <n-space>
          <n-switch v-model:value="active" @click="changeTheme()" />
        </n-space> -->

        <div class="switch">
          <n-space>
          <n-switch v-model:value="active" size="large" @click="changeTheme()">
            <template #checked-icon>
              <n-icon :component="Moon" />
            </template>
            <template #unchecked-icon>
              <n-icon :component="Sunny" />
            </template>
          </n-switch>
          </n-space>
        </div>
        

        <RightAside />
      </div>
      
    </div>

    <div>
      <MyFooter />
    </div>


  </div>
</template>

<script>
import MyHeader from '@/components/layout/MyHeader.vue'
import MyProfile from '@/components/layout/MyProfile.vue'
import AddButton from '@/components/layout/AddButton.vue'
import PelNavigation from '@/components/layout/PelNavigation.vue'
// import SearchInput from '@/components/layout/SearchInput.vue'
// import MyWishListFolders from '@/views/wish-list/MyWishListFolders.vue'
import RightAside from '@/components/layout/RightAside.vue'
import MyFooter from '@/components/layout/MyFooter.vue'

import { defineComponent, ref } from "vue";
import { NSwitch, NIcon } from 'naive-ui';
import { Sunny, Moon } from "@vicons/ionicons5";




export default defineComponent ({
  components: {
    MyHeader,
    MyProfile,
    AddButton,
    PelNavigation,
    // SearchInput,
    // MyWishListFolders,
    RightAside,
    MyFooter,

    NSwitch,
    NIcon,
    // Sunny, 
    // Moon
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
  },
  // setup() {
  //   return {
  //     active: ref(false)
  //   };
  // }
  setup() {
    return {
      active: ref(false),
      Sunny,
      Moon
    };
  }
})


</script>

<style lang="scss">
@import "@/styles/_variables.scss";

.light-theme {
  background-color: $bg;
  color: #000;
  .page {
    background-color: #fff;
  }
}

.dark-theme {
  background-color: #030C43;
  // color: #fff;
  .theme-element {
    background-color:#020518;
    color: #fff;
    a {
      color: #fff;
    }
  }
  .page {
    background-color: #020518;
    color: #fff;
    a {
      color: #fff;
    }
  }
}
.theme {
  width: 100%;
  margin-bottom: 20px;
  border-radius: 10px;
  padding: 15px;
  border: none;
  background-color: $active;
  color: #fff;
  cursor: pointer;
}



.flex {
  display: flex;
  justify-content: space-between;
  align-items: start;
}

.left-aside {
  flex-basis: 25%;
  // width: 25%;
}
.center {
  flex-basis: 50%;
  // width: 50%;
  margin-left: 15px;
  margin-right: 15px;
  min-height: 100vh;
}
.right-aside {
  flex-basis: 25%;
  // width: 25%;
}
.switch {
  margin-bottom: 20px;
}


@media (max-width: 600px) {
  .header{
    display: none;
  }
  .left-aside {
    display: none;
  }
  .center {
    width: 100%;
    flex-basis: 100%;
  }
  .right-aside {
    display: none;
  }

  // .flex {
  //   display: none;
  // }
}

</style>