<template>
    <div class="page">

        <msg-component
        :errorMsg="this.errorMsg"
        :successMsg="this.successMsg"
        />
        
        <div class="card" v-for="(user,index) in users" :key="index">
            <div v-for="(wish,index) in wishes" :key="index">
                
                <div class="color">
                    <n-breadcrumb>
                        <n-breadcrumb-item @click="$router.push(`/ideas-wish-list`)">Идеи для Wish List</n-breadcrumb-item>
                        <n-breadcrumb-item>Желание</n-breadcrumb-item>
                    </n-breadcrumb>
                </div>
                
                <div>
                    
                    <div>


                        <div class="flex">
                            <h1 class="card-title">{{ wish.name }}</h1>
                            <div v-if="wish.photo">
                                <n-button @click="selectWish(wish); showPhoto=true;">
                                    <template #icon>
                                        <n-icon>
                                            <search-img />
                                        </n-icon>
                                    </template>
                                </n-button>
                            </div>
                        </div>
                       

                        <div class="flex-left">
                            <div v-if="wish.price" class="flex-left">
                                <n-space v-if=" wish.price" class="price">
                                    <n-tag type="success" size="large">
                                        <div class="flex-left align-items-center">
                                            <n-icon :component="CashOutline" size="25" :depth="1" class="cash-icon" />
                                            <p class="card-price">Цена: {{ wish.price }} рублей</p>
                                        </div>
                                    </n-tag>
                                </n-space>
                            </div>
                            <div v-if="wish.link" class="card-link">
                                <n-space>
                                    <n-tag type="success" size="large">
                                        <a :href="wish.link" class="link">Ссылка</a>
                                    </n-tag>
                                </n-space>
                            </div>
                        </div>

                        
                        
                        
                    </div>

                    <div class="card-body__body">
                        <div class="card-body__content">

                            <div class="div-img">

                                <div v-if="wish.photo">
                                    <img :src="'/img/' + wish.photo" alt="" class="wish-img" @click="selectWish(wish); showAddPhotoModal=true;" >
                                </div>

                                <div v-else>
                                    <n-empty @click="selectWish(wish); showAddPhotoModal=true;" size="large" description="Нет фото" class="empty"></n-empty>
                                </div>

                            </div> 

                            <div class="flex-left user-info" @click="$router.push(`/user-wish-list/user=${wish.id}`)">
                                <img :src="'/img/' + wish.img" alt="" class="user-avatar" >
                                <p>{{ wish.firstName }} {{ wish.secondName }} | {{ wish.nickname }} хочет</p>
                            </div>

                            
                            <p class="card-description">{{ wish.description }}</p>
                        
                                

                            <p v-if="statusYes">Статус: {{ statusYes }}</p>
                            <p v-if="statusNo">Статус: {{ statusNo }}</p>

                            <div class="div-flex">                                
                                <div class="flex-item">
                                    <n-popover trigger="hover">
                                        <template #trigger>
                                            <button v-if="statusYes" class="btn btn-left disabled">Подарить</button>
                                            <button v-if="statusNo" class="btn"  @click="selectUser(user); addToIWillPresent()">Подарить</button>
                                        </template>
                                    <span v-if="statusYes">Это желание уже забронировано</span>
                                    <span v-if="statusNo">Забронировать этот подарок</span>

                                </n-popover>
                                
                                </div>

                                <div class="flex-item">
                                    <button class="btn" @click="showModal=true; selectWish(wish); openForm();">+ Добавить в свой Wish List</button>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                </div>

            </div>
        </div>

          
        <div v-if="showModal">
            <div class="modal">
                <n-modal v-model:show="showModal">
                    <n-card
                        style="width: 600px"
                        
                        :bordered="false"
                        size="huge"
                        role="dialog"
                        aria-modal="true"
                    >
                    <div class="modal-form">
                        <h5 class="modal-title">Добавить желание в мой WISHLIST</h5>

                        <form method="post">
                            <label>Название*</label>
                            <n-input v-model:value="currentWish.name" type="text" placeholder="Название" class="my-n-input"/>

                            <!-- <label>Фото</label>
                            <n-input v-model:value="currentWish.photo" type="text" placeholder="Фото" class="my-n-input"/> -->

                            <label>Цена</label>
                            <n-input-number  v-model:value="currentWish.price" type="text" placeholder="Цена" class="my-n-input"/>

                            <label>Описание</label>
                            <n-input v-model:value="currentWish.description" type="text" placeholder="Описание" class="my-n-input"/>

                            <label>Ссылка</label>
                            <label></label>
                            <n-input v-model:value="currentWish.link" type="text" placeholder="Ссылка" class="my-n-input"/>

                            <label>Кто видит желание*</label>
                            <n-space vertical class="select">
                                <n-select v-model:value="currentWish.visible" :options="visible" />
                            </n-space>

                            <label>Папка*</label>
                            <n-space vertical class="select">
                                <n-select  v-model:value="currentWish.my_folder_id" :options="folderSelector"/>
                            </n-space>

                            <n-button type="primary"  @click="showModal=false; addToMyWishList();" class="button">Добавить в свой Wish List</n-button>
                        </form>
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

import {  NModal, NCard } from 'naive-ui'
import MsgComponent from '@/components/layout/MsgComponent.vue'
import { NBreadcrumb, NBreadcrumbItem } from 'naive-ui';
import { NEmpty } from 'naive-ui';
import { NInput, NInputNumber  } from 'naive-ui';
import { NSpace, NSelect } from 'naive-ui';
import { NButton } from 'naive-ui';

import { NIcon } from "naive-ui";

import { SearchSharp as SearchImg } from "@vicons/ionicons5";
import { CashOutline } from "@vicons/ionicons5";

