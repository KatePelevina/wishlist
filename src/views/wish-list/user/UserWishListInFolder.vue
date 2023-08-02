<template>
    <div class="page">


        <div class="flex">
            <h1>User Wish List</h1>
            <h2 v-for="folder in folders" :key="folder.id">Папка: {{ folder.name}}</h2>
            <img src="@/assets/location.svg" alt="icon" class="nav-item__icon" @click="$router.push(`/user-wish-list-folders/user=${this.$route.params.id}`)"> 
        </div>

        <p v-for="user in users" :key="user.id">{{ user.firstName }} {{ user.secondName }}</p>
        
    
        <!-- <my-input
            v-model="searchQuery"
            placeholder="Поиск..."
        /> -->

        <!-- <user-wish-list :wishes="sortedAndSearchedPosts"/> -->

        <n-tabs type="segment">
            <n-tab-pane name="want" tab="Хочет">
               <UserWantWishList />
            </n-tab-pane>
            <n-tab-pane name="done" tab="Исполнено">
             <UserDoneWishList />
            </n-tab-pane>
            <n-tab-pane name="all" tab="Все">
                <AllUserWishlist />
            </n-tab-pane>
        </n-tabs>
    
    </div>
</template>

<script>
import axios from 'axios';
// import MyInput from '@/components/layout/MyInput.vue';
// import UserWishList from '@/components/users/UserWishList.vue';
import { NTabs, NTabPane } from 'naive-ui';

import UserWantWishList from '@/views/wish-list/user/UserWantWishList.vue';
import UserDoneWishList from '@/views/wish-list/user/UserDoneWishList.vue';
import AllUserWishlist from '@/views/wish-list/user/AllUserWishlist.vue';

export default {
    components: {
        // MyInput,
        // UserWishList,
        NTabs, 
        NTabPane,
        UserWantWishList,
        UserDoneWishList,
        AllUserWishlist
    },
    data() {
        return {
            users:[],
            wishes: [],
            selectedSort: '',
            searchQuery: '',
            folders: ''
        }
    },
    methods: {
        async getWish() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-user-wishlist-in-folder&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes;
            })
        },
        async getUser() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-user-from-folder-wishlist&id='+id)
            .then((response)=>{
                this.users = response.data.users;
                console.log( this.users);
            })
        },
        async getFolder() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-folder&id='+id)
            .then((response)=>{
                this.folders = response.data.folders;
            })
        },
    },
    mounted() {
        this.getWish()
        this.getUser()
        this.getFolder() 
    },
    computed: {
        sortedPosts() {
            return [...this.wishes].sort((wish1, wish2) => wish1[this.selectedSort]?.localeCompare(wish2[this.selectedSort]))
        },
        sortedAndSearchedPosts() {
            return this.sortedPosts.filter(wish => wish.name.toLowerCase().includes(this.searchQuery.toLowerCase()))
        }
    },
}
</script>

<style lang="scss" scoped>
@import "@/styles/_variables.scss";



.box {
    flex-basis: 49%;
    height: 200px;
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    img {
        height: 200px;
    }
}
// .box:hover {
//     box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
// }
.box-inner {
    background-color: #fff;
    text-align: center;
    position: relative;
    p {
        opacity: 0;
    }
}
.box-inner:hover {
    p {
        opacity: 1;
        position: absolute;
        bottom: 10px;
        left: 10px;
    }
}
.span {
    background-color: $active;
    color: #fff;
    padding: 5px;
    border-radius: 5px;
    position: absolute;
    top: 10px;
    right: 10px;
}
.items {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}
.item {
   width: 49%;
   margin-bottom: 10px;
   
}

.photo {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: "#ссс";
    margin-right: 10px;
    background-image: url('@/assets/photo.jpg');
    background-size: 40px;
    background-position: center;
}

.page {
    @include page;
}
.flex {
    @include flex;
}
</style>