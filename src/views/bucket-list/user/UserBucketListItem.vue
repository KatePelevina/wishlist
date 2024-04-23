<template>
    <div class="page">
        
        <!-- <div class="card" v-for="(wish,index) in wishes" :key="index">

            <p class="card-title">{{ wish.name }}</p>

            <div class="card-body flex">
                <div class="card-body__left">
                    <img :src="'/img/' + wish.photo" alt="" class="card-body__right-img">
                </div>
                <div class="card-body__right">
                    <p class="card-text">Дата создания: {{wish.date}}</p>
                    <p class="card-text">{{ wish.price }}</p>
                </div>
            </div>
            <p class="card-description">{{ wish.description }}</p>
            <div class="card-link">
                <a :href="wish.link" class="link">Ссылка</a>
            </div>
            <div class="flex">
                <button class="button">Я подарю</button>
                <button class="btn" @click="showModal=true; selectWish(wish);">+ Добавить в свой Bucket List</button>
            </div>
        </div> -->

        <div class="card" v-for="(user,index) in users" :key="index">
            <img class="photo" :src="'/img/' + user.img" />
            <p>{{ user.nickname }}</p>
            <button @click="$router.push(`/user-wish-list/user=${ user.id }`)">Перейти в профиль</button>

            <div  v-for="(wish,index) in wishes" :key="index">
                <p class="card-title">{{ wish.name }}</p>
                <div class="card-body">
                    <div class="div-img">
                        <img v-if="wish.photo"  :src="'/img/' + wish.photo" alt="" class="wish-img" @click="showPhoto=true; selectWish(wish);" >
                        <n-empty v-else size="large" description="Нет фото" class="empty"></n-empty>
                    </div>  
                    <div class="card-body__right">
                        <!-- <p class="card-text">Дата создания: {{wish.date}}</p> -->
                        <p v-if="wish.price" class="card-text">{{ wish.price }}</p>
                    </div>
                </div>
                <p class="card-description">{{ wish.description }}</p>
                <div class="card-link" v-if="wish.link">
                    <a :href="wish.link" class="link">Ссылка</a>
                </div>
                <div class="flex">
                    <button class="button" @click="selectUser(user); addToIWillPresent();">Я подарю</button>
                    <button class="btn" @click="showModal=true; selectWish(wish); openForm()">+ Добавить в свой Wish List</button>

                </div>

                <!-- <button @click="showForm=true">Скинуться</button> -->

            </div>

          

            

        </div>


        <!-- Add to my wishlist -->
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
                
                <form method="post"  @submit.prevent="addToMyWishList">
                    <input type="text" name="name"  placeholder="Название" v-model="currentWish.name">
                    <input type="text" name="price"  placeholder="Цена" v-model="currentWish.price">
                    <input type="text" name="description" placeholder="Описание" v-model="currentWish.description">

                    <n-upload 
        
                        action="http://localhost:8085/public/process.php?action=add-userwish-to-my-wishlist"
                        
                        accept= ".png, .jpg, .jpeg, .webp, .HEIC"
                        
                    >
                        <n-button>Загрузить фото</n-button>
                    </n-upload>

                    <n-space vertical class="select">
                        <n-select  v-model:value="currentWish.my_folder_id" :options="folderSelector"/>
                    </n-space>
                    
                    <n-button  @click="showModal=false; addToMyWishList()" class="button">Добавить к себе</n-button>
                </form>
                
                
                </n-card>
            </n-modal>
        </div>
        </div>

        <!-- скинуться -->
        <div v-if="showForm">
            <div class="modal modal-inner">
                <n-modal v-model:show="showForm">
                    <n-card
                    style="width: 700px"
                    :bordered="false"
                    size="huge"
                    role="dialog"
                    aria-modal="true"
                    >
                    
                    
                    <div>
                        <p>скинуться</p>
                        <input type="text" placeholder="Сумма">
                        <button>скинуться</button>
                    </div>
                    
                    
                    </n-card>
                </n-modal>
            </div>
        </div>

        <!-- Edit User Model -->
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
                <input type="text" name="price"  placeholder="Цена" v-model="currentWish.price">
                <input type="text" name="description" placeholder="Описание" v-model="currentWish.description">
                
                <button  @click="showModal=false; addToMyWishList();" class="button">Добавить к себе</button>
            </form>
            
            
            </n-card>
        </n-modal>
        </div>
        </div>

    </div>