import { NPopover } from "naive-ui";

import {  NTag } from 'naive-ui';



export default defineComponent({
    name: 'IdeaWishlistItem',
    components: { 
        NModal,
        NCard,
        MsgComponent,
        NBreadcrumb,
        NBreadcrumbItem,
        NEmpty,
        NInput, 
        NInputNumber,
        NSpace,
        NSelect,
        NIcon,
        SearchImg,
        NButton,
        NPopover,
        NTag
        
    },
    data(){
        return {
            wishes: [],
            users: [],
            currentWish: {
                // name: '',
                // price: '',
                // description: '',
                // photo: " ",
                // link: '',
                // visible: '',
                // my_folder_id: '',

            },
            showModal: false,
            errorMsg: "",
            successMsg: "",
            present: "",
            statusNo: "",
            statusYes: "",
            presents: [],
            folders: []
            
        }
    },
    methods: {
        async getUser() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-user-by-wish&id='+id)
            .then((response)=>{
                this.users = response.data.users;
                // console.log(this.users);
            })
        },
        async getWish() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=test&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes;
            })
        },
        selectWish(wish){
          this.currentWish = wish;
        },
        async addToMyWishList() {
           
           let formData = this.toFormData(this.currentWish);

           await axios.post('http://localhost:8085/public/process.php?action=add-userwish-to-my-wishlist', formData)

           .then((response)=>{
               this.currentWish = {name: "", price: "", description: "", photo: "", link: "", visible: "", folder_id: "", done: "", wish_list: "", bucket_list: "" };
               if(response.data.error){
                   this.errorMsg = response.data.message;
               } else {
                   this.successMsg = response.data.message;
                //    this.$router.reload();
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
        async getFolders() {
          await axios.get('http://localhost:8085/public/process.php?action=get-wishlist-folders')
            .then(response => {
                this.folders = response.data.folders; 
            })
            .catch(error => {
                console.log(error);
            });
        },
        async addToIWillPresent() {
          
          let id = this.$route.params.id;
          let formData = this.toFormData(this.currentUser);


       
          // let iserId = this.$user.id;
          // let friend = currentUser;
         

          await axios.post('http://localhost:8085/public/process.php?action=add-to-i-will-present&id=' + id, formData )

          .then((response)=>{
              if(response.data.error){
                  this.errorMsg = response.data.message;
              } else {
                  this.successMsg = response.data.message;
              }
          });
      },
        selectUser(user) {
            this.currentUser = user;
        },
        test() {
            let id = this.$route.params.id;
            axios.post('http://localhost:8085/public/process.php?action=get-presents&id='+id)

            .then((response)=>{
            
                if(response.data.error){
                    this.errorMsg = response.data.message;
                } else {
                    this.presents =response.data.presents;
                    console.log(this.presents);
                    this.successMsg = response.data.message;
                    this.presents = response.data.presents; 
                    this.statusYes =  response.data.statusYes;
                    this.statusNo =  response.data.statusNo; 

                    console.log(this.presents);
                    console.log(this.statusYes);
                    console.log(this.statusNo);
                }
            });
        },
        openForm() {
          this.folders.forEach(element => {
            this.folderSelector.push({
              label: element.name,
              value: element.id,
            });
          });
        }
    },
    mounted() {
        this.getWish()
        this.getFolders()
        this.test()
        this.openForm()
        this.getUser() 
    },
    setup() {
        return {
            value: ref(null),
            CashOutline,
            visible: [
                {
                    label: "Кто видит желание",
                    value: "",
                    disabled: true
                },
                {
                    label: "вижу только я",
                    value: "0",
                },
                {
                    label: "видят все пользователи",
                    value: "1"
                }
            ],
            folderSelector: [
                {
                  label: "Добавить в папку",
                  value: "",
                  disabled: true
                }
            ]
        };
    }

})

</script>


<style lang="scss" scoped>

@import "@/styles/_variables.scss";

.page {
    @include page;
}
.btn {
    border: 1px solid $active;
    background-color: $white;
    color: $active;
    font-weight: bold;
    border-radius: $border-radius;
    padding: 15px;
    width: 100%;
    cursor: pointer;
}
// .btn-left {
//     margin-bottom: 20px;
// }

.disabled {
    background-color: #ccc;
    cursor: not-allowed;
    border: none;
    color: #787878;
}

.empty {
    border: 1px #ccc solid;
    // border-radius: 10px;
    border-radius: 5px;
    padding: 80px;
    margin-bottom: 20px;
}

.wish-img {
    border-radius: 10px;
    width: 100%; 
}
.div-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.flex-item {
    width: 49%;
}
.wish-img {
    border: 1px solid #ebebeb;
    // padding: 10px;
    border-radius: 10px;
    width: 100%; 
    height: 400px;   
    // object-fit: contain;
    object-fit: cover;
    // object-fit: fill;
    // object-fit: scale-down;
}
.header {
    margin-bottom: 20px;
}
.color {
    border: 1px $bg solid;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 20px;
}
.user-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-right: 10px;

}
.flex-left {
    display: flex;
    justify-content: start;
    align-items: center;
}
.user-info {
    cursor: pointer;
    // display: flex;
    // justify-content: start;
    // align-items: center;
}
.cash-icon {
    margin-right: 10px;
}
.align-items-center {
    align-items: center;
}
.modal-form {
    max-width: 50%;
    margin: 0 auto;
    // text-align: center;
}
.my-n-input {
    margin-bottom: 10px;
}
.select {
    margin-bottom: 20px;
}
.button {
    width: 100%;
}
.modal-title {
    text-align: center;
    margin-bottom: 20px;
    font-size: 20px;
}

</style>