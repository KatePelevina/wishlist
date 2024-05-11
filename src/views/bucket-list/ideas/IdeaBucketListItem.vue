<template>
    <div class="page">
        <div>
            <n-breadcrumb>
                <n-breadcrumb-item @click="$router.push(`/ideas-bucket-list`)">Идеи для Bucket List / </n-breadcrumb-item>
            </n-breadcrumb>
        </div>

        <div v-for="(wish,index) in wishes" :key="index">
            <div class="card-body">
                <h3 class="card-title">{{ wish.name }}</h3>
                <div class="card-body__header">
                    <div class="card-body__image">
                        <img :src="'/img/' + wish.photo" alt="" class="card-body__img">
                    </div>
                    <div class="card-body__text">
                        <p>@EkaterinaFilatova1993 хочет</p>
                        <p class="card-price">{{ wish.price }} руб</p>
                    </div>
                </div>
                <div class="card-body__content">
                    <p class="card-description">{{ wish.description }}</p>
                    <div class="card-link">
                        <a :href="wish.link" class="link">Ссылка</a>
                    </div>
                    <div class="flex">
                        <button class="button">Я подарю</button>
                        <button class="btn" @click="showModal=true; selectWish(wish); openForm()">+ Добавить в свой Bucket List</button>
                    </div>
                </div>
            </div>
        </div>

        <!--  Add to my WishList Model -->
        <div v-if="showModal">
            <div class="modal">
                <n-modal v-model:show="showModal">
                    <n-card
                    style="width: 600px"
                    title="Modal"
                    :bordered="false"
                    size="huge"
                    role="dialog"
                    aria-modal="true"
                    >
                    
                    <form method="post">
                        <!-- <input type="text" name="name"  placeholder="Название" v-model="currentWish.name"> -->
                        <n-input v-model:value="currentWish.name" type="text" placeholder="Название"/>

                        <!-- <input type="text" name="name"  placeholder="Цена" v-model="currentWish.price"> -->
                        <n-input-number  v-model:value="currentWish.price" type="text" placeholder="Цена"/>


                        <!-- <input type="text" name="name"  placeholder="Описание" v-model="currentWish.description"> -->
                        <n-input v-model:value="currentWish.description" type="text" placeholder="Описание"/>


                        <!-- <input type="text" name="name"  placeholder="Ссылка" v-model="currentWish.link"> -->
                        <n-input v-model:value="currentWish.link" type="text" placeholder="Ссылка"/>


                        <!-- <select name="folder_id" id="folder_id" v-model="currentWish.folder_id">
                            <option disabled selected value="">Сохранить в папку</option>
                            <option v-for="(folder,index) in folders" :key="index" :value="folder.id">{{ folder.name }}</option> 
                        </select> -->

                        <n-space vertical class="select">
                            <n-select  v-model:value="currentWish.my_folder_id" :options="folderSelector"/>
                        </n-space>

                        <button  @click="showModal=false; addToMyBucketList();" class="button">Добавить в свой Bucket List</button>
                    </form>
                    
                    
                    </n-card>
                </n-modal>
            </div>
        </div>

    </div>
</template>

<script>

import axios from 'axios';
import { NBreadcrumb, NBreadcrumbItem  } from 'naive-ui';
import {  NModal, NCard } from 'naive-ui'
import { defineComponent, ref } from "vue";
import { NInput, NInputNumber,  NSpace, NSelect  } from 'naive-ui';



export default defineComponent({
    name: 'IdeaWishlistItem',
    components: {
        NBreadcrumb, 
        NBreadcrumbItem,
        NModal, 
        NCard,
        NInput, 
        NInputNumber,  
        NSpace, 
        NSelect 
    },
    data(){
        return {
            wishes: [],
            currentWish: {
                my_folder_id: ""
            },
            showModal: false,
            folders: [],
        }
    },
    methods: {
        async getWish() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-bucketlist-item&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes;
                console.log(response.data.wishes);
            })
        },
        async addToMyBucketList() {
           
           let formData = this.toFormData(this.currentWish);
           console.log(this.currentWish);

           await axios.post('http://localhost:8085/public/process.php?action=add-userwish-to-my-bucketlist', formData)

           .then((response)=>{
               this.currentWish = {};
               if(response.data.error){
                   this.errorMsg = response.data.message;
               }else {
                   this.successMsg = response.data.message;
               }
               });
        },
        selectWish(wish){
          this.currentWish = wish;
        },
        async getFolders() {
            await axios.get('http://localhost:8085/public/process.php?action=get-bucketlist-folders')
            .then((response)=>{
                
                this.folders = response.data.folders; 
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        toFormData(obj){
            let fd = new FormData();
            for(let i in obj){
                fd.append(i,obj[i]);
            }
            return fd;
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
</style>