<template>
    <!-- <UserPage /> -->

    <my-input
        v-model="searchQuery"
        placeholder="Поиск..."
    />

   

    <!-- <div class="items" v-if="wishes.length">
        <div class="item" v-for="(wish,index) in wishes" :key="index">
            <div class="box" @click="$router.push(`/user-wish-list-item/${wish.id}`)">
                <div class="box-inner">
                    <span v-if="wish.price" class="span">{{ wish.price }} руб</span>
                    <img :src="'/img/' + wish.photo" alt="">
                </div>
            </div>
            <p class="box-inner__hover">{{ wish.name }}</p>
        </div>
    </div>
    <div v-else>
        <p>пока ничего нет</p>
    </div> -->



    <user-wish-list :wishes="sortedAndSearchedPosts"/>
    
</template>

<script>
import axios from 'axios';
// import UserPage from '@/components/users/UserPage.vue';
// import ListComponent from '@/components/ListComponent.vue';
import MyInput from '@/components/layout/MyInput.vue';
import UserWishList from '@/components/users/UserWishList.vue';


export default {
    components: {
        // UserPage,
        // ListComponent,
        MyInput,
        UserWishList
    },
    data() {
        return {
            users:[],
            wishes: [],
            selectedSort: '',
            searchQuery: ''
        }
    },
    methods: {
        async getWish() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-user-wishlist&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes;
                this.users = response.data.users;
            })
        },
    },
    mounted() {
        this.getWish()
    },
    computed: {
        sortedPosts() {
            return [...this.wishes].sort((wish1, wish2) => wish1[this.selectedSort]?.localeCompare(wish2[this.selectedSort]))
        },
        sortedAndSearchedPosts() {
            return this.sortedPosts.filter(wish => wish.name.toLowerCase().includes(this.searchQuery.toLowerCase()))
        }
    },
}
</script>

<style lang="scss" scoped>
@import "@/styles/_variables.scss";



.box {
    flex-basis: 49%;
    height: 200px;
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    img {
        height: 200px;
    }
}
// .box:hover {
//     box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
// }
.box-inner {
    background-color: #fff;
    text-align: center;
    position: relative;
    p {
        opacity: 0;
    }
}
.box-inner:hover {
    p {
        opacity: 1;
        position: absolute;
        bottom: 10px;
        left: 10px;
    }
}
.span {
    background-color: $active;
    color: #fff;
    padding: 5px;
    border-radius: 5px;
    position: absolute;
    top: 10px;
    right: 10px;
}
.items {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}
.item {
   width: 49%;
   margin-bottom: 10px;
   
}

.photo {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: "#ссс";
    margin-right: 10px;
    background-image: url('@/assets/photo.jpg');
    background-size: 40px;
    background-position: center;
}
</style>