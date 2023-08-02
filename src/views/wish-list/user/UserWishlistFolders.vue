<template>
    <div class="page">
        <!-- <div class="card" v-for="(user,index) in users" :key="index">
            <img class="photo" :src="'/img/' + user.img" />
            <p>{{ user.nickname }}</p>
            <button @click="$router.push(`/user-profile/${user.id}`)">Перейти в профиль</button>
        </div> -->

    <UserPage />
    <div class="flex">
        <h1>User Wish List Folders</h1>
        <img src="@/assets/location.svg" alt="icon" class="nav-item__icon" @click="$router.push(`/user-wish-list/user=${this.$route.params.id}`)"> 
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




export default {
    components: {
        UserFoldersList,
        UserPage,
        MyInput,
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
</style>