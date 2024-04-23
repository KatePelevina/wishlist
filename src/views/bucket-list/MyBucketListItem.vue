<template>
    <msg-component
        :errorMsg="this.errorMsg"
        :successMsg="this.successMsg"
    />

    <div class="card" v-for="(wish,index) in wishes" :key="index">

        <div class="flex color flex-breadcrumb">
            <div class="breadcrumb">
                <n-breadcrumb>
                    <!-- <n-breadcrumb-item @click="$router.push(`/my-bucket-list-folders`)">Bucket List</n-breadcrumb-item> -->
                    <n-breadcrumb-item @click="$router.push(`/my-bucket-list-folders`)">Bucket List</n-breadcrumb-item>
                    <n-breadcrumb-item @click="$router.push(`/my-bucket-list/folder=${wish.folder_id}`)">{{ folder_name }}</n-breadcrumb-item>
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

        <div>
            <h1 class="wish-name">{{ wish.name }}</h1>
        </div>

        <div class="card-body">
            <div class="div-img">
                <!-- <img v-if="wish.photo"  :src="'/img/' + wish.photo" alt="" class="wish-img" @click="showPhoto=true; selectWish(wish);" >
                <n-empty v-else size="large" description="Нет фото" class="empty"></n-empty> -->

                <div class="flex">
                    <n-space v-if=" wish.price" class="price">
                        <n-tag type="success" size="large">
                            Стоимость: {{ wish.price }} рублей
                        </n-tag>
                    </n-space>
                    
                    <div v-if="wish.photo">
                    <!-- <img v-if="wish.photo"  :src="'/img/' + wish.photo" alt="" class="wish-img" @click="showPhoto=true; selectWish(wish);" > -->
                        <n-button @click="selectWish(wish); showPhoto=true;">
                            <!-- + -->
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M18 13v7H4V6h5.02c.05-.71.22-1.38.48-2H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-5l-2-2zm-1.5 5h-11l2.75-3.53l1.96 2.36l2.75-3.54L16.5 18zm2.8-9.11c.44-.7.7-1.51.7-2.39C20 4.01 17.99 2 15.5 2S11 4.01 11 6.5s2.01 4.5 4.49 4.5c.88 0 1.7-.26 2.39-.7L21 13.42L22.42 12L19.3 8.89zM15.5 9a2.5 2.5 0 0 1 0-5a2.5 2.5 0 0 1 0 5z" fill="currentColor"></path></svg> -->

                            <template #icon>
                                <n-icon>
                                    <search-img />
                                </n-icon>
                            </template>
                        </n-button>
                    </div>
                </div>

               
                

                <div>
                    <n-upload
                    multiple
                    directory-dnd
                    action="http://localhost:8085/public/process.php?action=bucketlist-item-image-load&id=id"
                    :max="5"
                    :data="{
                        'id': 'wish.id'
                    }"
                    accept= ".png, .jpg, .jpeg, .webp, .HEIC"
                >
                    <n-upload-dragger>
                    <div style="margin-bottom: 12px">
                        <n-icon size="48" :depth="3">
                        <archive-icon />
                        </n-icon>
                    </div>
                    <n-text style="font-size: 16px">
                        <n-empty  v-if="!wish.photo" size="large" description="Click or drag a file to this area to upload" class="empty"></n-empty>
                        <img v-else  :src="'/img/' + wish.photo" alt="" class="wish-img" >

                    </n-text>
                    <!-- <n-p depth="3" style="margin: 8px 0 0 0">
                        Strictly prohibit from uploading sensitive information. For example,
                        your bank card PIN or your credit card expiry date.
                    </n-p> -->
                    </n-upload-dragger>
                    </n-upload>
                </div>
            </div>   
            <div>
                <div>
                    <!-- <n-space v-if=" wish.price" class="price">
                        <n-tag type="success" >
                            Стоимость: {{ wish.price }} рублей
                        </n-tag>
                    </n-space> -->
                </div>
                <div>
                    <n-space class="date">
                        <n-tag type="info">
                            Дата создания желания: {{wish.date}}
                        </n-tag>
                    </n-space>
                </div>
                
                <div>
                    <n-space class="visible">
                        <n-tag type="info">
                            <p>Кто видит желание: {{ statusOFvisible[wish.visible] }}</p>
                        </n-tag>
                        <n-tag type="info">
                            <p>Статус: {{ statusToText[wish.done] }}</p>
                        </n-tag>
                    </n-space>
                </div>

                <div>
                    <n-space v-if="wish.link">
                        <n-tag type="info" size="large">
                            <a :href="wish.link" class="link">Ссылка</a>
                        </n-tag>
                    </n-space>

                </div>
                
                <div>
                    <n-button @click="done()" secondary type="success" class="btn" v-if="wish.done == 0">Иполнено</n-button>
                </div>
            </div>      
        </div>

        <div> 
            <p class="card-description">{{ wish.description }}</p>
            <!-- <p class="card-book">Это желание забронировано (имя / анонимно): исполню сам(а)</p> -->
        </div>

        <!-- <div>
            <label>File
                <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
            </label>
            <button v-on:click="submitFile()">Submit</button>
        </div> -->

        <!-- <bucket-item-image-load /> -->

        <!-- <n-upload 
            
            action="http://localhost:8085/public/process.php?action=bucket-wishlist-item-image-load&id=id"
            :data="{
                'id': 'wish.id'
            }"
            accept= ".png, .jpg, .jpeg, .webp, .HEIC"
            
        >
            <n-button>
                <img src="@/assets/search.svg" alt="icon" class="nav-item__icon">

                Загрузить фото

            </n-button>
       
        </n-upload> -->
    </div>



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
            
            <form method="post">
                <!-- <input type="text" name="name"  placeholder="Название" v-model="currentWish.name"> -->
                <n-input v-model:value="currentWish.name" type="text" placeholder="Название"/>


                <!-- <input type="text" name="price"  placeholder="Цена" v-model="currentWish.price"> -->
                <n-input-number  v-model:value="currentWish.price" type="text" placeholder="Цена"/>


                <!-- <input type="text" name="description" placeholder="Описание" v-model="currentWish.description"> -->
                <n-input v-model:value="currentWish.description" type="text" placeholder="Описание"/>

                <input type="text" name="link" placeholder="Ссылка" v-model="currentWish.link">

                <!-- <select name="visible" id="visible" v-model="currentWish.visible">
                    <option disabled selected>Please select one</option>
                    <option v-for="(visible,index) in visible" :key="index" :value="visible">{{ visible }}</option> 
                </select> -->

                <n-space vertical class="select">
                    <n-select v-model:value="currentWish.visible" :options="visible" />
                </n-space>

                <!-- <select name="folder_id" id="folder_id" v-model="currentWish.folder_id" >
                    <option disabled value="">Сохранить в папку</option>
                    <option v-for="(folder,index) in folders" :key="index" :value="folder.id">{{ folder.name }}</option> 
                </select> -->

                <!-- <n-space vertical class="select">
                    <n-select v-model:value="currentWish.folder_id" :options="currentWish.folder_id" />
                </n-space>-->

                <!--<button  @click="showEditModal=false; updateWish()" class="button">Обновить</button> -->
                <n-button  strong secondary type="success" attr-type="submit"  @click="showEditModal=false; updateWish(); reload_interval(1000);" class="edit-btn">Обновить</n-button>

            </form>
            
            
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
                    
                    <button @click="showDeleteModal=false; deleteWish(); clearMsg();" class="red">Да</button>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <button @click="showDeleteModal=false" class="green">Нет</button>
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
import { NModal, NButton, NCard} from 'naive-ui';
import { NBreadcrumb, NBreadcrumbItem } from 'naive-ui';
import { NEmpty } from 'naive-ui';
import { NInput, NInputNumber  } from 'naive-ui';
import { NSpace, NSelect, NTag, NUpload } from 'naive-ui';


