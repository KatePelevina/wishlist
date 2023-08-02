<template>
    <div class="page">

   
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

    <UserPage />



    <div class="flex">
        <h1>User Wish List</h1>
        <img src="@/assets/location.svg" alt="icon" class="nav-item__icon" @click="$router.push(`/user-wish-list-folders/user=${this.$route.params.id}`)"> 
    </div>

    <div class="select" v-if="wishes.length">
        <n-space vertical>
            <n-select v-model:value="selectedSort" :options="options" />
        </n-space>
    </div>
    
    <my-input
        v-if="wishes.length"
        v-model="searchQuery"
        placeholder="Поиск..."
    />

    <user-wish-list :wishes="sortedAndSearchedPosts"/>
    
    </div>
</template>

<script>
import axios from 'axios';
import MyInput from '@/components/layout/MyInput.vue';
import UserWishList from '@/components/users/UserWishList.vue';
import UserPage from '@/components/users/UserPage.vue';
import { NSpace, NSelect } from 'naive-ui';

import { defineComponent, ref } from "vue";




export default defineComponent({
    components: {
        MyInput,
        UserWishList,
        UserPage,
        NSpace, 
        NSelect 
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
        async getUser() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-user-from-folder-wishlist&id='+id)
            .then((response)=>{
                this.users = response.data.users;
                console.log( this.users);
            })
        },
    },
    mounted() {
        this.getWish()
        this.getUser()
    },
    computed: {
        sortedPosts() {
            return [...this.wishes].sort((wish1, wish2) => wish1[this.selectedSort]?.localeCompare(wish2[this.selectedSort]))
        },
        sortedAndSearchedPosts() {
            return this.sortedPosts.filter(wish => wish.name.toLowerCase().includes(this.searchQuery.toLowerCase()))
        }
    },
    setup() {
        return {
            value: ref(null),
            options: [
                {
                label: "Сортировать по",
                value: "",
                disabled: true
                },
                {
                label: "По названию",
                value: "name",
                },
                {
                label: "По цене",
                value: "price"
                },
                {
                label: "По дате создания",
                value: "date"
                },
                {
                label: "По visible",
                value: "visible"
                },
            ]            
        };
    }
})
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

.page {
    @include page;
}
.flex {
    @include flex;
}
</style>