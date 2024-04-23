<template>
    
    <transition class="msg">
        <msg-component
        :errorMsg="this.errorMsg"
        :successMsg="this.successMsg"
        />
    </transition>
    
   <div>


    <!-- <div class="flex color">
        <div>
            <n-breadcrumb>
                <n-breadcrumb-item @click="$router.push(`/my-wish-list-folders`)">Wish List</n-breadcrumb-item>
                <n-breadcrumb-item>Папка</n-breadcrumb-item>
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
    </div> -->

    <!-- <div>
        <h1>{{ folder_name }}</h1>   
        <p v-if="folder_description">{{ folder_description }}</p>
    </div> -->

    <!-- <n-tabs type="segment">
        <n-tab-pane name="want" tab="Хочу">
            <wish-list-component
            :wishes="sortedAndSearchedPosts"
            />
        </n-tab-pane>
        <n-tab-pane name="done" tab="Иполнил(а)">
            <DoneWishListView />
        </n-tab-pane>
        <n-tab-pane name="all" tab="Все">
            <AllMyWishListView />
        </n-tab-pane>
    </n-tabs> -->

        
    
        <div class="flex">
            <p class="count">Количество желаний: {{ wishes.length }}</p>
            <n-button @click="showModal=true" class="btn" strong secondary type="success">+ Добавить желание</n-button>
        </div>
        


        <div class="select" v-if="wishes.length">
            <n-space vertical>
                <n-select v-model:value="selectedSort" :options="options" />
            </n-space>
        </div>

        <div v-if="wishes.length">
            <my-input
            v-model="searchQuery"
            />
        </div>

        
        <!-- <div class="flex rrrr"> -->
            <!-- <div class="select">
                <p>Количество желаний: {{ wishes.length }}</p>
            </div> -->
            <!-- <div class="div-button">
                <n-button @click="showModal=true" class="btn" strong secondary type="success">+ Добавить желание в папку</n-button>
            </div> -->
            <!-- <div class="select" v-if="wishes.length">
                <n-space vertical>
                    <n-select v-model:value="selectedSort" :options="options" />
                </n-space>
            </div> -->
        <!-- </div> -->

        <!-- <div class="select" v-if="wishes.length">
            <n-space vertical>
                <n-select v-model:value="selectedSort" :options="options" />
            </n-space>
        </div> -->
        
        
    

       <!-- <div class="items" v-if="wishes.length" >
           <div class="item" v-for="(wish,index) in wishes" :key="index">

               <div class="box" @click="$router.push(`/my-wish-list-item/${wish.id}`)">
                   <div class="box-inner">
                       <span v-if="wish.price" class="span">{{ wish.price }} руб</span>
                       <img :src="'/img/' + wish.photo" alt="">
                   </div>
               </div>
               <p class="box-inner__hover">{{ wish.name }}</p>
           </div>
       </div>

       <div v-else>
           <p>пока ничего нет</p>
       </div> -->

       

    
       <!-- <div class="flex options">
            <div class="select">
                <my-select
                v-model="selectedSort"
                :options="sortOptions" 
                />
            </div>
            <div class="div-button">
            <button class="button" @click="showModal=true" >Добавить желание</button>
            </div>  
       </div> -->

       <!-- <div class="flex rrrr">
            <div class="select">
                <n-space vertical>
                    <n-select v-model:value="selectedSort" :options="options" />
                </n-space>
            </div>
            <div class="div-button">
                <n-button @click="showModal=true" class="btn" strong secondary type="success">+ Добавить желание</n-button>
            </div>
        </div> -->


       
       <bucket-list-component
        :wishes="sortedAndSearchedPosts"
        />
       
       <div v-if="showModal">
           <n-modal v-model:show="showModal">
               <n-card
               style="width: 600px"
               
               :bordered="false"
               size="huge"
               role="dialog"
               aria-modal="true"
               >
               <div class="add-component__modal">
                   <div class="add-box">
                       <h4 class="add-box-title">Добавить желание в эту папку</h4>
                       <form class="form" method="post">
                           <n-input v-model:value="newWish.name" type="text" placeholder="Название" class="input" />
                           <n-input-number  v-model:value="newWish.price" type="text" placeholder="Цена"/>
                           <n-input v-model:value="newWish.description" type="text" placeholder="Описание" class="input"  />
                           <n-input v-model:value="newWish.link" type="text" placeholder="Ссылка" class="input" />

                            <n-space vertical class="select">
                                <n-select v-model:value="newWish.visible" :options="visible" />
                            </n-space>

                            <n-space vertical class="select">
                                <n-select v-model:value="newWish.done" :options="done" />
                            </n-space>

                            <!-- <n-upload 
            
                                action="http://localhost:8085/public/process.php?action=add-bucketlist-to-folder&id=id"
                                :data="{
                                    'id': 'folder_id'
                                }"
                                accept= ".png, .jpg, .jpeg, .webp, .HEIC"
                                
                            >
                                <n-button>Загрузить фото</n-button>
                        
                            </n-upload> -->

                           <!-- <button class="button" @click="showModal=false; addWishList(); clearMsg();">Добавить желание</button> -->
                           <n-button strong secondary type="success" attr-type="submit" class="add-btn" @click="showModal=false; addBucketList();">Добавить желание</n-button>
                       </form>
                   </div>
               </div>
               
               </n-card>
           </n-modal>
       </div> 


        <!-- Edit User Model -->
       <div v-if="showEditModal">
       <div class="modal">
           <n-button @click="showEditModal = true">
               Start Me up
           </n-button>
           <n-modal v-model:show="showEditModal">
               <n-card
               style="width: 600px"
               :bordered="false"
               size="huge"
               role="dialog"
               aria-modal="true"
               >
               <div class="add-box">
                    <form method="post" >
                        <!-- <input type="text" name="name"  placeholder="Название" v-model="currentFolder.name"> -->
                        <n-input v-model:value="currentFolder.name" type="text" placeholder="Название" class="input" />

                        <!-- <input type="text" name="description"  placeholder="Описание" v-model="currentFolder.description"> -->
                        <n-input v-model:value="currentFolder.description" type="textarea" :autosize="{minRows: 3}" placeholder="Описание" class="input" />


                        <!-- <button  @click="showEditModal=false; updateFolder(); reload_interval(1000);" class="button">Обновить</button> -->
                        <n-button strong secondary type="success" attr-type="submit" @click="showEditModal=false; updateFolder(); reload_interval(1000);" class="add-btn">Обновить</n-button>
                    </form>
                </div>
               
               </n-card>
           </n-modal>
       </div>
       </div>

       <!-- Delete User Model -->
       <div v-if="showDeleteModal">
           <div class="modal">
               <n-button @click="showDeleteModal = true">
                   Start Me up
               </n-button>
               <n-modal v-model:show="showDeleteModal">
                   <n-card
                   style="width: 600px"
                   :bordered="false"
                   size="huge"
                   role="dialog"
                   aria-modal="true"
                   >
                   
                   <div>
                       <h4>Удалить '{{ currentFolder.name }}'? </h4>
                       
                       <!-- <button @click="showDeleteModal=false; deleteFolder(); clearMsg();" class="red">Да</button>
                       &nbsp;&nbsp;&nbsp;&nbsp;
                       <button @click="showDeleteModal=false" class="green">Нет</button> -->

                       <n-space>
                        <n-button strong secondary type="success" @click="showDeleteModal=false" >
                            Нет
                        </n-button>
                        <n-button strong secondary type="error" @click="showDeleteModal=false; deleteFolder(); clearMsg();" >
                            Да
                        </n-button>
                    </n-space>
                   </div>
                   
                   
                   </n-card>
               </n-modal>
           </div>
       </div>


   
   </div>
