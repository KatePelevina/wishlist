<template>
    <div class="page">
       
   
    <div v-for="(wish,index) in wishes" :key="index">

        <div @click="showDeleteModal=true; selectWish(wish);" class="icon">
            <img src="@/assets/delete.svg" alt="">
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
       

        <div class="flex-left">
            <div class="link">
            <n-space v-if="wish.link">
                <n-tag type="info" size="large">
                    <a :href="wish.link" target="_blank" class="link">Ссылка</a>
                </n-tag>
            </n-space>
            </div>
            <div>
                <!-- <p v-if="wish.price">Цена: {{ wish.price }}</p> -->
                
                <div v-if="wish.price" class="flex-left">
                    <n-space v-if=" wish.price" class="price">
                        <n-tag type="success" size="large">
                            <div class="flex-left">
                                <n-icon :component="CashOutline" size="25" :depth="1" class="cash-icon" />
                                <p class="card-price">Цена: {{ wish.price }} рублей</p>
                            </div>
                        </n-tag>
                    </n-space>
                </div>
                <p v-else>Цена: не указана</p>
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
            
       
        

        <div>
            <!-- <div class="card-body__left">
                <img :src="'/img/' + wish.photo" alt="" class="card-body__right-img">
            </div> -->
            <div>
                <!-- <p class="card-text">Дата создания: {{wish.date}}</p> -->
                
                <!-- <div>
                    <p v-if="wish.visible == 0">Это желание: вижу только я</p>
                    <p v-if="wish.visible == 1">Это желание: видят все пользователи</p>
                </div> -->
            </div>
        </div>

        <div>
            <p class="card-description">{{ wish.description }}</p>
            
            
            <!-- <div class="card-link" v-if="wish.link">
                <a :href="wish.link" class="link">Ссылка</a>
            </div> -->

            

            <!-- <p class="card-book">Это желание забронировано (имя / анонимно): исполню сам(а)</p> -->
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
                    <h5 class="modal-title">Удаление желания из списка "Я подарю"</h5>
                    <h4 class="red">Вы уверены, что хотите удалить желание '{{ currentWish.name }}' из списка забронированных подарков? </h4>

                    
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

    </div> 
</template>

<script>
import axios from 'axios';

import { NEmpty, NSpace, NTag, NIcon, NButton } from 'naive-ui';
// import { SearchSharp as SearchImg } from "@vicons/ionicons5";

import { NModal, NCard } from 'naive-ui';



export default {
  
    name: 'IWillPresentItem',
    // props: ['id','name', 'country', 'city', 'street', 'building', 'description','photo'],
    components: {
        NEmpty,
        NSpace,
        NTag,
        NIcon,
        // SearchImg,
        NButton,
        NModal, 
        NCard
    },
    data(){
        return {
            // showEditModal: false,
            showDeleteModal: false,
            currentWish: {},  
            showModal: false,
            wishes: [],
            showAddPhotoModal: false
        }
    },
    methods: {
        async getWish() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-i-will-present-wishlist-item&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes;
                console.log( this.wishes);
            })
        },
        selectWish(wish){
          this.currentWish = wish;
        },
        updatePlace(){
            let formData = this.toFormData(this.currentPlace);

            axios.post("http://localhost:8085/public/process.php?action=update", formData)
            .then((response)=>{
                this.currentPlace = {};
                if(response.data.error){
                    this.errorMsg = response.data.message;
                }else {
                    this.successMsg = response.data.message;
                    this.getAllPlaces();
                }
            });
        },
        deletePlace(){
            let formData = this.toFormData(this.currentPlace);

            axios.post("http://localhost:8085/public/process.php?action=delete", formData)
            .then((response)=>{
                this.currentPlace = {};
                if(response.data.error){
                    this.errorMsg = response.data.message;
                } else {
                    // this.successMsg = response.data.message;
                    this.$router.push('/'); 
                }
            });
        },
    },
    mounted() {
        this.getWish()
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
    margin-top: 10px;
    p {
        margin-right: 10px;
    }
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
.item-header {
    margin: 20px 0;
}
.item-description {
    margin-bottom: 20px;
}
.item-description__text {
    margin-bottom: 10px;
}
.empty {
    border: 1px #ccc solid;
    border-radius: 5px;
    padding: 80px;
}
.wish-name {
    margin-bottom: 20px;
}
.link {
    margin-bottom: 20px;
}
.flex-left {
    display: flex;
    justify-content: left;
}
.wish-img {
    border-radius: 10px;
    width: 100%; 
}
.flex {
    @include flex;
}
.page {
    @include page;
}
.modal-text {
    text-align: center;
}
</style>