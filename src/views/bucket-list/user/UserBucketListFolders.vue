<template>
    <div class="page">
        <user-page />


        <div class="flex-left title">
            <div class="popover">
                <n-popover trigger="hover">
                    <template #trigger>
                        <n-space @click="$router.push(`/user-bucket-list/user=${this.$route.params.id}`)">
                            <n-icon size="25" @click="showInfo=true">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M160 144h288"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M160 256h288"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M160 368h288"></path><circle cx="80" cy="144" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></circle><circle cx="80" cy="256" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></circle><circle cx="80" cy="368" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></circle></svg>                            
                            </n-icon>
                        </n-space>
                    </template>
                    <span>Просмотр желаний списком</span>
                </n-popover>
            </div>

            <h1>User BUCKETLIST Folders</h1>
        </div>

        <div class="select" v-if="folders.length">
            <n-space vertical>
                <n-select v-model:value="selectedSort" :options="options" />
            </n-space>
        </div>

        <div class="search" v-if="folders.length">
            <my-input
            v-model="searchQuery"
            placeholder="Поиск..."
            />
        </div>
        

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
import { NPopover,  NIcon } from 'naive-ui';


export default defineComponent({
    components: {
        UserPage,
        UserFoldersList, 
        MyInput,
        NSpace, 
        NSelect,
        NPopover,  
        NIcon
    },
    data() {
        return {
            users:[],
            wishes: [],
            folders: [],
            selectedSort: '',
            searchQuery: '',
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
                    label: "По видимости",
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
.flex-left {
    display: flex;
    justify-content: start;
    align-items: center;
}
.popover {
    margin-right: 10px;
    cursor: pointer;
}
.select {
    margin-bottom: 20px;
}
.search {
    margin-bottom: 20px;
}
</style>