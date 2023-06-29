<template>
    <div>
        <!-- <div class="card" v-for="(user,index) in users" :key="index">
            <img class="photo" :src="'/img/' + user.img" />
            <p>{{ user.nickname }}</p>
            <button @click="$router.push(`/user-profile/${user.id}`)">Перейти в профиль</button>
        </div> -->

    <h1>User Wish List</h1>

        <p>user-wish-list-folders</p>
    </div>
</template>

<script>
import axios from 'axios';


// import UserPage from '@/components/users/UserPage.vue';

export default {
    // components: {
    //     UserPage
    // },
    data() {
        return {
            users:[],
            wishes: []
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
    }
   
}

</script>

<style lang="scss" scoped>
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