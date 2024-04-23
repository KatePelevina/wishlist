<template>
    <div class="page">
        <div class="flex color">
            <div>
                <n-space @click="$router.push(`/all-bucketlist-view`)">
                <n-switch v-model:value="active" />
                </n-space>
            </div>
            <div>
                <n-icon size="25" @click="showInfo=true">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M10.492 8.91A.5.5 0 0 0 9.5 9v4.502l.008.09a.5.5 0 0 0 .992-.09V9l-.008-.09zm.307-2.16a.75.75 0 1 0-1.5 0a.75.75 0 0 0 1.5 0zM18 10a8 8 0 1 0-16 0a8 8 0 0 0 16 0zM3 10a7 7 0 1 1 14 0a7 7 0 0 1-14 0z" fill="currentColor"></path></g></svg>
                </n-icon>
            </div>
        </div>

        <msg-component
            :errorMsg="this.errorMsg"
            :successMsg="this.successMsg"
        />

        <div class="flex" >
            <h1 class="title" @click="showInfo=true">
                <img src="@/assets/location.svg" alt="icon" class="nav-item__icon"> 
                Bucket List
            </h1>
            
            <img src="@/assets/location.svg" alt="icon" class="nav-item__icon" @click="$router.push(`/all-bucketlist-view`)"> 
        </div>
    

    <!-- <div class="flex" @click="showInfo=true">
        <h1 class="title">
            <img src="@/assets/location.svg" alt="icon" class="nav-item__icon"> 
            Bucket List
        </h1>
        <p>Кол-во папок: {{ folders.length }}</p>
    </div> -->

    <div class="flex">
        <div class="flex-left">
            <p class="ddddd">Количество папок: {{ folders.length }}</p>
        </div>
        <div class="div-button flex-right">
            <n-button @click="showModal=true" class="btn" strong secondary type="success">+ Новая папка </n-button>
        </div>
    </div>



    <!-- <div class="flex">
        <div class="select">
            <my-select
                v-model="selectedSort"
                :options="sortOptions" 
            />
        </div>
        <div class="div-button">
            <button @click="showModal=true" class="button">+ Новая папка</button>
        </div>
    </div> -->

    <!-- <div class="flex"> -->
        <!-- <div class="div-button">
            <n-button @click="showModal=true" class="btn" strong secondary type="success">+ Новая папка </n-button>
        </div> -->
        <div class="select"  v-if="folders.length">
            <n-space vertical>
                <n-select v-model:value="selectedSort" :options="options" />
            </n-space>
        </div>
    <!-- </div> -->
    
    <!-- <div class="cards" v-if="folders.length">
        <div class="card-test" v-for="(folder,index) in folders" :key="index" @click="$router.push(`/my-bucket-list/${folder.id}`)">
            <p>{{ folder.name }}</p>
        </div>
    </div> -->

    <!-- <folders-component :folders="folders" /> -->
    <!-- <folder-item 
    v-for="folder in folders" 
    :folders="folders"
    :key="folder.id"  /> -->

    <my-input
        v-if="folders.length"
        v-model="searchQuery"
        placeholder="Поиск..."
    />


   
    <!-- <FoldersBucketlist :folders="sortedAndSearchedPosts"/> -->
    <FoldersList :folders="sortedAndSearchedPosts"/>

    
    
    <div v-if="showModal">
        <n-modal v-model:show="showModal">
            <n-card
            style="width: 600px"
            :bordered="false"
            size="huge"
            role="dialog"
            aria-modal="true"
            >
            <div class="add-box">
                <form action="">
                    <!-- <input type="text" placeholder="Название папки" v-model="newFolder.name" required> -->
                    <n-input v-model:value="newFolder.name" type="text" placeholder="Название папки"/>
                    <n-input v-model:value="newFolder.description" type="text" placeholder="Описание папки"/>


                    <n-button strong secondary type="success" @click="showModal=false; addFolder();" class="add-btn">Создать папку</n-button>
                    <!-- <button class="button" @click="showModal=false; addFolder();">Создать папку</button> -->
                </form>
                
            </div>
            </n-card>
        </n-modal>
    </div>

    <div v-if="showInfo">
            <n-modal v-model:show="showInfo">
                <n-card
                style="width: 600px"
                :bordered="false"
                size="huge"
                role="dialog"
                aria-modal="true"
                >
                <div>
                    <p>Bucket List - это</p>
                </div>
                </n-card>
            </n-modal>
        </div>

    </div>
