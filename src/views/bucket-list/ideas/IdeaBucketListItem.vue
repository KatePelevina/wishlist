<template>
    <div>
        <div>
            <n-breadcrumb>
                <n-breadcrumb-item @click="$router.push(`/ideas-bucket-list`)">Идеи для Bucket List / </n-breadcrumb-item>
            </n-breadcrumb>
        </div>

        <div class="card" v-for="(wish,index) in wishes" :key="index">
            <div class="card-body">
                <h3 class="card-title">{{ wish.name }}</h3>
                <div class="card-body__header">
                    <div class="card-body__image">
                        <!-- <img class="card-body__img" src="@/assets/bag.webp" alt=""> -->
                        <img :src="'/img/' + wish.photo" alt="" class="card-body__img">
                    </div>
                    <div class="card-body__text">
                        <p>@EkaterinaFilatova1993 хочет</p>
                        
                        
                        <p class="card-price">{{ wish.price }} руб</p>
                    </div>
                </div>
                <div class="card-body__body">

                </div>

                
                <div class="card-body__content">
                    
                    <p class="card-description">{{ wish.description }}</p>
                    <div class="card-link">
                        <a :href="wish.link" class="link">Ссылка</a>
                        <!-- <a href="https://www.farfetch.com/bg/shopping/women/furla-foldover-leather-satchel-bag-item-18010435.aspx?storeid=9681">https://www.farfetch.com/bg/shopping/women/furla-foldover-leather-satchel-bag-item-18010435.aspx?storeid=9681</a> -->
                    </div>
                    
                    
                    
                    
                    <!-- <button>Я исполню</button>
                    <button>Забронировать</button>
                    <button>Зарезервировать</button> -->
                    <div class="flex">
                        <button class="button">Я подарю</button>
                        <button class="btn">+ Добавить в свой Bucket List</button>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from 'axios';
import { NBreadcrumb, NBreadcrumbItem  } from 'naive-ui';


export default {
    name: 'IdeaWishlistItem',
    components: {
        NBreadcrumb, 
        NBreadcrumbItem
    },
    data(){
        return {
            wishes: []
        }
    },
    methods: {
        async getWish() {
            let id = this.$route.params.id;

            
            await axios.get('http://localhost:8085/public/process.php?action=get-bucketlist-item&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes;
                console.log(response.data.wishes)
            })
        },
    },
    mounted() {
        this.getWish()
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
</style>