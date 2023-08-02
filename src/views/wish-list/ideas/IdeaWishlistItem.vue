<template>
    <div class="page">

        <msg-component
        :errorMsg="this.errorMsg"
        :successMsg="this.successMsg"
        />
        
        
        
        <div v-for="(wish,index) in wishes" :key="index">
            
            <n-breadcrumb>
                <n-breadcrumb-item @click="$router.push(`/ideas-wish-list`)">Идеи для Wish List</n-breadcrumb-item>
                <!-- <n-breadcrumb-item>{{ wish.name }}</n-breadcrumb-item> -->
                <n-breadcrumb-item>Желание</n-breadcrumb-item>
            </n-breadcrumb>


            <div class="card-body">
                <h3 class="card-title">{{ wish.name }}</h3>
                <div class="card-body__header">
                    <div class="card-body__image">
                        <img v-if="wish.photo"  :src="'/img/' + wish.photo" alt="" class="wish-img" @click="showPhoto=true; selectWish(wish);" >
                        <n-empty v-else size="large" description="Нет фото" class="empty"></n-empty>
                    </div>
                    <div class="card-body__text">
                        <p>{{ wish.nickname }} хочет</p>
                        <p>{{ wish.firstName }} {{ wish.secondName }}</p>
                       
                        <p v-if="wish.price" class="card-price">{{ wish.price }}</p>
                    </div>
                </div>
                <div class="card-body__body"></div>
                <div class="card-body__content">
                    <p class="card-description">{{ wish.description }}</p>
                    <div class="card-link">
                        <div v-if="wish.link">
                            <a :href="wish.link" class="link">Ссылка</a>
                        </div>
                    </div>
                    
                    <div class="flex">
                        <!-- <div v-if="this.statusNo"> -->
                            <button  v-if="this.statusNo" class="button" @click="selectWish(wish); iWillPresent();">Забронировать</button>
                        <!-- </div> -->
                        <!-- <div v-if="this.statusYes"> -->
                            <button  v-if="this.statusYes" class="button disabled" @click="selectWish(wish); iWillPresent();">Забронировано</button>
                        <!-- </div> -->

                        <button class="btn" @click="showModal=true; selectWish(wish); openForm();">+ Добавить в свой Wish List</button>
                    </div>
                    
                    
                </div>
            </div>
        </div>

          
          <div v-if="showModal">
            <div class="modal">
                <n-modal v-model:show="showModal">
                    <n-card
                    style="width: 600px"
                    title="title"
                    :bordered="false"
                    size="huge"
                    role="dialog"
                    aria-modal="true"
                    >
                    
                    <form method="post">
                        <!-- <input type="text" name="name"  placeholder="Название" v-model="currentWish.name"> -->
                        <n-input v-model:value="currentWish.name" type="text" placeholder="Название"/>
                        <n-input v-model:value="currentWish.photo" type="text" placeholder="Фото"/>


                        <!-- <input type="text" name="name"  placeholder="Цена" v-model="currentWish.price"> -->
                        <n-input-number  v-model:value="currentWish.price" type="text" placeholder="Цена"/>

                        <!-- <input type="text" name="name"  placeholder="Описание" v-model="currentWish.description"> -->
                        <n-input v-model:value="currentWish.description" type="text" placeholder="Описание"/>

                        <!-- <input type="text" name="name"  placeholder="Ссылка" v-model="currentWish.link"> -->
                        <n-input v-model:value="currentWish.link" type="text" placeholder="Ссылка"/>

                        <n-space vertical class="select">
                            <n-select v-model:value="currentWish.visible" :options="visible" />
                        </n-space>

                        <!-- <n-space vertical class="select">
                            <n-select v-model:value="currentWish.folders" :options="folders" />
                        </n-space> -->

                        <!-- <select name="folder_id" id="folder_id" v-model="currentWish.folder_id">
                            <option disabled selected value="">Сохранить в папку</option>
                            <option v-for="(folder,index) in folders" :key="index" :value="folder.id">{{ folder.name }}</option> 
                        </select> -->

                        <n-space vertical class="select">
                            <n-select  v-model:value="currentWish.my_folder_id" :options="folderSelector"/>
                        </n-space>

                        <button  @click="showModal=false; addToMyWishList();" class="button">Добавить в свой Wish List</button>
                    </form>
                    
                    
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
        NSelect 
    },
    data(){
        return {
            wishes: [],
            currentWish: {
                name: '',
                price: '',
                description: '',
                photo: " ",
                link: '',
                visible: '',
                my_folder_id: '',

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
               }else {
                   this.successMsg = response.data.message;
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
       
        async iWillPresent() {
            let formData = this.toFormData(this.currentWish);

            axios.post('http://localhost:8085/public/process.php?action=add-to-i-will-present', formData )

            .then((response)=>{
            
                this.currentWish = {};
                
                if(response.data.error){
                    this.errorMsg = response.data.message;
                } else {
                    location.reload(); 
                    // this.successMsg = response.data.message;
                }
            });
        },
        test() {
            let id = this.$route.params.id;
            axios.post('http://localhost:8085/public/process.php?action=get-presents&id='+id)

            .then((response)=>{
            
                if(response.data.error){
                    this.errorMsg = response.data.message;
                }else {
                    this.presents =response.data.presents;
                    console.log(this.presents);
                    this.successMsg = response.data.message;
                    this.presents = response.data.presents; 
                    this.statusYes =  response.data.statusYes;
                    this.statusNo =  response.data.statusNo; 

                    // console.log(this.presents);
                    // console.log(this.statusYes);
                    // console.log(this.statusNo);
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
    },
    setup() {
        return {
            value: ref(null),
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
.card-body__header {
    display: flex;
}
.card-body__image {
    width: 50%;
}
.card-body__img {
    width: 100%;
    border-radius: 10px;
}
.card-body__text {
    width: 50%;
}

// .card {
//     background-color: #fff;
//     border-radius: 10px;
//     padding: 15px;
//     margin-bottom: 20px;
//     cursor: pointer;
   
// }
.card-body__image {
    margin-right: 20px;
}

// .card-body__image  {
//     text-align: center;
//     margin-bottom: 20px;
// }
// .card-body__right-img {
//     display: block;
//     max-width: 100%;
//     height: auto;
//     border-radius: 10px;
    
// }
.card-price {
    margin-bottom: 20px;
}
.card-description {
    margin-bottom: 20px;
}
.card-link {
    margin-bottom: 20px;
}

.button {
    @include button;
    width: 49%;
    font-weight: bold;
}
.btn {
    border: 1px solid $active;
    background-color: $white;
    color: $active;
    font-weight: bold;
    border-radius: $border-radius;
    padding: 15px;
    width: 49%;
    cursor: pointer;
}

.disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

.empty {
    border: 1px #ccc solid;
    // border-radius: 10px;
    border-radius: 5px;
    padding: 80px;
}

.wish-img {
    border-radius: 10px;
    width: 100%; 
}
</style>