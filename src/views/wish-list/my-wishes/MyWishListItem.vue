<template>

    <msg-component
        :errorMsg="this.errorMsg"
        :successMsg="this.successMsg"
    />

    

    <div class="card" v-for="(wish,index) in wishes" :key="index">

        

        <div class="flex color">
            <div>
                <n-breadcrumb>
                    <n-breadcrumb-item @click="$router.push(`/my-wish-list-folders`)">Wish List</n-breadcrumb-item>
                    <n-breadcrumb-item @click="$router.push(`/my-wish-list/folder=${wish.folder_id}`)">{{ folder_name }}</n-breadcrumb-item>
                    <n-breadcrumb-item>Желание</n-breadcrumb-item>
                </n-breadcrumb>
            </div>
           
            <div class="card-header__right flex">
                <div @click="showEditModal=true; selectWish(wish);" class="icon icon-left">
                    <img src="@/assets/edit-1.svg" alt="">
                </div>
                <div @click="showDeleteModal=true; selectWish(wish);" class="icon">
                    <img src="@/assets/delete.svg" alt="">
                </div>
            </div>
        </div>

        <div >
            <h1 class="wish-name">{{ wish.name }}</h1>
        </div>
        

        

  
        <!-- <div class="flex options"> -->
            <!-- <div>
                <n-space class="margin">
                    <n-tag type="info">
                        Желание видят все пользователи
                    </n-tag>
                </n-space>
            </div> -->
            <!-- <div>
                <n-space>
                    <n-tag type="info">
                        Дата создания желания: {{wish.date}}
                    </n-tag>
                </n-space>
            </div> -->
        <!-- </div> -->


        


            
        <div class="card-body flex flex-img">
            <div class="div-img">
                <img v-if="wish.photo"  :src="'/img/' + wish.photo" alt="" class="wish-img" @click="showPhoto=true; selectWish(wish);" >
                <n-empty v-else size="large" description="Нет фото" class="empty"></n-empty>
            </div>   
            <div>
                <n-space v-if=" wish.price" class="price">
                    <n-tag type="success" >
                        Стоимость: {{ wish.price }} рублей
                    </n-tag>
                </n-space>
                <n-space class="date">
                    <n-tag type="info">
                        Дата создания желания:
                    </n-tag>
                    <n-tag type="info">
                        {{wish.date}}
                    </n-tag>
                </n-space>
                
               
                <n-space v-if="wish.link">
                    <n-tag type="info" size="large">
                        <a :href="wish.link" class="link">Ссылка</a>
                    </n-tag>
                </n-space>

                <n-space class="visible">
                    <n-tag type="info">
                        Желание видят все пользователи
                    </n-tag>
                </n-space>

                <div> 
                    <p class="card-description">{{ wish.description }}</p>
                    <p class="card-book">Это желание забронировано (имя / анонимно): исполню сам(а)</p>
                </div>


                <n-button @click="done()" secondary type="success" class="btn">Иполнено</n-button>
            
            </div>      
        </div>


        
    </div>

    


    <!-- Edit User Model -->
    <div v-if="showEditModal">
      <div class="modal modal-inner">
          <n-modal v-model:show="showEditModal">
              <n-card
              style="width: 600px"
              :bordered="false"
              size="huge"
              role="dialog"
              aria-modal="true"
              >
              
              <div class="modal-form">
                <form method="post">
                  <!-- <input type="text" name="name"  placeholder="Название" v-model="currentWish.name"> -->
                  <n-input v-model:value="currentWish.name" type="text" placeholder="Название"/>


                  <!-- <input type="text" name="price"  placeholder="Цена" v-model="currentWish.price"> -->
                  <!-- <n-input v-model:value="currentWish.price" type="text" placeholder="Цена"/> -->
                  <n-input-number  v-model:value="currentWish.price" type="text" placeholder="Цена"/>

                  


                  <!-- <input type="text" name="description" placeholder="Описание" v-model="currentWish.description"> -->
                  <n-input v-model:value="currentWish.description" type="text" placeholder="Описание"/>


                    <!-- <select class="select" name="visible" id="visible" v-model="currentWish.visible">
                        <option disabled value="">Кто видит желание</option>
                        <option v-for="(visible,index) in visible" :key="index" :value="visible">{{ visible }}</option> 
                    </select> -->

                    <n-space vertical class="select">
                        <n-select v-model:value="currentWish.visible" :options="visible" />
                    </n-space>

                    <!-- <select name="folder_id" id="folder_id" v-model="currentWish.done" >
                        <option disabled value="">done</option>
                        <option v-for="(wish,index) in wishes" :key="index" :value="wish.done">{{ wishes.done }}</option> 
                    </select> -->


                    <select name="folder_id" id="folder_id" v-model="currentWish.folder_id" >
                        <option disabled value="">Сохранить в папку</option>
                        <option v-for="(folder,index) in folders" :key="index" :value="folder.id">{{ folder.name }}</option> 
                    </select>

                    
               

                  <n-button  strong secondary type="success" attr-type="submit"  @click="showEditModal=false; updateWish(); reload_interval(1000);" class="edit-btn">Обновить</n-button>
                  <!-- <button  @click="showEditModal=false; updateWish(); reload_interval(1000);" class="button">Обновить</button> -->

                </form>
              </div>
             
              
              
              
              </n-card>
          </n-modal>
      </div>
    </div>

    <!-- Delete User Model -->
    <div v-if="showDeleteModal">
        <div class="modal">
            <n-modal v-model:show="showDeleteModal">
                <n-card
                style="width: 600px"
                title="Modal"
                :bordered="false"
                size="huge"
                role="dialog"
                aria-modal="true"
                >
                
                <div>
                    <h4>Удалить '{{ currentWish.name }}'? </h4>
                    
                    <!-- <button @click="showDeleteModal=false; deleteWish(); clearMsg();" class="red">Да</button>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <button @click="showDeleteModal=false" class="green">Нет</button> -->

                    <n-space>
                        <n-button strong secondary type="success" @click="showDeleteModal=false" >
                            Нет
                        </n-button>
                        <n-button strong secondary type="error" @click="showDeleteModal=false; deleteWish(1000);" >
                            Да
                        </n-button>
                    </n-space>
                </div>
                
                
                </n-card>
            </n-modal>
        </div>
    </div>

    <div v-if="showPhoto">
      <div class="modal modal-inner">
          <n-modal v-model:show="showPhoto">
              <n-card
              style="width: 700px"
              :bordered="false"
              size="huge"
              role="dialog"
              aria-modal="true"
              >
              
             
              <div>
                <img :src="'/img/' + currentWish.photo" alt="" class="modal-wish-img" @click="showPhoto=false;">
              </div>
              
              
              </n-card>
          </n-modal>
      </div>
    </div>

    