</template>

<script>

import axios from 'axios';
import { NModal, NButton, NCard} from 'naive-ui'
import { NEmpty } from 'naive-ui';


export default {
    name: 'UserBucketListItem',
    // props: ['id','name', 'description','photo'],
    data(){
        return {
            users: [],
            wishes: [],
            showModal: false,
            currentWish: {},
        }
    },
    components: {
      NModal,
      NButton,
      NCard,
      NEmpty
    },
    methods: {
        async getWish() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-user-bucketlist-item&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes;
            })
        },
        async addToMyWishList() {
            
            let formData = this.toFormData(this.currentWish);

            await axios.post('http://localhost:8085/public/process.php?action=add-userwish-to-my-wishlist', formData)

            .then((response)=>{
                this.currentWish = {};
                if(response.data.error){
                    this.errorMsg = response.data.message;
                }else {
                    this.successMsg = response.data.message;
                }
                });
        },
        // async getUser() {
        //     let id = this.$route.params.id;

        //     await axios.get('http://localhost:8085/public/process.php?action=get-user-by-bucket&id='+id)
        //     .then((response)=>{
        //         this.users = response.data.users;
        //         // console.log(this.users);
        //     })
        // },
        toFormData(obj){
          let fd = new FormData();
          for(let i in obj){
              fd.append(i,obj[i]);
          }
          return fd;
        },
        selectWish(wish) {
            this.currentWish = wish;
        },
    },
    mounted() {
        this.getWish()
        // this.getUser() 
    }

}

</script>



<style lang="scss" scoped>
@import "@/styles/_variables.scss";
.card {
       background-color: #fff;
       border-radius: 10px;
       
       padding: 15px;
       margin-bottom: 10px;
       cursor: pointer;
    //    &:hover {
    //        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
    //    }
}
// .card-body__left {
//     display: flex;
//     flex-direction: row;
// }

.card {
    background-color: #fff;
    border-radius: 10px;
   
    padding: 15px;
    margin-bottom: 10px;
    cursor: pointer;
    // &:hover {
    //     box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
    // }
}
// .card-header {
//     display: flex;
//     align-items: center;
//     justify-content: space-between;
// }
.card-header__left {
    display: flex;
    align-items: center;
}
.card-title {
    font-weight: bold;
    font-size: 24px;
    text-transform: uppercase;
//    line-height: 17px;
}

.card-text {
    font-size: 12px;
}
.flex {
    @include flex;
    align-items: start;
    p {
        margin-right: 10px;
    }
}

.card-body {
    margin-bottom: 20px;
}
.card-body__right {
//    background-color: #000;
    // width: 150px;
    // height: 150px;
    border-radius: 10px;
}
.card-body__right-img {
    
    border-radius: 10px;
    width: 100%;
}

.span {
    display: flex;
}







.hover {
    @include hover;
}
.modal {
    @include modal;
}

.card-body__left {
    width: 50%;
    margin-right: 20px;
}
.card-body__right {
    width: 50%;
}

.show {
    background-color: #F6F7FF;
    display: inline-block;
    border-radius: 10px;
    padding: 5px;
}


.card-description {
    margin-bottom: 10px;
    margin-top: 10px;
}
.card-link {
    margin-top: 20px;
}
.link:hover {
    color: $active;
}

.card-book {
    margin-top: 20px;
}
.bold {
    font-weight: bold;
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
.empty {
    border: 1px #ccc solid;
    // border-radius: 10px;
    border-radius: 5px;
    padding: 80px;
}

</style>