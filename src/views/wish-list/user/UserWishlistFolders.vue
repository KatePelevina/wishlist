<template>
    <div class="page">
        <!-- <div class="card" v-for="(user,index) in users" :key="index">
            <img class="photo" :src="'/img/' + user.img" />
            <p>{{ user.nickname }}</p>
            <button @click="$router.push(`/user-profile/${user.id}`)">Перейти в профиль</button>
        </div> -->

    <UserPage />

    <div class="flex-left">
        <div class="popover">
            <n-popover trigger="hover">
                <template #trigger>
                    <n-space @click="$router.push(`/user-wish-list/user=${this.$route.params.id}`)">
                        <!-- <n-switch v-model:value="active" /> -->
                        <n-icon size="25" @click="showInfo=true">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M160 144h288"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M160 256h288"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M160 368h288"></path><circle cx="80" cy="144" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></circle><circle cx="80" cy="256" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></circle><circle cx="80" cy="368" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></circle></svg>                            
                        </n-icon>
                    </n-space>
                </template>
                <span>Просмотр желаний списком</span>
            </n-popover>
        </div>

        <h1>User WISHLIST Folders</h1>
        <!-- <img src="@/assets/location.svg" alt="icon" class="nav-item__icon" @click="$router.push(`/user-wish-list/user=${this.$route.params.id}`)">  -->
    </div>

    <my-input
        v-if="folders.length"
        v-model="searchQuery"
        placeholder="Поиск..."
    />
    <UserFoldersList :folders="sortedAndSearchedPosts"/>

    

    </div>
</template>

<script>
import axios from 'axios';
import UserFoldersList from '@/components/folders/UserFoldersList';
import UserPage from '@/components/users/UserPage.vue';
import MyInput from '@/components/layout/MyInput.vue';

import { NPopover, NSpace, NIcon } from 'naive-ui';


export default {
    components: {
        UserFoldersList,
        UserPage,
        MyInput,
        NPopover,
        NSpace, 
        NIcon
    },
    data() {
        return {
            users:[],
            wishes: [],
            folders: [],
            selectedSort: '',
            searchQuery: '',
            sortOptions: [
                {value: 'name', name: 'По названию'},
                {value: 'date', name: 'По дате создания'},
            ],
        }
    },
    methods: {
        async getFolders() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-user-wishlist-folders&id='+id)
            .then((response)=>{
                this.folders = response.data.folders; 
                console.log(this.folders);
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async getWish() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-user-wishlist&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes;
                this.users = response.data.users;
            })
        },
    },
    mounted() {
        this.getFolders() 
        this.getWish() 
    },
    computed: {
        sortedPosts() {
            return [...this.folders].sort((folder1, folder2) => folder1[this.selectedSort]?.localeCompare(folder2[this.selectedSort]))
        },
        sortedAndSearchedPosts() {
            return this.sortedPosts.filter(folder => folder.name.toLowerCase().includes(this.searchQuery.toLowerCase()))
        }
    },
   
}

</script>

<style lang="scss" scoped>
@import "@/styles/_variables.scss";

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
.flex-left {
    display: flex;
    justify-content: start;
    align-items: center;
}
.popover {
    margin-right: 10px;
    cursor: pointer;
}
</style>