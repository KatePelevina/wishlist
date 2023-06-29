<template>
    <div class="card" v-for="(wish,index) in wishes" :key="index">
        <div class="flex">
            <div>
                <p class="card-title">{{ wish.name }}</p>
            </div>
            <div class="card-header__right">
                <a href="#" @click="showEditModal=true; selectWish(wish);"  >
                    <img src="@/assets/edit-1.svg" alt="" class="place-btn">
                </a>                     
                <a href="#" @click="showDeleteModal=true; selectWish(wish);">
                    <img src="@/assets/delete.svg" alt="">
                </a>
            </div>
        </div>


        <div class="card-body">
            <div class="card-body__left">
                <img :src="'/img/' + wish.photo" alt="" class="card-body__right-img">
            </div>
            <div class="card-body__right">
                <p class="card-text">Дата создания: {{wish.date}}</p>
                <p class="card-text">Стоимость: {{ wish.price }}</p>
                
            </div>
        </div>

        <div>
                
                

                
                <p class="subtitle">Это желание <strong>{{ wish.visible }}</strong></p>
                <p class="card-description">{{ wish.description }}</p>
                
                
                <div class="card-link">
                    <a :href="wish.link" class="link">Ссылка</a>
                </div>

                <p class="card-book">Это желание забронировано (имя / анонимно): исполню сам(а)</p>
    </div>
</div>

    
</template>

<script>
import axios from 'axios';

export default {
  
    name: 'MyCard',
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

            await axios.get('http://localhost:8085/public/process.php?action=get-i-will-present-wishlist-item&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes;
                console.log( this.wishes);
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

</style>