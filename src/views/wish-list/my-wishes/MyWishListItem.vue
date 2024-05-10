<template>
<div class="page">
    <n-drawer v-model:show="active" :placement="placement">
        <n-drawer-content closable>
            <msg-component
                class="msg"
                :errorMsg="this.errorMsg"
                :successMsg="this.successMsg"
            />
        </n-drawer-content>
    </n-drawer>

    <div v-for="(wish,index) in wishes" :key="index">
        <div class="flex color breadcrumb">
            <div>
                <n-breadcrumb>
                    <n-breadcrumb-item @click="$router.push(`/my-wish-list-folders`)">Wish List</n-breadcrumb-item>
                    <n-breadcrumb-item v-if="folder_name" @click="$router.push(`/my-wish-list/folder=${wish.folder_id}`)">{{ folder_name }}</n-breadcrumb-item>
                </n-breadcrumb>
            </div>
           
            <div class="card-header__right flex">
                <div @click="showEditModal=true; selectWish(wish);" class="icon icon-left">
                    <img src="@/assets/edit-1.svg" alt="edit-icon">
                </div>
                <div @click="showDeleteModal=true; selectWish(wish);" class="icon">
                    <img src="@/assets/delete.svg" alt="delete-icon">
                </div>
            </div>
        </div>
       
        
        <div class="flex">
            <h1 class="wish-name">{{ wish.name }}</h1>
                    
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
        
        <div class="div-img">

            <div v-if="wish.photo">
                <img :src="'/img/' + wish.photo" alt="" class="wish-img" @click="selectWish(wish); showAddPhotoModal=true;" >
            </div>

            <div v-else>
                <n-empty @click="selectWish(wish); showAddPhotoModal=true;" size="large" description="Нет фото" class="empty"></n-empty>
            </div>
        </div>   
       
        <p v-if="wish.visible == 0">вижу только я</p>
        <p v-if="wish.visible == 1">видят все пользователи</p>
        <p>Стоимость: {{ wish.price }} рублей</p>
        <p class="card-description">{{ wish.description }}</p>

        <n-space class="margin">
            <n-tag type="info">
                Желание видят все пользователи
            </n-tag>
        </n-space>

        <n-button @click="doneWishlist()" secondary type="success" class="btn" v-if="wish.done == 0">Исполнено</n-button>

    </div>

    <!-- Add Photo Model -->
    <div v-if="showAddPhotoModal">
      <div class="modal modal-inner">
          <n-modal v-model:show="showAddPhotoModal">
              <n-card
                style="width: 600px"
                :bordered="false"
                size="huge"
                role="dialog"
                aria-modal="true"
              >
              
              <div class="modal-form add-photo-modal">
               
                <form >
                  <input type="file" id="file" ref="file" v-on:change="handleFileUpload()" class="photo-input"/>

                  <n-button @click="showAddPhotoModal=false; updateWish(); submitFile()"  type="primary" class="add-photo-btn">Добавить фото</n-button>
                </form>
              </div>
             
              </n-card>
          </n-modal>
      </div>
    </div>

    <!-- Edit  Model -->
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
                    <form >
                        <label>Название*</label>
                        <n-input v-model:value="currentWish.name" type="text" placeholder="Название"/>

                        <label>Цена</label>
                        <n-input-number  v-model:value="currentWish.price" type="text" placeholder="Цена"/>

                        <label>Описание</label>
                        <n-input v-model:value="currentWish.description" type="text" placeholder="Описание"/>


                        <label>Ссылка</label>
                        <n-input v-model:value="currentWish.link" type="text" placeholder="Ссылка" class="input" />

                        <label>Кто видит желание*</label>
                        <n-space vertical class="select">
                            <n-select v-model:value="currentWish.visible" :options="visible" class="form-n-select" />
                        </n-space>

                        <!-- <n-space vertical class="select">
                            <n-select  v-model:value="currentWish.folder_id" :options="folderSelector"/>
                        </n-space> -->


                    <n-button @click="showEditModal=false; updateWish(); activate('top')" class="add-btn"  type="primary">Обновить</n-button>
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
                
                <div class="modal-text">
                    <h5 class="modal-title">Удаление желания</h5>
                    <h4 class="red">Вы уверены, что хотите удалить желание: '{{ currentWish.name }}'? </h4>

                    
                    <div class="delete-buttons">
                        <n-button strong secondary type="success" @click="showDeleteModal=false" class="delete-no" >
                            Нет
                        </n-button>
                        <n-button strong secondary type="error" @click="showDeleteModal=false; deleteWish(2000); activate('top')" >
                            Да
                        </n-button>
                    </div>
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
// import WishItemImageLoad from '@/views/WishItemImageLoad.vue';
// import WishCard from '@/components/WishCard.vue';

