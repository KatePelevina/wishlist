<template>
    <div>
        <msg-component
        :errorMsg="this.errorMsg"
        :successMsg="this.successMsg"
        />
        
        <n-breadcrumb>
            <!-- <n-breadcrumb-item @click="$router.push(`/my-wish-list-folders`)">Wish List</n-breadcrumb-item> -->
            <n-breadcrumb-item>Идеи для Wish List</n-breadcrumb-item>
            <n-breadcrumb-item></n-breadcrumb-item>
        </n-breadcrumb>
        
        <div class="card" v-for="(wish,index) in wishes" :key="index">
            <div class="card-body">
                <h3 class="card-title">{{ wish.name }}</h3>
                <div class="card-body__header">
                    <div class="card-body__image">
                        <!-- <img class="card-body__img" src="@/assets/bag.webp" alt=""> -->
                        <img :src="'/img/' + wish.photo" alt="" class="card-body__img">
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

                        <button class="btn" @click="showModal=true; selectWish(wish);">+ Добавить в свой Wish List</button>
                    </div>
                    
                    
                </div>
            </div>
        </div>

          <!--  User Model -->
          <div v-if="showModal">
            <div class="modal">
                <n-button @click="showModal = true">
                    Start Me up
                </n-button>
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
                        <input type="text" name="name"  placeholder="Название" v-model="currentWish.name">
                        <input type="text" name="name"  placeholder="Цена" v-model="currentWish.price">
                        <input type="text" name="name"  placeholder="Описание" v-model="currentWish.description">
                        <input type="text" name="name"  placeholder="Ссылка" v-model="currentWish.link">

                        <select name="folder_id" id="folder_id" v-model="currentWish.folder_id">
                            <option disabled selected value="">Сохранить в папку</option>
                            <option v-for="(folder,index) in folders" :key="index" :value="folder.id">{{ folder.name }}</option> 
                        </select>

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
import {  NModal, NCard, NButton } from 'naive-ui'
import MsgComponent from '@/components/layout/MsgComponent.vue'
import { NBreadcrumb, NBreadcrumbItem} from 'naive-ui';


export default {
    name: 'IdeaWishlistItem',
    components: { 
        NModal,
        NCard,
        NButton,
        MsgComponent,
        NBreadcrumb,
        NBreadcrumbItem
    },
    data(){
        return {
            wishes: [],
            currentWish: {},
            showModal: false,
            errorMsg: "",
            successMsg: "",
            present: "",
            statusNo: "",
            statusYes: "",
            presents: []
        }
    },
    // components: {
    //   NModal,
    //   NButton,
    //   NCard,
    // },
    methods: {
        async getWish() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=test&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes;
                console.log(this.wishes);
            })
        },
        selectWish(wish){
          this.currentWish = wish;
        },
        addToMyWishList(){
          let formData = this.toFormData(this.currentWish);

          axios.post("http://localhost:8085/public/process.php?action=add-to-my-wishlist", formData)
          .then((response)=>{
            
              this.currentWish = {};
              if(response.data.error){
                this.errorMsg = response.data.message;
              }else {
                
                this.successMsg = response.data.message;
                // location.reload(); 
                
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
            .then((response)=>{
                
                this.folders = response.data.folders; 
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async iWillPresent() {
            let formData = this.toFormData(this.currentWish);

            axios.post('http://localhost:8085/public/process.php?action=add-to-i-will-present', formData )

            .then((response)=>{
            
                this.currentWish = {};
                
                if(response.data.error){
                    this.errorMsg = response.data.message;
                }else {
                    
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
                    this.successMsg = response.data.message;
                    this.presents = response.data.presents; 
                    this.statusYes =  response.data.statusYes;
                    this.statusNo =  response.data.statusNo; 

                    console.log(this.presents);
                    console.log(this.statusYes);
                    console.log(this.statusNo);
                }
            });
        }
    },
    mounted() {
        this.getWish()
        this.getFolders()
        this.test()
    }

}

</script>


<style lang="scss" scoped>
@import "@/styles/_variables.scss";

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

.card {
    background-color: #fff;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
    cursor: pointer;
   
}
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

</style>