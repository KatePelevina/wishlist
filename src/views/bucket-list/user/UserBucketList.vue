<template>
    <div class="page">

   

    <!-- <div class="flex">
        <h1>Wish List | Сумки</h1>
        <button>Поделиться</button>
    </div>
    
    <select name="" id="" placeholder="Забронировано">
        <option value="1">Свободно</option>
        <option value="2">Забронировано</option>
    </select> -->

    <!-- <bucket-list /> -->
    
    <!-- <div class="items" v-if="wishes.length">
        <div class="item" v-for="(wish,index) in wishes" :key="index">
            <div class="box" @click="$router.push(`/user-bucket-list-item/${wish.id}`)">
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

    <!-- <p v-for="user in users" :key="user.id">{{ user.firstName }} {{ user.secondName }}</p> -->

    <div class="flex-left color">
        <div class="popover">
        <n-popover trigger="hover">
            <template #trigger>
                <n-space @click="$router.push(`/user-bucket-list-folders/user=${this.$route.params.id}`)">
                  <n-icon size="25" @click="showInfo=true">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M408 96H252.11a23.89 23.89 0 0 1-13.31-4L211 73.41A55.77 55.77 0 0 0 179.89 64H104a56.06 56.06 0 0 0-56 56v24h416c0-30.88-25.12-48-56-48z" fill="currentColor"></path><path d="M423.75 448H88.25a56 56 0 0 1-55.93-55.15L16.18 228.11v-.28A48 48 0 0 1 64 176h384.1a48 48 0 0 1 47.8 51.83v.28l-16.22 164.74A56 56 0 0 1 423.75 448zm56.15-221.45z" fill="currentColor"></path></svg>                  
                  </n-icon>
                </n-space>
            </template>
            <span>Просмотр желаний в папках</span>
        </n-popover>
        </div>
        <h1>User BUCKETLIST</h1>
        <!-- <img src="@/assets/location.svg" alt="icon" class="nav-item__icon" @click="$router.push(`/user-bucket-list-folders/user=${this.$route.params.id}`)">  -->
    </div>


    <div class="select" v-if="wishes.length">
        <n-space vertical>
            <n-select v-model:value="selectedSort" :options="options" />
        </n-space>
    </div>

    <div class="search">
        <my-input
        v-model="searchQuery"
        placeholder="Поиск..."
        />
    </div>
    

    <UserBucketList 
        :wishes="sortedAndSearchedPosts"
    />


   

    <!-- <div class="items" v-if="wishes.length">
        <div class="item" v-for="(wish,index) in wishes" :key="index">
            <div class="box" @click="$router.push(`/user-bucket-list-item/${wish.id}`)">
                <div class="box-inner">
                    <span v-if="wish.price" class="span">{{ wish.price }} руб</span>
                    <img :src="'/img/' + wish.photo" alt="">
                </div>
            </div>
            <p class="box-inner__hover">{{ wish.name }}</p>
            <p class="box-inner__hover">{{ wish.date }}</p>
            <p class="box-inner__hover">{{ wish.visible }}</p>
            <p class="box-inner__hover">done:{{ wish.done }}</p>
        </div>
    </div> -->

    </div>
</template>

<script>
import axios from 'axios';
import MyInput from '@/components/layout/MyInput.vue';
import UserPage from '@/components/users/UserPage.vue';
import UserBucketList from '@/components/users/UserBucketList.vue'

import { NSpace, NSelect } from 'naive-ui';

import { defineComponent, ref } from "vue";
import { NPopover, NIcon } from 'naive-ui';


export default defineComponent ({
    name: 'WishListView',
    components: {
        MyInput,
        UserPage,
        NSpace, 
        NSelect,
        UserBucketList,
        NPopover, 
        NIcon
    },
    data() {
        return {
            wishes: [],
            selectedSort: '',
            searchQuery: '',
            users: [],
        }
    },
    methods: {
        async getWish() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-user-bucketlist&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes;
            })
        },
        async getUser() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-user&id='+id)
            .then((response)=>{
                this.users = response.data.users;
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

.page {
    @include page;
}

.flex {
    @include flex;
}
.flex-left {
    display: flex;
    justify-content: start;
    align-items: center;
    margin-bottom: 20px;
}
.popover {
    margin-right: 10px;
    cursor: pointer;
}
.select {
    margin-bottom: 20px;
}
.search {
    margin-bottom: 20px;
}
</style>

