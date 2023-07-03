<template>
    <div class="page">
        <user-page />


        <div class="flex title">
            <h1>User Bucket List Folders</h1>
            <img src="@/assets/location.svg" alt="icon" class="nav-item__icon" @click="$router.push(`/user-bucket-list/folder=${this.$route.params.id}`)"> 
        </div>

        <UserFoldersList :folders="sortedAndSearchedPosts"/>

    </div>
</template>

<script>
import axios from 'axios';
import UserPage from "@/components/users/UserPage.vue";

import UserFoldersList from '@/components/folders/UserFoldersList';


export default {
    components: {
        UserPage,
        UserFoldersList
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

            await axios.get('http://localhost:8085/public/process.php?action=get-user-bucketlist-folders&id='+id)
            .then((response)=>{
                this.folders = response.data.folders; 
                console.log(this.folders);
            })
            .catch((error)=>{
                console.log(error)
            })
        },
    },
    mounted() {
        this.getFolders() 
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

<style scoped lang="scss">
@import "@/styles/_variables.scss";

.page {
    @include page;
}

.flex {
    @include flex;
}

.title {
    margin-bottom: 50px;
}
</style>