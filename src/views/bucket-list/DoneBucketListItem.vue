<template>
    <button @click="goBack()">назад</button>

    <div>
        <n-breadcrumb>
            <n-breadcrumb-item @click="$router.push(`/result-bucket-list`)">Bucket List</n-breadcrumb-item>
            <n-breadcrumb-item @click="$router.push(`/my-wish-list/folder=${wish.folder_id}`)">{{ folder_name }}</n-breadcrumb-item>
            <n-breadcrumb-item>Желание</n-breadcrumb-item>
        </n-breadcrumb>
    </div>

    <div class="card" v-for="(wish,index) in wishes" :key="index">
        <div class="card-body">
            <p class="card-title">{{ wish.name }}</p>
            <div class="card-body__right">
                <div class="div-img">
                    <img :src="'/img/' + wish.photo" alt="" v-if="wish.photo" class="wish-img">
                    <n-empty v-else size="large" description="Фотографии нет" class="empty"></n-empty>
                </div>
             </div>
            <div class="card-body__left">
                
                <div>
                    <div v-if="showModal">
                        <div class="modal">
                            <label for="wish-visible">Это желание</label>
                            <select name="wish-visible" id="wish-visible">
                                <option value="1">видят все пользователи</option>
                                <option value="1">вижу только я</option>
                            </select>
                            <button>Сохранить</button>
                        </div>
                        <div class="hover" @click="showModal=false;"></div>
                    </div>
                    <div v-else>
                        <div  @click="showModal=true">
                            <p class="subtitle">Это желание 
                            <span class="bold">видят все пользователи</span>
                            </p>
                        </div>
                    </div>
                </div>

                
            
                
                <p>Цена: {{ wish.price }}</p>
                <p>Описание: {{ wish.description }}</p>
                <p>Дата: {{ wish.date }}</p>

                <n-space>
                    <n-tag type="info" size="large">
                        <a :href="wish.link" class="link">Ссылка</a>
                    </n-tag>
                </n-space>
                
                

                <p>Исполнено Сентябрь, 2022</p>

            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

import { NSpace, NTag } from 'naive-ui';
import { NBreadcrumb, NBreadcrumbItem } from 'naive-ui';

export default {
  
    name: 'DoneBucketListItem',
    components: {
        NSpace, 
        NTag,
        NBreadcrumb,
        NBreadcrumbItem 
    },
    props: ['id','name', 'country', 'city', 'street', 'building', 'description','photo'],
    data(){
        return {
            showEditModal: false,
            showDeleteModal: false,
            currentPlace: {},  
            showModal: false,
            wishes: []
        }
    },
    methods: {
        async getWish() {
            let id = this.$route.params.id;

            
            await axios.get('http://localhost:8085/public/process.php?action=get-bucketlist-item&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes;
                // this.folder_name = response.data.folders[0].name;
                console.log(response.data);
            })
        },
        selectPlace(place){
            this.currentPlace = place;
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
        goBack() {
            this.$router.go(-1); 
        }
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
.wish-img {
    width: 50%;
    border-radius: 10px;
}
.div-img {
    width: 100%;
}
</style>