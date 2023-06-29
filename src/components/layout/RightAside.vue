<template>
    <div class="aside">

        <!-- <router-link to="/subscriptions">
            <p class="aside-title">Подписки</p>
        </router-link> -->
        
       
        <!-- <div v-for="user in users" :key="user.id" @click="this.$router.go(`/user/${user.id}`)">
            <div class="aside-friend" @click="$router.push(`/user/${user.id}`)">
                <div>
                    <img class="photo" :src="'/img/' + user.img" />
                </div>
                <div>
                    <p>{{ user.nickName }}</p>  
                    <p>{{ user.firstName }} {{ user.secondName }}</p>
                </div>
            </div>
        </div>  -->

        <ul class="nav">
            <li class="nav-item">
                <img src="@/assets/star.svg" alt="icon" class="nav-item__icon">
                <router-link to="/subscriptions">Подписки</router-link>
            </li>
            <li class="nav-item">
                <img src="@/assets/folowers.svg" alt="icon" class="nav-item__icon">
                <router-link to="/followers">Подписчики</router-link>
            </li>
            <li class="nav-item">
                <img src="@/assets/add_user.svg" alt="icon" class="nav-item__icon">
                <router-link to="/find-user">Найти пользователя</router-link>
            </li>
        </ul>

    </div>
    <!-- <div class="spans">
        <span  class="span">вкусняшки</span>
        <span  class="span">travel</span>
    </div> -->
</template>

<script>

import axios from 'axios';

export default {
    name: 'RightAside',
    data() {
        return {
            users:[]
        }
    },
    methods: {
        async getSubscriptions(){
            await axios.get('http://localhost:8085/public/process.php?action=get-subscriptions-aside')
            .then((response)=>{
                this.users = response.data.users;
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        toFormData(obj){
            let fd = new FormData();
            for(let i in obj){
                fd.append(i,obj[i]);
            }
            return fd;
        },
    },
    mounted() {
        this.getSubscriptions()
    }
}
</script>

<style lang="scss" scoped>
@import "@/styles/_variables.scss";
.aside {
    background-color: #fff;
    border-radius: 10px;
    padding: 10px;
}
.aside-title {
    margin-bottom: 20px;
}
.aside-friend {
    margin-bottom: 10px;
    display: flex;
    cursor: pointer;
    padding: 5px;
}
.aside-friend:hover {
    background-color: #F6F7FF;
    border-radius: 10px;
    color: #6069E0;
}
.photo {
    @include photo;
}

////@at-root
.nav {
    background-color: $white;
    border-radius: 10px;
    padding: 15px;
    font-size: 14px;
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
}
.nav-item a:hover {
    color: $active;
}
.nav-item__icon {
    margin-right: 15px;
    width: 20px;
    height: 20px;
}

.spans {
    margin-top: 20px;
}
.span {
    padding: 10px;
    background-color: #ccc;
    border-radius: 10px;
    margin-right: 10px;
}
</style>