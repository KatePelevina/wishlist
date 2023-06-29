<template>
  <div class="header" :class="theme === 'light' ? 'light-theme' : 'dark-theme'">
    <div class="wrapper">
      <div class="header-inner">
        <div class="header-inner__left">
          <a href="/">
            <p class="header-link">PelDreams</p>
          </a>
        </div>

        <nav>
          <ul class="navtest">
            <li class="navtest-item">
              <router-link to="/my-wish-list-folders">Wish List</router-link>
            </li>
            <li class="navtest-item">
              <router-link to="/my-bucket-list-folders">Bucket List</router-link>
            </li>
            <li class="navtest-item">
              <router-link to="/blog">Blog</router-link>
            </li>
          </ul>
        </nav>
        <div class="header-inner__right">
          <div class="flex">
            <!-- <div class="header-link">
              <router-link to="/login">Sign in</router-link>
            </div> -->
            <!-- <div class="header-link">
              <router-link to="/reg">Sign up</router-link>
            </div> -->
          </div>

          <div>
            <div v-if="showModal">
              <div class="modal" @click="showModal=false;">
                <ul>
                  <li>
                    <router-link to="/">Выйти</router-link>
                  </li>
                  <li>
                    <router-link to="/edit-profile" >Редактировать профиль</router-link>
                  </li>
                </ul>
              </div>
              <div class="hover" @click="showModal=false;"></div>
            </div>

            <div v-else @click="showModal=true">
              <a href="#" class="header-link">Катя Пелевина</a>
            </div>
            
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'MeHeader',
  data() {
    return {
      showModal: false,
    }
  },
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

</style>