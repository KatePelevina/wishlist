<template>
    <div class="page">
        <user-page />


        <div class="flex title">
            <h1>User Bucket List Folders</h1>
            <img src="@/assets/location.svg" alt="icon" class="nav-item__icon" @click="$router.push(`/user-bucket-list/user=${this.$route.params.id}`)"> 
        </div>

        <div class="select" v-if="folders.length">
            <n-space vertical>
                <n-select v-model:value="selectedSort" :options="options" />
            </n-space>
        </div>
        <my-input
            v-model="searchQuery"
            placeholder="Поиск..."
        />

        <UserFoldersList :folders="sortedAndSearchedPosts"/>

    </div>
</template>

<script>
import axios from 'axios';
import UserPage from "@/components/users/UserPage.vue";
import UserFoldersList from '@/components/folders/UserFoldersList';
import MyInput from '@/components/layout/MyInput.vue';
import { NSpace, NSelect } from 'naive-ui';

import { defineComponent, ref } from "vue";


export default defineComponent({
    components: {
        UserPage,
        UserFoldersList, 
        MyInput,
        NSpace, 
        NSelect 
    },
    data() {
        return {
            users:[],
            wishes: [],
            folders: [],
            selectedSort: '',
            searchQuery: '',
            // sortOptions: [
            //     {value: 'name', name: 'По названию'},
            //     {value: 'date', name: 'По дате создания'},
            // ],
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
    setup() {
        return {
            value: ref(null),
            options: [
                {
                label: "Сортировать по",
                value: "",
                disabled: true
                },
                {
                label: "По названию",
                value: "name",
                },
                {
                label: "По цене",
                value: "price"
                },
                {
                label: "По дате создания",
                value: "date"
                },
                {
                label: "По visible",
                value: "visible"
                },
            ]            
        };
    }

})

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