import { NIcon } from "naive-ui";
import { SearchSharp as SearchImg } from "@vicons/ionicons5";
import { NDrawer, NDrawerContent }  from 'naive-ui';


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
            showAddPhotoModal: false,
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
        NInputNumber,
        NIcon,
        SearchImg,
        NDrawer,
        NDrawerContent
        // WishItemImageLoad,
        // NUpload,
        // NUploadDragger
    //   WishCard
    },
    methods: {
        updateWish(){
            let formData = this.toFormData(this.currentWish);

            axios.post("http://localhost:8085/public/process.php?action=update-wishlist-item", formData)
            .then((response)=>{
                this.currentWish = {};
                if ( response.data.error ){
                    this.errorMsg = "Ошибка!";
                    console.log(response.data.error);
                } else {
                    this.successMsg = response.data.message;
                    // console.log(response.data.message);
                    // this.getAllPlaces();
                }
            });
        },
        deleteWish(time){
          let formData = this.toFormData(this.currentWish);

          axios.post("http://localhost:8085/public/process.php?action=delete-wishlist-item", formData)
          .then((response)=>{
              this.currentWish = {};
              if ( response.data.error){
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
        
        async getWish() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-wishlist-item&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes;
                this.folder_name = response.data.folders[0].name;
                console.log(response.data);
            })
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
        async doneWishlist() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=done-wishlist-item&id='+id)

            .then((response)=>{
              if (response.data.error){
                  this.errorMsg = response.data.message;
              } else {
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
        async submitFile(){
            let formData = new FormData();
            formData.append('file', this.file);

            let id = this.$route.params.id;


            await axios.post( 'http://localhost:8085/public/process.php?action=image-load-wishlist&id=' + id,
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            )
            // .then(function(){
            //     this.$router('/image-load');
            //     console.log('SUCCESS!!');
            // })
            // .catch(function(){
            //     console.log('FAILURE!!');
            // });
        },
        handleFileUpload(){
            this.file = this.$refs.file.files[0];
            console.log(this.file);
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
            visible: [
                // {
                //     label: "Кто видит желание",
                //     value: "",
                //     disabled: true
                // },
                {
                    label: "вижу только я",
                    value: "0",
                },
                {
                    label: "видят все пользователи",
                    value: "1"
                }
            ],
            done: [
                // {
                // label: "Статус",
                // value: "",
                // disabled: true
                // },
                {
                    label: "хочу",
                    value: "0",
                },
                {
                    label: "исполнено",
                    value: "1"
                }
            ],
            folderSelector: [
                {
                  label: "Переместить в папку",
                  value: "",
                  disabled: true
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
    input {
        @include input;
    }
    select {
        // @include input;
        width: 100%;
        padding: 7px;
        color: #C2C2C2;
        border:1px solid #C2C2C2;
        :hover, :focus, :active {
            border:1px solid green;
        }
    }
}

.modal-form {
        max-width: 50%;
        margin: 0 auto;
        // text-align: center;
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
    // width: 49%;
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
    max-width: 200px;
    font-weight: bold;
    margin-bottom: 10px;
}
.options {
    margin-bottom: 20px;
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


.modal-wish-img {
    width: 100%;
}

.div-img {
    // margin-right: 20px;
    cursor: pointer;
}
// .flex-img {
//     align-items: start;
// }


.edit-btn {
    width: 100%;
}

.date {
    margin-bottom: 30px;
    // background-color: #ccc;
    // padding: 5px;
    // border-radius: 3px;
}


.flex-left, .flex-right {
    width: 50%;
}

.imagePreview {
    width: 100%;
}

.add-btn {
    width: 100%;
}
.n-input {
    margin-bottom: 10px;
}
.n-input-number  {
    margin-bottom: 10px;
}
.form-n-select {
    margin-bottom: 10px;
    width: 100%;
}
.breadcrumb {
    display: flex;
    flex-wrap: no-wrap;
}
.delete-modal {
    text-align: center;
}
.delete-buttons {
    display: flex;
    justify-content: center;
}
.modal-title {
    text-align: center;
    margin-bottom: 20px;
    font-size: 20px;
}
.delete-no {
    margin-right: 20px;
}
.red {
    color: $red;
    margin-bottom: 20px;
    text-align: center;
}
.add-photo-modal {
    text-align: center;
}
.add-photo-btn {
    margin-top: 20px;
}
.msg {
    width: 50%;
    margin: 0 auto;
    padding-top: 50px;
}
.page {
    @include page;
}
.photo-input {
    cursor: pointer;
}
</style>