<template>
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


    <div class="page">
        <div class="flex color">
        <div>
            <n-breadcrumb>
                <n-breadcrumb-item @click="$router.push(`/my-bucket-list-folders`)">Bucket List</n-breadcrumb-item>
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

    <div>
        <h1 class="title">{{ folder_name }}</h1>   
        <p v-if="folder_description">{{ folder_description }}</p>
    </div>

    <n-tabs type="segment">
        <n-tab-pane name="f1" tab="Хочу ">
            <WantBucketList />
        </n-tab-pane>
        <n-tab-pane name="2" tab="Исполнено">
            <DoneBucketList />
        </n-tab-pane>
        <n-tab-pane name="з" tab="Все">
            <AllBucketListFolder />
        </n-tab-pane>
    </n-tabs>

    

   
    
        
       
        <!-- <div class="items" v-if="wishes.length">
            <div class="item" v-for="(wish,index) in wishes" :key="index">
                <div class="box" @click="$router.push(`/my-bucket-list-item/${wish.id}`)">
                    <div class="box-inner">
                        <span v-if="wish.price" class="span">{{ wish.price }}</span>
                        <img :src="'/img/' + wish.photo" alt="">
                    </div>
                </div>
                <p class="item-name">{{ wish.name }}</p>
            </div>
        </div>
        <div v-else>
            <p>пока ничего нет</p>
        </div> -->

        <!-- <div class="flex rrrr">
            <div class="select">
                <p class="ddddd">Количество желаний: {{ wishes.length }}</p> 
            </div>
            <div>
                <p class="ddddd">Кол-во исполненных желаний: {{ done_count  }}</p>
            </div>
        </div>

        <div class="progress">
            <p>Исполнено: {{ done_count  }} / {{ wishes.length }}</p>
            <n-space vertical>
                <n-progress
                type="line"
                :percentage="getPercent()"
                :indicator-placement="'inside'"
                :border-radius="4"
                />
            </n-space>
        </div> -->
        

        <!-- <div class="flex">
            <div class="select" v-if="wishes.length">
                <n-space vertical>
                    <n-select v-model:value="selectedSort" :options="options" />
                </n-space>
            </div>
            <div class="div-button">
                <n-button @click="showModal=true" class="btn" strong secondary type="success">+ Добавить желание</n-button>
            </div>
        </div>
        
        
        <div v-if="wishes.length">
            <my-input
            v-model="searchQuery"
            />
        </div> -->
       

        <!-- <bucket-list-component
        :wishes="sortedAndSearchedPosts"
        /> -->

        


       

         <!-- Edit User Model -->
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
                    <div class="add-box edit-modal">
                        <h5 class="modal-title">Редактирование папки</h5>

                        <form method="post">

                            <label>Название папки</label>
                            <n-input v-model:value="currentFolder.name" type="text" placeholder="Название" class="name-folder-input" />

                            <label>Описание папки</label>
                            <n-input v-model:value="currentFolder.description" type="textarea" :autosize="{minRows: 3}" placeholder="Описание" class="description-folder-input" />

                            <n-button strong secondary type="success" attr-type="submit" @click="showEditModal=false; updateFolder(); activate('top'); reload_interval(2000);" class="edit-btn">Обновить</n-button>

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
                            <n-button strong secondary type="error" @click="showDeleteModal=false; deleteFolder(2000); activate('top'); clearMsg();" >
                                Да
                            </n-button>
                       </div>
                   </div>
                   
                   
                   </n-card>
               </n-modal>
           </div>
       </div>
    </div>
</template>

<script>
import axios from 'axios';
import { defineComponent, ref } from "vue";

import { NTabs, NTabPane } from 'naive-ui';
import {  NModal, NCard } from 'naive-ui';
import { NButton } from 'naive-ui';
import { NInput } from 'naive-ui';

import { NBreadcrumb, NBreadcrumbItem} from 'naive-ui';
// import { NSpace, NSelect } from 'naive-ui';
// import { NInput, NInputNumber, NUpload } from 'naive-ui';
// import { NProgress} from 'naive-ui';



// import BucketListComponent from '@/components/wishes/BucketListComponent.vue';
// import MyInput from '@/components/layout/MyInput.vue';
// import MySelect from '@/components/layout/MySelect.vue';
// import AllBucketListView from '@/views/bucket-list/AllBucketListView.vue'


import WantBucketList from '@/views/bucket-list/WantBucketList.vue';
import AllBucketListFolder from '@/views/bucket-list/AllBucketListFolder.vue';
import DoneBucketList from '@/views/bucket-list/DoneBucketListView.vue';

import MsgComponent from '@/components/layout/MsgComponent.vue'
import { NDrawer, NDrawerContent }  from 'naive-ui';




