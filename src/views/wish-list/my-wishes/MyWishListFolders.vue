<template>
    <div class="page">
        <div class="flex color">
            <div>
                <n-space @click="$router.push(`/all-wishlist-view`)">
                    <n-switch v-model:value="active" />
                </n-space>
            </div>
            <div>
                <n-icon size="25" @click="showInfo=true">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M10.492 8.91A.5.5 0 0 0 9.5 9v4.502l.008.09a.5.5 0 0 0 .992-.09V9l-.008-.09zm.307-2.16a.75.75 0 1 0-1.5 0a.75.75 0 0 0 1.5 0zM18 10a8 8 0 1 0-16 0a8 8 0 0 0 16 0zM3 10a7 7 0 1 1 14 0a7 7 0 0 1-14 0z" fill="currentColor"></path></g></svg>
                </n-icon>
            </div>
        </div>
        
        <div class="flex">
            <h1 class="title">
                Wish List
            </h1>
        </div>

        <div class="flex">
            <div class="flex-left">
                <p class="ddddd">Количество папок: {{ folders.length }}</p>
            </div>
            <div class="div-button flex-right">
                <n-button @click="showModal=true" class="btn" strong secondary type="success">+ Новая папка </n-button>
            </div>
        </div>

        <div class="select"  v-if="folders.length">
            <n-space vertical>
                <n-select v-model:value="selectedSort" :options="options" />
            </n-space>
        </div>
        
        <my-input
            v-if="folders.length"
            v-model="searchQuery"
        />

        <FoldersList :folders="sortedAndSearchedPosts" />
    
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
                    <h4 class="add-box__title">Добавить папку в мой Wish List</h4>
                    <form action="">
                        <!-- <input type="text" placeholder="Название папки" v-model="newFolder.name" required> -->
                        <n-input v-model:value="newFolder.name" type="text" placeholder="Название папки"/>
                        <n-input v-model:value="newFolder.description" type="text" placeholder="Описание"/>

                        <!-- <button @click="showModal=false; addFolder();" class="button">Создать папку</button> -->
                        <n-button strong secondary type="success" @click="showModal=false; addFolder();" class="add-btn">Создать папку</n-button>

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
                    <p>Wish List - это</p>
                </div>
                </n-card>
            </n-modal>
        </div>

    </div>

</template>

<script>

import axios from 'axios';
import { NModal, NCard, NSpace, NSelect, NButton, NInput, NSwitch, NIcon} from 'naive-ui';

import FoldersList from '@/components/folders/FoldersList';
import MyInput from '@/components/layout/MyInput.vue';

import { defineComponent, ref } from "vue";

export default defineComponent ({
    name: 'MyWishListFolders',
    components: {
        NButton,
        NModal, 
        NCard,
        NSpace,
        NSelect,
        FoldersList,
        NInput,
        MyInput,
        NIcon,
        NSwitch
    },
    props: ['id'],
    data() {
        return {
            showModal: false,
            showInfo: false,
            folders: [],
            newFolder: {
                name: "",
                type: "my-wish-list",
                description: ""
            },
            selectedSort: '',
            searchQuery: '',
            sortOptions: [
                {value: 'name', name: 'По названию'},
                {value: 'date', name: 'По дате создания'},
            ],
            events: ''
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
        async addFolder(){
            let formData = this.toFormData(this.newFolder);

            await axios.post("http://localhost:8085/public/process.php?action=add-wishlist-folder", formData)
            .then((response)=>{
                this.newFolder = {name: "", type: "my-wish-list", description: ""};


                if(response.data.error){
                    this.errorMsg = response.data.message;
                } else {
                    this.successMsg = response.data.message;
                    // this.$router.push('/my-wish-list-folders');
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
                label: "По названию",
                value: "name",
                },
                {
                label: "По дате создания",
                value: "date"
                }
            ],
        };
    }
});
</script>

<style lang="scss" scoped>
@import "@/styles/_variables.scss";

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

.button {
    @include button;
    width: 100%;
    // padding: 15px;
    // border-radius: 10px;
    // border: 1px #ccc solid;
    // height: 100%;
    // cursor: pointer;
}

input {
    @include input;
}

.add-box {
    @include add-box;
    text-align: left;
}
.add-box__title {
    margin-bottom: 20px;
}
.btn {
    width: 100%; 
}
// .nav-item__icon {
//     cursor: pointer;
// }

.title {
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

.add-btn {
    width: 100%;
    // margin-top: 10px;
}
.n-input {
    margin-bottom: 10px;
}


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
.card-test:hover {
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
    border: none;
}
.color {
    border: 1px $bg solid;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 20px;
}



</style>

<!-- <style lang="scss" scoped>
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
    color: #000;
    padding: 30px;
    margin-bottom: 10px;
    cursor: pointer;
    img {
        width: 100%;
    }
}


.green {
//    background-color: #5BAB70;
   border: 1px solid #5BAB70;
   background-color: #F6F7FF;
   color: #5BAB70;
}

@media (max-width: 600px) {
    .cards {
        width: 100%;
        margin: 0 auto;
    }
    .card-test {
        flex-basis: 100%;
    }
}
</style> -->