</template>

<script>
import axios from 'axios';

import { NModal, NButton, NCard} from 'naive-ui';
import { NSpace, NSelect } from 'naive-ui';
import { NInput, NInputNumber,  } from 'naive-ui';
// import {  NUpload } from 'naive-ui';
// import { NTabs, NTabPane } from 'naive-ui';

// import { NTag } from 'naive-ui';
// import { NBreadcrumb, NBreadcrumbItem} from 'naive-ui';

import { defineComponent, ref } from "vue";

import MsgComponent from '@/components/layout/MsgComponent.vue'
import BucketListComponent from '@/components/wishes/BucketListComponent.vue';
import MyInput from '@/components/layout/MyInput.vue';
// import DoneWishListView from '@/views/wish-list/DoneWishListView.vue';
// import AllMyWishListView from '@/views/wish-list/AllWishListView.vue';
// import MySelect from '@/components/layout/MySelect.vue';




export default defineComponent ({
    name: 'WishList',
    components: { 
        BucketListComponent,
       NModal,
       NCard,
       NButton,
       MsgComponent,
       MyInput,
    //    MySelect,
    //    NBreadcrumb,
    //    NBreadcrumbItem,
       NSpace,
       NSelect,
       NInput,
       NInputNumber,
    //    NUpload
    //    NTabs, 
    //    NTabPane,
    //    DoneWishListView,
    //    AllMyWishListView
    //    NTag
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
               visible: "",
               folder_id: "",
               done: "",
               wish_list: '1',
               bucket_list: '0'
               
           },
            // errorMsg: "",
            // successMsg: "",
            showEditModal: false,
            showDeleteModal: false,
            // visible: {
            //         '1': 'вижу только я',
            //         '2': 'видят все пользователи',
            // },
            currentFolder: {
                name: "",
                description: ""
            },
            selectedSort: '',
            searchQuery: '',
            
            folder_name: '',
            folder_description: '',
            successMsg: '',
            errorMsg: '',
            folder_id: ''
       }
    },
    methods: {
        async getWishes(){
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-bucketlist&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes; 
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        //    async getFolder() {
        //        let id = this.$route.params.id;
        //        await axios.get('http://localhost:8085/public/process.php?action=wishlist-folder&id='+id)

        //        .then((response)=>{
                    
        //             this.folder_name = response.data.folder[0].name;
        //             this.folder_description = response.data.folder[0].description;
        //            console.log(response.data);
                
        //        })
        //        .catch((error)=>{
        //            console.log(error)
        //        })
        //    },
        async getFolder() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=wishlist-folder&id='+id)
            .then((response)=>{
                this.folders = response.data.folders;

                this.folder_name = response.data.folders[0].name;
                this.folder_description = response.data.folders[0].description;
                this.currentFolder = response.data.folders[0];
                this.folder_id = response.data.folders[0].id;

                console.log(this.folder_description);
            })
        },
        async addBucketList(){
            let id = this.$route.params.id;
            let formData = this.toFormData(this.newWish);
        

            axios.post('http://localhost:8085/public/process.php?action=add-bucketlist-to-folder&id='+id, formData)

            .then((response)=>{
                this.newWish = {name: "", price: "", description: "", photo: "", link: "", visible: "", folder_id: "", done: "", wish_list: "", bucket_list: "" };
                
                if (response.data.error) {
                    console.log(response.data);
                    // this.errorMsg = response.data.message;

                } else {
                    console.log(response.data);
                    // this.successMsg = response.data.message;
                    this.getWishes();              
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
        async updateFolder(){
            
            
            let formData = this.toFormData(this.currentFolder);

            axios.post("http://localhost:8085/public/process.php?action=update-wishlist-folder", formData)
            .then((response)=>{
                this.currenFolder = {};
                if(response.data.error){
                        console.log(response.data);
                    // this.errorMsg = response.data.message;
                } else {
                        console.log(response.data);
                    // this.successMsg = response.data.message;
                }
            });
        },
        reload_interval(time){
            setTimeout(function(){
                location.reload();
            }, time);
        },
        deleteFolder(){
        let id = this.$route.params.id;
        

            axios.post("http://localhost:8085/public/process.php?action=delete-wishlist-folder&id="+id)
            .then((response)=>{
                this.currentFolder = {};
                if(response.data.error){
                    this.errorMsg = response.data.message;
                    console.log(response.data);
                } else {
                    this.successMsg = response.data.message;
                    console.log(response.data);
                    this.$router.push('/my-wish-list-folders'); 
                }
            });
        },
        selectFolder(folder){
        this.currentWish = folder;
        },
    },
    mounted() {
       this.getWishes()
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
            ],
            visible: [
                {
                label: "Кто видит желание",
                value: "",
                disabled: true
                },
                {
                label: "вижу только я",
                value: "1",
                },
                {
                label: "видят все пользователи",
                value: "2"
                }
            ],
            done: [
                {
                label: "хочу",
                value: "0",
                },
                {
                label: "исполнено",
                value: "1"
                }
            ],
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
.count {
    text-align: center;
    background-color: $bg;
    padding: 5px;
    border-radius: 2px;
}
</style>