export default defineComponent ({
    name: 'BucketList',
    components: { 
        // BucketListComponent,
        // MySelect,
        // MyInput,
        NModal,
        NCard,
        NButton,
        NBreadcrumb,
        NBreadcrumbItem,
        // NSpace,
        // NSelect,
        NInput,
        // NInputNumber,
        // NProgress,
        NTabs, 
        NTabPane,
        AllBucketListFolder,
        WantBucketList,
        DoneBucketList,
        MsgComponent,
        NDrawer, 
        NDrawerContent
       
    },
    data() {
        return {
            wishes:[],
            done_count: [],
            
            nameStr: "",
            newWish: {
                name: "", 
                price: "",
                description: "",
                photo: '',
                link: "",
                visible: "",
                folder_id: "",
                done: ""
            },
            showEditModal: false,
            showDeleteModal: false,
            errorMsg: "",
            successMsg: "",
            // visible: [
            //     {status: 'вижу только я'},
            //     {status: 'идят все пользователи'},
            // ],
            url: "my-bucket-list",
            selectedSort: '',
            searchQuery: '',
            // sortOptions: [
            //     {value: 'name', name: 'По name'},
            //     {value: 'date', name: 'По date'},
            //     {value: 'price', name: 'По price'},
            //     {value: 'visible', name: 'По visible'},
            // ],
            folder_name: "",
            folder_description: "",
            data: '',
            currentFolder: {
                name: "",
                description: ""
            },
            
           
        }
    },
    methods: {
        async getBucketList() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-bucketlist&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes; 
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async getDoneBucketList() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-done-bucketlist-for-folder&id='+id)
            .then((response)=>{
                this.done_count = response.data.count; 
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async getFolder() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=bucketlist-folder&id='+id)
            .then((response)=>{
                this.folders = response.data.folders;

                this.folder_name = response.data.folders[0].name;
                this.folder_description = response.data.folders[0].description;
                this.currentFolder = response.data.folders[0];
            });

        },
        async addBucketList(){
            let id = this.$route.params.id;
            let formData = this.toFormData(this.newWish);

            await axios.post("http://localhost:8085/public/process.php?action=add-bucketlist-to-folder&id="+id, formData)
            .then((response)=>{
                this.newWish = {name: "", price: "", description: "", photo: "", link: "", visible: "", folder_id: "", done: 0};
                
                if (response.data.error) {
                    // this.errorMsg = response.data.message;
                } else {
                    console.log(this.newWish)
                    this.successMsg = response.data.message;
                    // this.$router.push('/'); 
                    // location.reload();   
                    this.getBucketList();
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
        async updateFolder(){
            
            
            let formData = this.toFormData(this.currentFolder);

            axios.post("http://localhost:8085/public/process.php?action=update-bucketlist-folder", formData)
            .then((response)=>{
                this.currenFolder = {};
                if(response.data.error){
                    this.errorMsg = response.data.message;
                } else {
                    this.successMsg = response.data.message;
                }
            });
        },
        
        deleteFolder(time){
            let id = this.$route.params.id;
            

          axios.post("http://localhost:8085/public/process.php?action=delete-bucketlist-folder&id="+id)
          .then((response)=>{
              this.Folder = {};
              if (response.data.error){
                  this.errorMsg = response.data.message;
              } else {
                  this.successMsg = response.data.message;
                //   this.$router.push('/my-bucket-list-folders'); 

                let self = this
                setTimeout(function(){
                    self.$router.push(`/my-bucket-list-folders`);
                }, time)
              }
          });
        },
        selectFolder(folder){
          this.currentWish = folder;
        },
        reload_interval(time){
            setTimeout(function(){
                location.reload();
            }, time);
        },
        getPercent() {          
            this.percent = Math.round(this.done_count/this.wishes.length * 100);

            console.log(this.percent);
            return this.percent
        }
    },
    mounted() {
        this.getBucketList()
        this.getFolder()
        this.getDoneBucketList() 
        this.getPercent()
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
            // percentage: percentageRef,
            active,
            placement,
            activate,
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
                label: "видят все пользователи",
                value: "2"
                },
                {
                label: "вижу только я",
                value: "1",
                },
            ],
            done: [
                {
                    label: "Хочу",
                    value: 0,
                },
                {
                    label: "Done",
                    value: 1,
                }
            ]
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
    border: 1px solid #ccc;
    cursor: pointer;
    img {
        // height: 210px;
        width: 100%;
        height: 100%;
        
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
    margin-top: 20px;
}
.item {
   width: 49%;
   margin-bottom: 10px;
}
.button {
    @include button;
}
.select {
    margin-bottom: 10px;
}
.page {
    @include page;
}
.color {
    border: 1px $bg solid;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 20px;
}
.edit {
    margin-right: 10px;
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
.btn {
    width: 100%;
    margin-top: 30px;
    margin-bottom: 30px;
}
.progress {
    margin-top: 20px;
    margin-bottom: 40px;
}
.bottom {
    margin-top: 10px;
}
.div-button {
    flex-basis: 49%;
}
// .title {
//     text-align: center;
// }

.add-box {
   width: 50%;
   margin: auto;
}
.modal-title {
    text-align: center;
    margin-bottom: 20px;
    font-size: 20px;
}
.delete-modal {
    text-align: center;
}
.delete-no {
    margin-right: 20px;
}
.red {
    color: $red;
    margin-bottom: 20px;
}
.msg {
    width: 50%;
    margin: 0 auto;
    padding-top: 50px;
}
.name-folder-input {
    margin-bottom: 20px;
}
.description-folder-input {
    margin-bottom: 20px;
}
.edit-btn {
    width: 100%;
}

</style>





