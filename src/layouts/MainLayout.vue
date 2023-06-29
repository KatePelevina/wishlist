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
        <button @click="changeTheme()" class="theme">Изменить тему</button>
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


export default {
  components: {
    MyHeader,
    MyProfile,
    AddButton,
    PelNavigation,
    // SearchInput,
    // MyWishListFolders,
    RightAside,
    MyFooter,
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

<style lang="scss">
@import "@/styles/_variables.scss";

.light-theme {
  background-color: $bg;
  color: #000;
}

.dark-theme {
  background-color: #030C43;
  color: #fff;
}
.theme {
  width: 100%;
  margin-bottom: 20px;
  border-radius: 10px;
  padding: 15px;
  border: none;
  background-color: $active;
  color: #fff;
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


@media (max-width: 600px) {
  // .header{
  //   display: none;
  // }
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

  .flex {
    display: none;
  }
}

</style>