<template>
    <div class="profile theme-element">
        <div  v-for="user in users" :key="user.id">

            <div>
                <!-- <router-link to="/image-load"> -->
                    <div class="flex">
                        <!-- <img class="photo" :src="'/img/' + user.img"/> -->
                        
                        <div class="flex">
                            <!-- <img class="photo" src="@/assets/photo.jpg" alt=""> -->
                            <img :src="'/img/' + user.img" alt="" class="photo" >

                            <div>
                                <p>{{ user.username }}</p>
                                <p>{{ user.firstName }} {{ user.secondName }}</p>   
                            </div>
                            
                        </div>
                        
                        <n-tooltip trigger="hover">
                            <template #trigger>
                                <div class="img-icon">
                                <img src="@/assets/setting.svg" alt="icon" class="nav-item__icon" @click="$router.push(`/edit-profile/user=${user.id}`)">
                            </div>
                        </template>
                            Редактировать аккаунт
                        </n-tooltip>
                        
                    </div>
                <!-- </router-link> -->
            </div>

            <div class="profile-text">
                <p>{{ user.about }}</p>
            </div>

            <div class="profile-items">
                <div class="i" @click="$router.push(`/my-wish-list-folders`)">
                    <p>{{ count_wishlist }}</p>
                    <p>Wish List</p>
                </div>
                <div class="i" @click="$router.push(`/my-bucket-list-folders`)">
                    <p>{{ count_bucketlist }}</p>
                    <p>Bucket List</p>
                </div>
                <div class="i" @click="$router.push(`/subscriptions`)">
                    <p>{{subs}}</p>
                    <p>Подписки</p>
                </div>
                <div class="i" @click="$router.push(`/followers`)">
                    <p>{{followers}}</p>
                    <p>Подписчики</p>
                </div>
            </div>


            

        </div>
    </div>

    <div v-if="showModal">
        
        <n-modal v-model:show="showModal">
            <n-card
            style="width: 600px"
            :bordered="false"
            size="huge"
            role="dialog"
            aria-modal="true"
            >
            <div>
                <button>Редактировать</button>
                <p>День рождения: 8 июня</p>
                <p>Город: Санкт-Петербург</p>

                <p>Мои пожелания</p>
                <p>Цветы</p>
                <p>Стоп-лист</p>
                <p>Алгоколь</p>
            </div>
            </n-card>
        </n-modal>
    </div>
</template>

<script>
import axios from 'axios';
import { NModal, NCard, NTooltip } from 'naive-ui'

export default {
    name: 'MyProfile',
    components: {
        NModal, 
        NCard,
        NTooltip
    },
    data() {
        return {
            users:[],
            currentUser: {},
            count_wishlist: "",
            count_bucketlist: "",
            followers: "",
            subs: "",
            showModal: false,
        }
    },
    methods: {
        async getUser(){
            await axios.get('http://localhost:8085/public/process.php?action=get-my-profile')
            .then((response)=>{
                this.users = response.data.users;
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        // async getCountPlaces(){
        //     await axios.get('http://localhost:8085/public/process.php?action=count-places')
        //     .then((response)=>{ 
        //         this.places = response.data.count;
        //     })
        //     .catch((error)=>{
        //         console.log(error)
        //     })
        // },
        async getCountWishList(){
            await axios.get('http://localhost:8085/public/process.php?action=count-wishlist')
            .then((response)=>{ 
                this.count_wishlist = response.data.count_wishlist;
                console.log(this.count_wishlist)
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async getCountBucketList(){
            await axios.get('http://localhost:8085/public/process.php?action=count-bucketlist')
            .then((response)=>{ 
                this.count_bucketlist = response.data.count_bucketlist;
                console.log(this.count_bucketlist)
            })
            .catch((error)=>{
                console.log(error)
            })
        },
         async getCountFollowers(){
            await axios.get('http://localhost:8085/public/process.php?action=count-followers')
            .then((response)=>{
                this.followers = response.data.count;  
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async getCountSubscriptions(){
            await axios.get('http://localhost:8085/public/process.php?action=count-subscriptions')
            .then((response)=>{
                this.subs = response.data.count; 
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        toFormData(obj){
            let fd = new FormData();
            for(let i in obj){
                fd.append(i,obj[i]);
            }
            return fd;
        },
        selectUser(user){
            this.currentUser = user;
        },
        // async submitFile(){
        //     let formData = new FormData();
        //     formData.append('file', this.file);
        //     await axios.post( 'http://localhost:8085/public/process.php?action=image-load',
        //         formData,
        //         {
        //         headers: {
        //             'Content-Type': 'multipart/form-data'
        //         }
        //         }
        //     )
        //     .then(function(){
        //         this.$router('/image-load');
        //         console.log('SUCCESS!!');
        //     })
        //     .catch(function(){
        //     console.log('FAILURE!!');
        //     });
        // },
        // handleFileUpload(){
        //     this.file = this.$refs.file.files[0];
        //     console.log(this.file);
        // },
    },
    mounted() {
        this.getUser(),
        this.getCountWishList(),
        this.getCountBucketList(),
        this.getCountFollowers(),
        this.getCountSubscriptions()
    }
}
</script>

<style scoped lang="scss">
@import "@/styles/_variables.scss";
    .profile {
        background-color: #fff;
        color: #000;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .profile-name {
        display: flex;
    }
    .profile-text {
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .profile-items {
        display: flex;
        flex-wrap: wrap;
        cursor: pointer;
    }
    .i {
        width: 50%;
        text-align: center;
        margin-bottom: 10px;
        font-size: 12px;
        padding: 5px;
    }
    .i:hover {
        background-color: #F6F7FF;
        border-radius: 10px;
        color: #6069E0;
    }
    .photo {
       @include photo;
       width: 60px;
       height: 60px;
    }

   
.flex {
    display: flex;
}

.stop {
    cursor: pointer;
}

.img-icon {
    cursor: pointer;
}
</style>
