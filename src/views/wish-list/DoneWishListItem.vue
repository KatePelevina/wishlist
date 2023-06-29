<template>
    <h1>DoneWishListItem</h1>
    <div class="card">
        <div class="card-body">

            <div class="card-body__right">
                 <img class="card-body__right-img" src="@/assets/paris.jpg" alt="">
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

                
            
                <p class="card-title">Посетить Париж</p>
                <p>300$</p>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quaerat vero, voluptas unde sint corrupti expedita quisquam odit eos incidunt. Corporis?</p>
                <p>14.02.2023</p>
                <div>
                    <a href="https://www.farfetch.com/bg/shopping/women/furla-foldover-leather-satchel-bag-item-18010435.aspx?storeid=9681">Link</a>
                </div>

                <p>
                    Исполнено Сентябрь, 2022
                </p>

            </div>
        </div>
    </div>

    
</template>

<script>
import axios from 'axios';

export default {
  
    name: 'DoneBucketListItem',
    props: ['id','name', 'country', 'city', 'street', 'building', 'description','photo'],
    data(){
        return {
            showEditModal: false,
            showDeleteModal: false,
            currentPlace: {},  
            showModal: false,
        }
    },
    methods: {
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

</style>