</template>

<script>
import axios from 'axios';
import { defineComponent, ref } from "vue";

import MsgComponent from '@/components/layout/MsgComponent.vue';
import { NModal, NCard } from 'naive-ui';
import { NSpace, NSelect } from 'naive-ui';
import { NButton} from 'naive-ui';
import { NInput } from 'naive-ui';
import { NSwitch, NIcon } from 'naive-ui';


import FoldersList from '@/components/folders/FoldersList';
// import FolderItem from '@/components/FolderItem.vue';
import MyInput from '@/components/layout/MyInput.vue';
// import MySelect from '@/components/layout/MySelect.vue';




export default defineComponent ({
    name: 'MyBucketListFolders',
    components: {
        NModal, 
        NCard,
        MsgComponent,
        FoldersList,
        MyInput,
        // MySelect,
        NSpace,
        NSelect,
        NButton,
        NInput,
        NSwitch, NIcon
        // FolderItem
    },
    data() {
        return {
            folders: [],
            showModal: false,
            showInfo: false,
            newFolder: {
                name: "",
                type: "my-bucket-list",
                description: ""
            },
            selectedSort: '',
            searchQuery: '',
            // sortOptions: [
            //     {value: 'name', name: 'По name'},
            //     {value: 'date', name: 'По date'},
            // ],
            errorMsg: "",
            successMsg: "",
        }
    },
    methods: {
        async getFolders() {
            await axios.get('http://localhost:8085/public/process.php?action=get-bucketlist-folders')
            .then((response)=>{
                
                this.folders = response.data.folders; 
                
                console.log(this.folders)
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async addFolder(){
            let formData = this.toFormData(this.newFolder);

            await axios.post("http://localhost:8085/public/process.php?action=add-bucket-folder", formData)
            .then((response)=>{
                this.newFolder = {name: "", type: "my-bucket-list", description: ""};


                if(response.data.error){
                    this.errorMsg = response.data.message;
                } else {
                    this.successMsg = response.data.message;
                    // this.$router.push('/my-bucket-list-folders'); 
                    // location.reload();    
                    this.getFolders();           
                }
            });
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
                label: "по названию",
                value: "name",
                },
                {
                label: "по дате создания",
                value: "date"
                }
            ]
        };
    }
})
</script>

<style lang="scss" scoped>
@import "@/styles/_variables.scss";

.cards {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}
.card-test {
    flex-basis: 49%;
    border-radius: 10px;
    background-color: #fff;
    padding: 30px;
    margin-bottom: 10px;
    cursor: pointer;
    img {
        width: 100%;
    }
}
.button {
    @include button;
    width: 100%;
    // padding: 15px;
    // border-radius: 10px;
    // border: 1px #ccc solid;
    // height: 100%;
}
.flex {
    @include flex;
    margin-bottom: 20px;
}

.page {
    @include page;
}

.select {
    flex-basis: 49%;
}
// select {
//     width: 100%;
//     padding: 15px;
//     border-radius: 10px;
//     border: 1px #ccc solid;
//     height: 100%;
// }
.div-button {
    flex-basis: 49%;
}
.nav-item__icon {
    cursor: pointer;
}

.div-button {
    flex-basis: 49%;
}
.btn {
    width: 100%; 
}
.add-box {
    @include add-box;
}
.add-btn {
    margin-top: 10px;
    width: 100%; 
}
.nav-item__icon, .title {
    cursor: pointer;
}

.ddddd {
    text-align: center;
    background-color: $bg;
    width: 100%;
    padding: 6px;
    border-radius: 5px;
}

.flex-left, .flex-right {
    flex-basis: 49%;
}
.color {
    border: 1px $bg solid;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 20px;
}
</style>