import MsgComponent from '@/components/layout/MsgComponent.vue';
// import BucketItemImageLoad from '@/views/BucketItemImageLoad.vue'
// import WishCard from '@/components/WishCard.vue';

// import { CashOutline as CashIcon } from "@vicons/ionicons5";
import { SearchSharp as SearchImg } from "@vicons/ionicons5";

import { NIcon } from "naive-ui";
import { defineComponent, h } from "vue";



export default defineComponent({
  
    name: 'MyBucketListItem',
    props: ['id','name', 'description','photo'],
    data(){
        return {
            wishes: [],
            folders: [],
            folder_name: '',
            showModal: false,
            showPhoto: false,
            showEditModal: false,
            showDeleteModal: false,
            currentWish: {},
            errorMsg: "",
            successMsg: "",
            statusOFvisible: {
                '0': 'вижу только я',
                '1': 'видят все пользователи'
            },
            statusToText: {
                '0': 'хочу',
                '1': 'исполнено',
            },
            file: ''
        }
    },
    components: {
      NModal,
      NButton,
      NCard,
      MsgComponent,
      NBreadcrumb,
      NBreadcrumbItem,
      NEmpty,
      NInput,
      NInputNumber,
      NSpace, 
      NSelect,
      NTag,
    //   BucketItemImageLoad,
      NUpload,
    //   WishCard
    NIcon,
    // CashIcon,
    SearchImg
    },
    methods: {
        async getWish() {
            let id = this.$route.params.id;

            
            await axios.get('http://localhost:8085/public/process.php?action=get-bucketlist-item&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes;
                this.folder_name = response.data.folders[0].name;
                console.log(response.data);
            })
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
        updateWish(){
          let formData = this.toFormData(this.currentWish);

          axios.post("http://localhost:8085/public/process.php?action=update-bucketlist-item", formData)
          .then((response)=>{
              this.currentWish = {};
              if(response.data.error){
                  this.errorMsg = response.data.message;
              }else {
                  this.successMsg = response.data.message;
                  this.getAllPlaces();
              }
          });
        },
        deleteWish(){
          let formData = this.toFormData(this.currentWish);

          axios.post("http://localhost:8085/public/process.php?action=delete-bucketlist-item", formData)
          .then((response)=>{
              this.currentWish = {};
              if(response.data.error){
                  this.errorMsg = response.data.message;
              } else {
                  this.successMsg = response.data.message;
                //   this.$router.push('/'); 
              }
          });
        },
        uploadFile() {
            const formData = new FormData();
            formData.append('bytes', this.file);

            axios.post('http://localhost:8085/public/process.php?action=file-save',
            formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
            ).then(function (data) {
                console.log(data.data);
                this.$router.reload();
            })
            .catch(function () {
                console.log('FAILURE!!');
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
        back() {
            this.$router.go(-1);
        },
        async done(){
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=done-bucketlist-item&id='+id)

            .then((response)=>{
              if(response.data.error){
                  this.errorMsg = response.data.message;
              } else {
                  this.successMsg = response.data.message;
              }
          });
        },
        // async submitFile(){
        //     let id = this.$route.params.id;

        //     let formData = new FormData();
        //     formData.append('file', this.file);
        //     await axios.post( 'http://localhost:8085/public/process.php?action=bucket-wishlist-item-image-load',
        //         formData,
        //         {
        //         headers: {
        //             'Content-Type': 'multipart/form-data'
        //         }
        //         }
        //     ).then(function(){
        //         // this.$router('/image-load');
        //         // location.reload();
        //         console.log('SUCCESS!!');
        //     })
        //     .catch(function(){
        //         console.log('FAILURE!!');
        //     });
        // },
        // handleFileUpload(){
        //     this.file = this.$refs.file.files[0];
        //     console.log(this.file);
        // },
    },
    mounted() {
        this.getWish()
        this.getFolders() 
    },
    setup() {
        return {
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
            renderIcon() {
                return h(NIcon, null, {
                default: () => h(SearchImg)
                });
            }
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
.flex-breadcrumb {
    // flex-wrap: wrap;
    width: 100%;
}
.n-breadcrumb {
   flex-basis: 80%;
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
    flex-basis: 49%;
    p {
        width: 100%;
    }
}
.flex-right {
    flex-basis: 49%;
    button {
        width: 100%;
    }
    // .n-tag__content {
    //     width: 100%;
    // }
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
// .price {
//     margin-bottom: 10px;
// }
.wish-name {
    font-weight: bold;
}
.options {
    margin-bottom: 20px;
}

.wish-img {
    border-radius: 10px;
    width: 100%;
    width: 100%; 
    height: 400px;   
    // object-fit: contain;
    object-fit: cover;
    
}
.modal-wish-img {
    width: 100%;
}

// .div-img {
//     margin-right: 20px;
// }
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