<template>
    <div class="pages">
        <h1>wish-list-tabs-done</h1>

        <div class="flex" @click="showInfo=true">
            <h1 class="title">
                <img src="@/assets/location.svg" alt="icon" class="nav-item__icon"> 
                Wish List
            </h1>
        </div>

        <n-tabs type="segment">
            <n-tab-pane name="folders" tab="Папки">
                <!-- <p>1</p> -->
                <AllFoldersList :folders="sortedAndSearchedPosts"/>
            </n-tab-pane>
            <n-tab-pane name="list" tab="Список">
               <AllWishListView />
            </n-tab-pane>
        </n-tabs>
    </div>
</template>

<script>
import axios from 'axios';
import { defineComponent, ref } from "vue";

import { NTabs, NTabPane } from 'naive-ui';

import AllFoldersList from '@/components/folders/AllFoldersList.vue';
import AllWishListView from '@/views/wish-list/AllWishListView.vue'
export default defineComponent ({
    components: {
        NTabs,
        NTabPane,
        AllFoldersList,
        AllWishListView
    },
    data() {
        return {
            folders: [],
            selectedSort: '',
            searchQuery: '',
        }
    },
    methods: {
        async getFolders() {
            await axios.get('http://localhost:8085/public/process.php?action=get-wishlist-folders')
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
                label: "Сортировать",
                value: "",
                disabled: true
                },
                {
                label: "По названию",
                value: "name",
                },
                {
                label: "По дате создания",
                value: "date"
                }
            ]
        };
    }
})

</script>

<style lang="scss" scoped>
.pages {
    background-color: #fff;
  }
</style>