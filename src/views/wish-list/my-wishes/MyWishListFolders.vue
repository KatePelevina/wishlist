<template>
    <div class="page">
        <n-drawer v-model:show="active"  :placement="placement">
            <n-drawer-content closable>
                <msg-component
                    class="msg"
                    :errorMsg="this.errorMsg"
                    :successMsg="this.successMsg"
                />
            </n-drawer-content>
        </n-drawer>

        <!-- <button @click="$router.push(`/`)">reload</button>
        <button @click="Logout" v-if="name">Logout</button>

        <h3>Welcome, {{ name }}</h3> -->

        <div class="flex color">
            <div class="popover">
                <n-popover trigger="hover">
                    <template #trigger>
                        <n-space @click="$router.push(`/all-wishlist-view`)">
                            <!-- <n-switch v-model:value="active" /> -->
                            <n-icon size="25" @click="showInfo=true">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M160 144h288"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M160 256h288"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M160 368h288"></path><circle cx="80" cy="144" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></circle><circle cx="80" cy="256" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></circle><circle cx="80" cy="368" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></circle></svg>                            
                            </n-icon>
                        </n-space>
                    </template>
                    <span>Просмотр желаний списком</span>
                </n-popover>
            </div>
            <div>
                <n-icon size="25" @click="showInfo=true" class="nav-item__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M10.492 8.91A.5.5 0 0 0 9.5 9v4.502l.008.09a.5.5 0 0 0 .992-.09V9l-.008-.09zm.307-2.16a.75.75 0 1 0-1.5 0a.75.75 0 0 0 1.5 0zM18 10a8 8 0 1 0-16 0a8 8 0 0 0 16 0zM3 10a7 7 0 1 1 14 0a7 7 0 0 1-14 0z" fill="currentColor"></path></g></svg>
                </n-icon>
            </div>
        </div>
        
        <div>
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
            class="input"
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
                    <form>
                        <label>Название папки*</label>
                        <n-input v-model:value="newFolder.name" type="text" placeholder="Название папки"/>

                        <label>Описание папки</label>
                        <n-input v-model:value="newFolder.description" type="text" placeholder="Описание"/>
                        
                        <n-button strong secondary type="success" @click="showModal=false; addFolder(); activate('top')" class="add-btn">Создать папку</n-button>
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
import { NModal, NCard, NSpace, NSelect, NButton, NInput, NIcon, NPopover } from 'naive-ui';

// import { NSwitch } from 'naive-ui';

import FoldersList from '@/components/folders/FoldersList';
import MyInput from '@/components/layout/MyInput.vue';

import { defineComponent, ref } from "vue";

import MsgComponent from '@/components/layout/MsgComponent.vue';
import { NDrawer, NDrawerContent }  from 'naive-ui';

import { onBeforeMount } from 'vue';
import firebase from 'firebase';


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
        // NSwitch,
        NPopover,
        MsgComponent,
        NDrawer,
        NDrawerContent 
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
            events: '',
            errorMsg: "",
            successMsg: "",
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
        // reload(time) {
        //     setTimeout(function(){
        //         self.$router.push(`/`);
        //     }, time)
        // }
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
        const active = ref(false);
        const placement = ref("right");
        const activate = (place) => {
        active.value = true;
        placement.value = place;
        };

        const name = ref("");

        onBeforeMount(() => {
            const user = firebase.auth().currentUser;

            if(user) {
                name.value = user.email.split('@')[0];
            }
        });

        const Logout = () => {
            firebase
            .auth()
            .signOut()
            .then(() => console.log("Signed out"))
            .then( () => location.reload())
            .catch(err => alert(err.message));
        }

        return {
            value: ref(null),
            // active: ref(false),
            active,
            placement,
            activate,
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

            name,
            Logout
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
    margin-bottom: 20px;
}
.div-button {
    flex-basis: 49%;
}
.button {
    @include button;
    width: 100%;
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
.title {
    margin-bottom: 20px;
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
.color {
    border: 1px $bg solid;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 20px;
}
.input {
    margin-bottom: 20px;
}
.msg {
    width: 50%;
    margin: 0 auto;
    padding-top: 50px;
}
.popover {
    cursor: pointer;
}
.nav-item__icon {
    cursor: pointer;
}
</style>