</template>

<script>
import axios from 'axios';
import { defineComponent, ref } from "vue";

import { NEmpty } from 'naive-ui';
import { NSpace, NSelect } from 'naive-ui';


import { NModal, NButton, NCard } from 'naive-ui';
import { NTag } from 'naive-ui';
import { NBreadcrumb, NBreadcrumbItem } from 'naive-ui';
import { NInput, NInputNumber  } from 'naive-ui';

import MsgComponent from '@/components/layout/MsgComponent.vue'
// import WishCard from '@/components/WishCard.vue';


export default defineComponent ({
  
    name: 'MyWishListItem',
    // props: ['id','name', 'description','photo'],
    data(){
        return {
            wishes: [],
            folders: [],
            folder_name: '',
            showModal: false,
            showEditModal: false,
            showPhoto: false,
            showDeleteModal: "",
            currentWish: {},
            errorMsg: "",
            successMsg: "",
        }
    },
    components: {
      NModal,
      NButton,
      NCard,
      NBreadcrumb,
      MsgComponent,
      NBreadcrumbItem,
      NSpace,
      NSelect,
      NTag,
      NEmpty,
      NInput,
      NInputNumber
    //   WishCard
    },
    methods: {
        async getWish() {
            let id = this.$route.params.id;

            
            await axios.get('http://localhost:8085/public/process.php?action=get-wishlist-item&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes;
                this.folder_name = response.data.folders[0].name;
                console.log(response.data);
            })
        },
        updateWish(){
          let formData = this.toFormData(this.currentWish);

          axios.post("http://localhost:8085/public/process.php?action=update-wishlist-item", formData)
          .then((response)=>{
            
              this.currentWish = {};
              if(response.data.error){
                  this.errorMsg = response.data.message;
              }else {
                  this.successMsg = response.data.message;
              }
          });
        },
        deleteWish(time){
          let formData = this.toFormData(this.currentWish);

          axios.post("http://localhost:8085/public/process.php?action=delete-wishlist-item", formData)
          .then((response)=>{
              this.currentWish = {};
              if(response.data.error){
                  this.errorMsg = response.data.message;
              } else {
                    this.successMsg = response.data.message;
                    // this.$router.push(`/my-wish-list-folders`); 
                    let self = this
                    setTimeout(function(){
                        self.$router.push(`/my-wish-list-folders`);
                    }, time)
                  
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
        selectWish(wish){
          this.currentWish = wish;
        },
        async done() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=done-wishlist-item&id='+id)

            .then((response)=>{
              if(response.data.error){
                  this.errorMsg = response.data.message;
              }else {
                  this.successMsg = response.data.message;
              }
          });
        },
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
        reload_interval(time){
            setTimeout(function(){
                location.reload();
            }, time);
        },
        // toNextPage(time) {
        //     setTimeout(function(){
        //         this.$router.push(`/my-wish-list-folders`);
        //     }, time)
        // }
    },
    mounted() {
        this.getWish()
        this.getFolders()
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
        };
    }
})

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
    color: #000;
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


.span {
    display: flex;
}

// .hover {
//     @include hover;
// }
// .modal {
//     @include modal;
// }


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

.n-card__content {
    .modal-form {
        max-width: 50%;
        margin: 0 auto;
    }
    input {
        @include input;
    }
    select {
        @include input;
    }
}

.flex-left, .flex-right {
    width: 50%;
}

.flex-left {
    p {
        width: 100%;
    }
}
.flex-right {
    button {
        width: 100%;
    }
    .n-tag__content {
        width: 100%;
    }
}

.empty {
    border: 1px #ccc solid;
    // border-radius: 10px;
    border-radius: 5px;
    padding: 80px;
}

// .icon {
//     background-color: #ccc;
//     padding: 7px 14px;
//     border-radius: 10px;
// }
.icon-left {
    margin-right: 10px;
}

.color {
    // background-color: $bg;
    border: 1px $bg solid;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 20px;
}

.btn {
    width: 100%;
    margin-top: 20px;
    margin-bottom: 20px;
}
.visible {
    margin-right: 10px;
    margin-bottom: 10px;
}
.price {
    margin-bottom: 10px;
}
.wish-name {
    font-weight: bold;
}
.options {
    margin-bottom: 20px;
}

.wish-img {
    border-radius: 10px;
    width: 100%; 
}
.modal-wish-img {
    width: 100%;
}

.div-img {
    margin-right: 20px;
}
.flex-img {
    align-items: start;
}
.date {
    margin-bottom: 10px;
}

.edit-btn {
    width: 100%;
}
</style>