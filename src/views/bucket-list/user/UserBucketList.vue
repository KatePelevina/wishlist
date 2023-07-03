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
    



    <div>
        <h1 class="title">папка:{{ folder_name }}</h1>   
        <p v-if="folder_description">{{ folder_description }}</p>
    </div>
    
    
    <p v-for="user in users" :key="user.id">{{ user.firstName }} {{ user.secondName }}</p>

    <div class="flex">
        <h1>User Bucket List</h1>
        <img src="@/assets/location.svg" alt="icon" class="nav-item__icon" @click="$router.push(`/user-bucket-list-folders/user=${this.$route.params.id}`)"> 
    </div>


    <my-input
        v-model="searchQuery"
        placeholder="Поиск..."
    />

    <!-- <bucket-list-component
        :wishes="sortedAndSearchedPosts"
    /> -->


   

    <div class="items" v-if="wishes.length">
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

    </div>
</template>

<script>
import axios from 'axios';
import MyInput from '@/components/layout/MyInput.vue';


export default {
    name: 'WishListView',
    components: {
        MyInput,
    },
    data() {
        return {
            wishes: [],
            selectedSort: '',
            searchQuery: '',
            users: [],
            folder_name: "",
            folder_description: "",
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

            await axios.get('http://localhost:8085/public/process.php?action=get-user-from-folder-bucketlist&id='+id)
            .then((response)=>{
                this.users = response.data.users;
                console.log( this.users);
            })
        },
        async getFolder() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=bucketlist-folder&id='+id)
            .then((response)=>{
                this.folders = response.data.folders;

                this.folder_name = response.data.folders[0].name;
                this.folder_description = response.data.folders[0].description;
                this.currentFolder = response.data.folders[0];
            });

        },
    },
    mounted() {
        this.getWish()
        this.getUser()
        this.getFolder()
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

.page {
    @include page;
}

.flex {
    @include flex;
}
</style>

