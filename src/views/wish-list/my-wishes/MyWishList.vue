<template>
    <div class="page">
     <n-drawer v-model:show="active" :placement="placement">
        <n-drawer-content closable>
            <transition class="msg">
                <msg-component
                :errorMsg="this.errorMsg"
                :successMsg="this.successMsg"
                />
            </transition>
        </n-drawer-content>
    </n-drawer>
    
   <div class="page-title">

        <div class="flex color">
            <div>
                <n-breadcrumb>
                    <n-breadcrumb-item @click="$router.push(`/my-wish-list-folders`)">Wish List</n-breadcrumb-item>
                    <n-breadcrumb-item>{{ folder_name }}</n-breadcrumb-item> 
                </n-breadcrumb>
            </div>
            <div class="card-header__right flex">
                <div @click="showEditModal=true; selectFolder(folder)">
                    <img src="@/assets/edit-1.svg" alt="" class="place-btn edit">
                </div>
                <div @click="showDeleteModal=true; selectFolder(folder);">
                    <img src="@/assets/delete.svg" alt="">
                </div>
            </div>
        </div>


        <h1 class="title folder-name">
            {{ folder_name }} 
        </h1> 
    
        <div class="folder-description" v-if="folder_description">
            <p>{{ folder_description }}</p>
        </div>
   
        <n-tabs type="segment">
            <n-tab-pane name="want" tab="Хочу">
                <WantWishList />
            </n-tab-pane>
            <n-tab-pane name="done" tab="Исполнено">
                <DoneWishListFolder />
            </n-tab-pane>
            <n-tab-pane name="all" tab="Все">
                <AllWishListFolder />
            </n-tab-pane>
        </n-tabs>

        <!-- Edit  Model -->
       <div v-if="showEditModal">
       <div class="modal">
           <n-modal v-model:show="showEditModal">
               <n-card
               style="width: 600px"
               :bordered="false"
               size="huge"
               role="dialog"
               aria-modal="true"
               >
               <div class="add-box">
                    <h5 class="modal-title">Редактирование папки</h5>
                    <form method="post" >

                        <label>Название папки</label>
                        <n-input v-model:value="currentFolder.name" type="text" placeholder="Название" class="input" />

                        <label>Описание папки</label>
                        <n-input v-model:value="currentFolder.description" type="textarea" :autosize="{minRows: 3}" placeholder="Описание" class="input" />

                        <n-button strong secondary type="success" attr-type="submit" @click="showEditModal=false; updateFolder(); activate('top'); reload_interval(2000);" class="add-btn">Обновить</n-button>
                    </form>
                </div>
               
               </n-card>
           </n-modal>
       </div>
       </div>

       <!-- Delete  Model -->
       <div v-if="showDeleteModal">
           <div class="modal">
               <n-modal v-model:show="showDeleteModal">
                   <n-card
                   style="width: 600px"
                   :bordered="false"
                   size="huge"
                   role="dialog"
                   aria-modal="true"
                   >
                   
                   <div class="delete-modal">
                        <h5 class="modal-title">Удаление папки</h5>
                        <h4 class="red">Вы уверены, что хотите удалить папку: '{{ currentFolder.name }}'? </h4>
                       
                       <div class="delete-buttons">
                            <n-button strong secondary type="success" @click="showDeleteModal=false" class="delete-no" >
                                Нет
                            </n-button>
                            <n-button strong secondary type="error" @click="showDeleteModal=false; deleteFolder(2000); activate('top'); clearMsg()" >
                                Да
                            </n-button>
                       </div>
                   </div>
                   
                   
                   </n-card>
               </n-modal>
           </div>
       </div>

    </div>
   </div>
</template>

<script>
import axios from 'axios';
import { defineComponent, ref } from "vue";

import { NModal, NButton, NCard} from 'naive-ui';
import { NInput } from 'naive-ui';
import { NTabs, NTabPane } from 'naive-ui';
import { NBreadcrumb, NBreadcrumbItem} from 'naive-ui';

import MsgComponent from '@/components/layout/MsgComponent.vue'
import DoneWishListFolder from '@/views/wish-list/DoneWishListFolder.vue';
import AllWishListFolder from '@/views/wish-list/AllWishListFolder.vue';
import WantWishList from '@/views/wish-list/my-wishes/WantWishList.vue';
import { NDrawer, NDrawerContent }  from 'naive-ui';


