<template>
    <n-drawer v-model:show="active" :placement="placement">
        <n-drawer-content closable>
            <msg-component
                class="msg"
                :errorMsg="this.errorMsg"
                :successMsg="this.successMsg"
            />
        </n-drawer-content>
    </n-drawer>

    <div class="card" v-for="(wish,index) in wishes" :key="index">

        <div class="flex color flex-breadcrumb">
            <div class="breadcrumb">
                <n-breadcrumb>
                    <n-breadcrumb-item @click="$router.push(`/my-bucket-list-folders`)">Bucket List</n-breadcrumb-item>
                    <n-breadcrumb-item @click="$router.push(`/my-bucket-list/folder=${wish.folder_id}`)">{{ folder_name }}</n-breadcrumb-item>
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

        <div class="flex">
            <h1 class="wish-name">{{ wish.name }}</h1>
            <div v-if="wish.photo">
                    <!-- <img v-if="wish.photo"  :src="'/img/' + wish.photo" alt="" class="wish-img" @click="showPhoto=true; selectWish(wish);" > -->
                        <n-button @click="selectWish(wish); showPhoto=true;">
                            <template #icon>
                                <n-icon>
                                    <search-img />
                                </n-icon>
                            </template>
                        </n-button>
            </div>
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
                    
                    
                </div>

               
                

                
            </div>   

            <div v-if="wish.photo">
                    <img :src="'/img/' + wish.photo" alt="" class="wish-img" @click="selectWish(wish); showAddPhotoModal=true;" >
                </div>

                <div v-else>
                    <n-empty @click="selectWish(wish); showAddPhotoModal=true;" size="large" description="Нет фото" class="empty"></n-empty>
                </div>
            <div>
                <!-- <div> -->
                    <!-- <n-space v-if=" wish.price" class="price">
                        <n-tag type="success" >
                            Стоимость: {{ wish.price }} рублей
                        </n-tag>
                    </n-space> -->
                <!-- </div> -->
                <!-- <div>
                    <n-space class="date">
                        <n-tag type="info">
                            Дата создания желания: {{wish.date}}
                        </n-tag>
                    </n-space>
                </div> -->
                
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
        </div>

      

       
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
                
                <div class="modal-form">
                
                    <form >
                    <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>

                    <n-button @click="showAddPhotoModal=false; updateWish(); submitFile()"  type="primary">Добавить фото</n-button>
                    </form>
                </div>
                
                </n-card>
            </n-modal>
        </div>
    </div>

    <!-- Edit  Model -->
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
                <label>Название</label>
                <n-input v-model:value="currentWish.name" type="text" placeholder="Название"/>

                <label>Цена</label>
                <n-input-number  v-model:value="currentWish.price" type="text" placeholder="Цена"/>

                <label>Описание</label>
                <n-input v-model:value="currentWish.description" type="text" placeholder="Описание"/>

                <label>Ссылка</label>
                <n-input v-model:value="currentWish.link" type="text" placeholder="Ссылка"/>


                <label>Кто видит желание*</label>
                <n-space vertical class="select">
                    <n-select v-model:value="currentWish.visible" :options="visible" class="form-n-select" />
                </n-space>

                <!-- <select name="visible" id="visible" v-model="currentWish.visible">
                    <option disabled selected>Please select one</option>
                    <option v-for="(visible,index) in visible" :key="index" :value="visible">{{ visible }}</option> 
                </select> -->

                <!-- <n-space vertical class="select">
                    <n-select v-model:value="currentWish.visible" :options="visible" />
                </n-space> -->

                <!-- <select name="folder_id" id="folder_id" v-model="currentWish.folder_id" >
                    <option disabled value="">Сохранить в папку</option>
                    <option v-for="(folder,index) in folders" :key="index" :value="folder.id">{{ folder.name }}</option> 
                </select> -->

                <!-- <n-space vertical class="select">
                    <n-select v-model:value="currentWish.folder_id" :options="currentWish.folder_id" />
                </n-space>-->

                <!--<button  @click="showEditModal=false; updateWish()" class="button">Обновить</button> -->
                <n-button  strong secondary type="success" attr-type="submit"  @click="showEditModal=false; updateWish(); activate('top'); reload_interval(1000); " class="edit-btn">Обновить</n-button>

            </form>
            
            
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

    
</template>

<script>
import axios from 'axios';
import { NModal, NButton, NCard} from 'naive-ui';
import { NBreadcrumb, NBreadcrumbItem } from 'naive-ui';
import { NEmpty } from 'naive-ui';
import { NInput, NInputNumber  } from 'naive-ui';
import { NSpace, NSelect, NTag } from 'naive-ui';


import MsgComponent from '@/components/layout/MsgComponent.vue';
// import BucketItemImageLoad from '@/views/BucketItemImageLoad.vue'
// import WishCard from '@/components/WishCard.vue';

// import { CashOutline as CashIcon } from "@vicons/ionicons5";
import { SearchSharp as SearchImg } from "@vicons/ionicons5";

import { NIcon } from "naive-ui";
import { defineComponent, h, ref } from "vue";
import { NDrawer, NDrawerContent }  from 'naive-ui';



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
            showAddPhotoModal: false,
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
        //   WishCard
        NIcon,
        // CashIcon,
        SearchImg,
        NDrawer, NDrawerContent 
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
              } else {
                  this.successMsg = response.data.message;
                //   this.getAllPlaces();
              }
          });
        },
        deleteWish(time){
          let formData = this.toFormData(this.currentWish);

          axios.post("http://localhost:8085/public/process.php?action=delete-bucketlist-item", formData)
          .then((response)=>{
              this.currentWish = {};
              if(response.data.error){
                  this.errorMsg = response.data.message;
              } else {
                  this.successMsg = response.data.message;
                //   this.$router.push('/'); 

                let self = this
                setTimeout(function(){
                    self.$router.push(`/my-wish-list-folders`);
                }, time)
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
        async submitFile() {
            let formData = new FormData();
            formData.append('file', this.file);

            let id = this.$route.params.id;


            await axios.post( 'http://localhost:8085/public/process.php?action=image-load-bucketlist&id=' + id,
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
        const active = ref(false);
        const placement = ref("right");
        const activate = (place) => {
        active.value = true;
        placement.value = place;
        };
        return {
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
.msg {
    width: 50%;
    margin: 0 auto;
    padding-top: 50px;
}
</style>