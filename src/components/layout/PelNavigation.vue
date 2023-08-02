<template>
    <ul class="nav theme-element"> 
        <li class="nav-item">
            <img src="@/assets/search.svg" alt="icon" class="nav-item__icon">
            <router-link to="/my-wish-list-folders">WISHLIST</router-link>
        </li>
        <li class="nav-item">
            <img src="@/assets/search.svg" alt="icon" class="nav-item__icon">
            <router-link to="/my-bucket-list-folders">BUCKETLIST</router-link>
        </li>
        <li class="nav-item">
            <img src="@/assets/search.svg" alt="icon" class="nav-item__icon">
            <router-link to="/ideas-wish-list">Идеи для Wish List</router-link>
        </li>
        <li class="nav-item">
            <img src="@/assets/search.svg" alt="icon" class="nav-item__icon">
            <router-link to="/ideas-bucket-list">Идеи для Bucket List</router-link>
        </li>
        <li class="nav-item">
            <img src="@/assets/setting.svg" alt="icon" class="nav-item__icon">
            <router-link to="/i-will-present">Я подарю</router-link>
        </li>
        <li class="nav-item">
            <img src="@/assets/setting.svg" alt="icon" class="nav-item__icon">
            <router-link to="/i-will-get">Мне подарят</router-link>
        </li>



        <!-- <li class="nav-item">
            <img src="@/assets/search.svg" alt="icon" class="nav-item__icon">
            <router-link to="/countries">countries</router-link>
        </li> -->
        <!-- <li class="nav-item">
            <img src="@/assets/search.svg" alt="icon" class="nav-item__icon">
            <router-link to="/checklist">checklist</router-link>
        </li> -->
         <!-- <li class="nav-item">
            <img src="@/assets/setting.svg" alt="icon" class="nav-item__icon">
            <router-link to="/edit-profile">Аккаунт</router-link>
        </li> -->
        
    </ul>
</template>

<script>


export default {
    name: 'PelNavigation',
}
</script>

<style lang="scss" scoped>
@import "@/styles/_variables.scss";
.nav {
    background-color: $white;
    border-radius: 10px;
    padding: 15px;
    font-size: 14px;
    margin-top: 20px;
    a {
        color: $black;
    }
}
.nav-item {
    display: flex;
    align-items: center;
    padding-left: 10px;
    padding: 10px;
}
.nav-item:hover {
    background-color: $bg;
    border-radius: 10px;
    cursor: pointer;
    a {
        color: $active;
    }
}
.nav-item__icon {
    margin-right: 15px;
    width: 20px;
    height: 20px;
}
.router-link-active {
    font-weight: bold;
}
</style>