export default defineComponent ({
    name: 'WishList',
    components: { 
       NModal,
       NCard,
       NButton,
       MsgComponent,
       NBreadcrumb,
       NBreadcrumbItem,
       NInput,
       NTabs, 
       NTabPane,
       DoneWishListFolder,
       AllWishListFolder,
       WantWishList,
       NDrawer, 
       NDrawerContent   
    },
    data() {
       return {
           wishes:[],
           nameStr: "",
           showModal: false,
           newWish: { 
               name: "", 
               price: "",
               description: "",
               photo: '',
               link: "",
               visible: "0",
               folder_id: "",
               done: "0",               
           },
            // errorMsg: "",
            // successMsg: "",
            showEditModal: false,
            showDeleteModal: false,
            currentFolder: {
                name: "",
                description: ""
            },
            url: 'my-wish-list-item',
            folder_name: '',
            folder_description: '',
            successMsg: '',
            errorMsg: '',
       }
    },
    methods: {
        async getWishes(){
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-wishlist&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes; 
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async getDoneWishes(){
            
            let id = this.$route.params.id; 
            await axios.get('http://localhost:8085/public/process.php?action=get-done-wishlist-in-folder&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes; 
                console.log(this.wishes)
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async getFolder() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=wishlist-folder&id='+id)
            .then((response)=>{
                this.folders = response.data.folders;

                this.folder_name = response.data.folders[0].name;
                this.folder_description = response.data.folders[0].description;
                this.currentFolder = response.data.folders[0];

                console.log(this.folder_description);
            })
        },
        async addWishList(){
            let id = this.$route.params.id;
            let formData = this.toFormData(this.newWish);
        

            axios.post('http://localhost:8085/public/process.php?action=add-wishlist-to-folder&id='+id, formData)

            .then((response)=>{
                this.newWish = {name: "", price: "", description: "", photo: "", link: "", visible: "", folder_id: "", done: 0};
                
                if (response.data.error) {
                    console.log(response.data);
                    // this.errorMsg = response.data.message;

                } else {
                    console.log(response.data);
                    // this.successMsg = response.data.message;
                    location.reload();
                    this.getWishes(); 
                    this.$router.reload()
                                 
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
        // clearMsg(){
        //     this.errorMsg = "";
        //     this.successMsg = "";
        // },
        async updateFolder() {
            
            let formData = this.toFormData(this.currentFolder);

            axios.post("http://localhost:8085/public/process.php?action=update-wishlist-folder", formData)
            .then((response)=>{
                this.currenFolder = {};
                if(response.data.error){
                        // console.log(response.data);
                    this.errorMsg = response.data.message;
                } else {
                        // console.log(response.data);
                    this.successMsg = response.data.message;
                }
            });
        },
        reload_interval(time){
            setTimeout(function(){
                location.reload();
            }, time);
        },
        deleteFolder(time){
            let id = this.$route.params.id;
        
            axios.post("http://localhost:8085/public/process.php?action=delete-wishlist-folder&id="+id)
            .then((response)=>{
                this.currentFolder = {};
                if(response.data.error){
                    this.errorMsg = response.data.message;
                    // console.log(response.data);
                } else {
                    this.successMsg = response.data.message;
                    // console.log(response.data);
                    // this.$router.push('/my-wish-list-folders'); 

                    let self = this
                    setTimeout(function(){
                        self.$router.push(`/my-wish-list-folders`);
                    }, time)
                }
            });
        },
        selectFolder(folder){
            this.currentWish = folder;
        },
    },
    mounted() {
       this.getWishes()
       this.getDoneWishes()
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
    setup() {
        const active = ref(false);
        const placement = ref("right");
        const activate = (place) => {
        active.value = true;
        placement.value = place;
        };
        return {
            value: ref(null),
            active,
            placement,
            activate,
        };
    }
})

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
   border: 1px solid $bg;
   cursor: pointer;
   img {
       height: 100%;
       width: 100%;
       object-fit: cover;
   }
}
.box:hover {
   box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
   border: none;
}
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

.flex {
   @include flex;
}


.add-box {
   width: 50%;
   margin: auto;

}
.add-box-title {
    text-align: center;
    margin-bottom: 10px;
}

.button {
   @include button;
   width: 100%;
}

.div-button {
    flex-basis: 49%;
}

.options {
    margin-top: 30px;
}

// .msg {

// }

.msg-item {
  display: inline-block;
  margin-right: 10px;
}
.msg-enter-active,
.msg-leave-active {
  transition: all 0.4s ease;
}
.msg-enter-from,
.msg-leave-to {
  opacity: 0;
  transform: translateX(130px);
}
.msg-move {
  transition: transform 0.4s ease;
}

.edit {
    margin-right: 10px;
}

.div-button {
    button {
        width: 100%;
    }
}

.rrrr {
    margin-bottom: 10px;
    margin-top: 20px;
}

.ddddd {
    text-align: center;
    background-color: $bg;
    width: 100%;
    padding: 6px;
    border-radius: 5px;
}

.flex-left-input {
    width: 50%;
}

.add-btn {
    width: 100%;
    margin-top: 10px;
}

.input {
    margin-bottom: 10px;
}
.color {
    border: 1px $bg solid;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 20px;
}

@media (max-width: 600px) {
    .btn {
        width: 100%;
        margin-bottom: 20px;
    }
}

// .title {
//     text-align: center;
//     margin-bottom: 20px;
// }

.delete-modal {
    text-align: center;
}
.n-space {
    justify-content: center;
}
.delete-center {
    justify-content: center;
}
n-space {
    justify-content: center;
}
.delete-no {
    margin-right: 20px;
}
// .delete-buttons {
//     margin-top: 20px;
// }
.folder-name {
    margin-bottom: 20px;
}
.modal-title {
    text-align: center;
    margin-bottom: 20px;
    font-size: 20px;
}
.red {
    color: $red;
    margin-bottom: 20px;
}
.title-span {
    padding: 4px 8px;
    background-color: $active;
    color: $white;
    font-size: 12px;
    border-radius: 5px;
}

.folder-description {
    margin-bottom: 20px;
}
.msg {
    width: 50%;
    margin: 0 auto;
    padding-top: 50px;
}

</style>