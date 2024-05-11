<template>
    <div class="page">

        <div class="flex">
            <h1>User Bucket List</h1>
            <img src="@/assets/location.svg" alt="icon" class="nav-item__icon" @click="$router.push(`/user-wish-list-folders/user=${this.$route.params.id}`)"> 
        </div>

        <p v-for="user in users" :key="user.id">{{ user.firstName }} {{ user.secondName }}</p>

        <my-input
            v-if="wishes.length"
            v-model="searchQuery"
            placeholder="Поиск..."
        />

        <user-bucket-list :wishes="sortedAndSearchedPosts"/>
    
    </div>
</template>

<script>
import axios from 'axios';
import MyInput from '@/components/layout/MyInput.vue';
import UserBucketList from '@/components/users/UserBucketList.vue';


export default {
    components: {
        MyInput,
        UserBucketList,
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

            await axios.get('http://localhost:8085/public/process.php?action=get-user-bucketlist-in-folder&id='+id)
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

.page {
    @include page;
}
.flex {
    @include flex;
}
</style>