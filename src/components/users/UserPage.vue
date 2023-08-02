<template>

    <msg-component
        :errorMsg="this.errorMsg"
        :successMsg="this.successMsg"
    />

    <div class="profile">        
        
        <div v-for="user in users" :key="user.id">

            <div class="flex">
                <div class="flex">
                    <div v-if="user.img">
                        <img class="photo" :src="'/img/' + user.img" />
                    </div>
                    <div v-else>
                        <img class="photo" :src="'/img/landscape.png'" />
                    </div>
                    <div>
                        <p>{{ user.nickname }}</p>
                        <p>{{ user.firstName }} {{ user.secondName }}</p> 

                        <!-- Подписчик -->
                        <p> {{ FolYes }} </p>

                        <!-- В подписках -->
                        <!-- <p>{{ statusIn }}</p> -->

                        <!-- <p>{{ statusOut }}</p> -->
                        <!-- <p class="card-text">{{ this.statusIn }}</p>
                        <p class="card-text">{{ this.statusOut }}</p> -->

                        <!-- <div v-if="statusOut">
                            <button v-if="FolNo">Подписаться в ответ</button>
                        </div> -->

                    </div>
                </div>
                <div>
                    <user-name @testFunction="testFunction" />
                        <!-- <div v-if="this.statusIn">
                            <button class="unSubscribe" @click="unsubscribeUser(); statusOut=true">Отписаться</button>
                        </div>
                        <div v-else>
                            <button class="subscribe" @click="subscribe(); statusOut=false; testFunction()">Подписаться</button>
                        </div> -->

                            <div v-if="this.statusOut">
                            <button v-if="FolYes" @click="subscribe(); statusOut=false;">Подписаться в ответ</button>
                            <n-button strong secondary type="success" v-else class="subscribe" @click="subscribe(); statusOut=false; testFunction()">Подписаться</n-button>
                        </div>
                        <div v-else>
                            <img src="@/assets/setting.svg" alt="icon" class="nav-item__icon" @click="showModal=true">
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
                                    <div class="add-component__modal"> 
                                        <h4>Мои препочтения</h4>
                                        <p>Цветы: розы</p>
                                        <br />
                                        <h4>Стоп-лист</h4>
                                        <p>Сладкое</p>
                                        <p>Алкоголь</p>
                                        <br />
                                        <p>День рождения: 31 августа 1995 г.</p>
                                        <p>Страна: Черногория</p>
                                        <p>Город: Подгорица</p>
                                        <br />
                                        <n-button  strong secondary type="error" @click="showModal=false; unsubscribeUser(); statusOut=true">Отписаться</n-button>
                                        
                                    </div>
                                </n-card>
                            </n-modal>
                    </div> 
                </div>
            </div>
            <!-- <div class="profile-text">
                <p @click="showStopList=true" class="stop">Подробнее</p>
                <p>День рождения: 31 августа</p>
            </div> -->


            <div class="profile-items">
                <div class="i" @click="showWishlistFolders=true">
                    <p>Wish List</p>
                    <p>{{ count_wishlist }} </p>
                </div>
                <!-- <div class="i" @click="$router.push(`/user-bucket-list-folders/user=${user.id}`)"> -->
                <div class="i" @click="$router.push(`/user-bucket-list/user=${user.id}`)">
                    <p>Bucket List</p>
                    <p>{{ count_bucketlist }}</p>
                </div>
                <div class="i active" @click="showUserSubs=true">
                    <p>Подписки</p>
                    <p>{{subsCount}}</p>
                </div>
                <div class="i active" @click="showUserFollowers=true">
                    <p>Подписчики</p>
                    <p>{{followersCount}}</p>
                </div>
                
            </div>

            <!-- <div>
                <img src="@/assets/location.svg" alt="icon" class="nav-item__icon" @click="$router.push(`/user-bucket-list/user=${user.id}`)"> 
                <img src="@/assets/location.svg" alt="icon" class="nav-item__icon" @click="$router.push(`/user-bucket-list-folders/user=${user.id}`)"> 
            </div> -->
        
            <hr>

            <!-- Delete User Model -->
            <div id="overlay" v-if="showDeleteModal">
                <div class="add-component__modal">
                    <button type="button" class="close" @click="showDeleteModal=false">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5>Удалить user</h5>
                    <div>
                        <h4>Удалить user '{{ currentUser.nickName  }}'? </h4>
                        <button @click="showDeleteModal=false; unsubscribeUser(); clearMsg();" class="red">Да</button>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <button @click="showDeleteModal=false" class="green">Нет</button>
                    </div>
                </div>
            </div>

            <div v-if="showUserFollowers">
                
                <n-modal v-model:show="showUserFollowers">
                    <n-card
                    style="width: 600px"
                    :bordered="false"
                    size="huge"
                    role="dialog"
                    aria-modal="true"
                    >
                    <div class="add-component__modal">
                        <div class="flex">
                            <h4>Подписчики {{ followers.length }}</h4>
                            <button type="button" class="close" @click="showUserFollowers=false">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div v-if="followers.length">
                            <div v-for="follower in followers" :key="follower.id">
                            <!-- <p @click="this.$router.push(`/user/${follower.id}`)">{{ follower.nickName }}</p>    -->
                            
                            <!-- <div @click="this.$router.push(`/user-wish-list/${follower.id}`)">
                                <p @click="showUserFollowers=false">{{ follower.nickName }}</p>  
                            </div> -->

                            <div class="img">
                                <img :src="'/img/' + follower.img" alt="" class="nav-item__icon">
                                <a :href="`/user-wish-list/user=${follower.id}`">{{ follower.nickname }}</a>
                            </div>
                            
                        
                            
                        </div>
                        </div>
                        <div v-else>
                            <p>пока ничего нет</p>
                        </div>
                        
                    </div>
                    </n-card>
                </n-modal>
            </div>

            <div v-if="showUserSubs">
                <n-modal v-model:show="showUserSubs">
                    <n-card
                    style="width: 600px"
                    :bordered="false"
                    size="huge"
                    role="dialog"
                    aria-modal="true"
                    >
                    <div class="add-component__modal">
                        <div class="flex">
                            <h4>Подписки {{ subs.length }}</h4>
                            <button type="button" class="close" @click="showUserSubs=false">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div>
                            <div v-if="subs.length">
                                <div v-for="sub in subs" :key="sub.id" >
                                    <!-- <div @click="$router.push(`/user-wish-list/${sub.id}`)">
                                        <p>{{ sub.nickName }}</p>
                                    </div> -->
                                
                                    <div class="img">
                                        <img :src="'/img/' + sub.img" alt="" class="nav-item__icon">
                                        <a :href="`/user-wish-list/user=${sub.id}`">{{ sub.nickname }}</a>
                                    </div>
                                    
                                </div>
                            </div>
                            <div v-else>
                                <p>пока ничего нет</p>
                            </div>
                        </div>
                    
                    </div>
                    </n-card>
                </n-modal>
            </div>

            <div v-if="showStopList">
                
                <n-modal v-model:show="showStopList">
                    <n-card
                    style="width: 600px"
                    :bordered="false"
                    size="huge"
                    role="dialog"
                    aria-modal="true"
                    >
                    <div>
                        
                        <h4>Мои препочтения</h4>
                        
                        <p>Цветы: розы</p>
                        <h4>Стоп-лист</h4>
                        <p>Сладкое</p>
                        <p>Алкоголь</p>
                    </div>
                    </n-card>
                </n-modal>
            </div>

            <div v-if="showWishlistFolders">
                <n-modal v-model:show="showWishlistFolders">
                    <n-card
                    style="width: 600px"
                    :bordered="false"
                    size="huge"
                    role="dialog"
                    aria-modal="true"
                    >
                    <div>
                        
                        <p>user-wish-list-folders</p>
                        <div class="cards" v-if="folders.length">
                            <div class="card-test" v-for="(folder,index) in folders" :key="index" @click="$router.push(`/user-wish-list-folders/folder=${folder.id}`)">
                                <p>{{ folder.name }}</p>
                            </div>
                        </div>
                    </div>
                    </n-card>
                </n-modal>
            </div>
    

        </div> 
    </div>  
</template>

<script>

import axios from 'axios';

import UserName from '@/components/users/UserName.vue'
import MsgComponent from '@/components/layout/MsgComponent.vue'

// import { NModal, NCard, NTabs, NTabPane} from 'naive-ui'

// import WishList from '@/components/WishList.vue'
// import BucketList from '@/components/BucketList.vue';
// import UserWishListItem from '@/views/wish-list/UserWishListItem.vue';
// import UserBucketListItem from '@/views/bucket-list/UserBucketListItem.vue';

// import UserWishList from '@/views/wish-list/UserWishList.vue';

import { NModal, NCard, NButton } from 'naive-ui';




export default {
    name: 'UserPage',
    components: {
        UserName,
        // WishList,
        MsgComponent,
        NModal,
        NCard,
        NButton
        // NTabs,
        // NTabPane,
        // BucketList,
        // UserWishListItem,
        // UserBucketListItem,
        // UserWishList,
    },
    data() {
        return {
            errorMsg: "",
            successMsg: "",
            users:[],
            places:[],
            folders: [],

            currentUser: {},
            
            statusIn: false,
            statusOut: false,

            statusFol: "",

            FolYes: "",
            FolNo: "",

            user: "",
            count_wishlist: "",
            count_bucketlist: "",
            subsCount: "",
            followersCount: "",
            
            followers: [],
            subs: [],
            
            follId: "",

            showModal: false,
            showDeleteModal: false,
            showStopList: false,
            showUserFollowers: false,
            showUserSubs: false,
            showWishlistFolders: false,
        }

    },
    methods: {
        async getUserId() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-user&id='+id)
            .then((response)=>{
                console.log(response.data.statusFolFalse)
                this.users = response.data.users; 
                this.statusIn =  response.data.statusIn;
                this.statusOut =  response.data.statusOut; 
                this.FolYes = response.data.FolYes; 
                this.FolNo = response.data.FolNo; 
            })
            
        },
        // async followerPage(follower) {
        //     this.$router.push(`/user/${follower.id}`)
        // },
        async subscribe(){
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=subscribe&id='+id)
            .then((response)=>{
                this.users = response.data.users;
                if(response.data.error){
                    this.errorMsg = response.data.message;
                }else {
                    this.successMsg = response.data.message;    
                    this.getUserId();  
                    this.statusIn = "В подписках";
                    this.statusOut =  false; 
                }
                
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async unsubscribeUser() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=unsubscribe&id='+id)
            .then((response)=>{
                this.users = response.data.users;
                if(response.data.error){
                    this.errorMsg = response.data.message;
                } else {
                    this.successMsg = response.data.message;
                    this.getUserId();
                    this.statusOut = "Не в подписках";
                    this.statusIn = false;
                }
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
        clearMsg(){
            this.errorMsg = "";
            this.successMsg = "";
        },
        // async getUser(){
        //     await axios.get('http://localhost:8085/public/process.php?action=get-user')
        //     .then((response)=>{
        //         this.users = response.data.users; 
        //     })
        //     .catch((error)=>{
        //         console.log(error)
        //     })
        // },
        async getUserPlaces() {
            let id = this.$route.params.id;
            await axios.get('http://localhost:8085/public/process.php?action=get-user-places&id='+id)
            .then((response)=>{
                this.places = response.data.places;
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async getUserFollowers(){
            let id = this.$route.params.id;
            await axios.get('http://localhost:8085/public/process.php?action=get-user-followers&id='+id)
            .then((response)=>{
                this.followers = response.data.followers;
                console.log( this.followers);
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async getUserSubs(){
            let id = this.$route.params.id;
            await axios.get('http://localhost:8085/public/process.php?action=get-user-subs&id='+id)
            .then((response)=>{
                this.subs = response.data.subs;
                console.log( this.subs);
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async selectUser(user){
            this.currentUser = user;
        },
        async getCountWishlist() {
            let id = this.$route.params.id;
            await axios.get('http://localhost:8085/public/process.php?action=count-user-wishlist&id='+id)
            .then((response)=>{ 
                this.count_wishlist = response.data.count_wishlist;
                console.log(response.data)
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async getCountBucketlist() {
            let id = this.$route.params.id;
            await axios.get('http://localhost:8085/public/process.php?action=count-user-bucketlist&id='+id)
            .then((response)=>{ 
                this.count_bucketlist = response.data.count_bucketlist;
                console.log(response.data)
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async getCountSubscriptionOfUser(){
            
            let id = this.$route.params.id;
            await axios.get('http://localhost:8085/public/process.php?action=count-user-susubscriptions&id='+id)
            .then((response)=>{ 
                this.subsCount = response.data.count;
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async getCountFollowersOfUser(){
            
            let id = this.$route.params.id;
            await axios.get('http://localhost:8085/public/process.php?action=count-user-followers&id='+id)
            .then((response)=>{ 
                this.followersCount = response.data.count;
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async testFunction() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-user&id='+id)
            .then((response)=>{
                
                this.statusIn =  response.data.statusIn;
                this.statusOut =  response.data.statusOut; 
                 
            })
        },
        async getFolders() {
            let id = this.$route.params.id; 

            await axios.get('http://localhost:8085/public/process.php?action=get-user-wishlist-folders&id='+id)
            .then((response)=>{
                this.folders = response.data.folders; 
                
                console.log(this.folders)
            })
            .catch((error)=>{
                console.log(error)
            })
        },
    },
    mounted() {
        this.getUserId(),
        this.getCountWishlist(),
        this.getCountBucketlist(),
        this.getCountSubscriptionOfUser(),
        this.getCountFollowersOfUser(),
        this.getUserPlaces(),
        this.getUserFollowers(),
        this.getUserSubs(),
        this.getFolders()
    },
     // computed: {
    //     sortedPosts() {
    //         return [...this.folders].sort((folder1, folder2) => folder1[this.selectedSort]?.localeCompare(folder2[this.selectedSort]))
    //     },
    //     sortedAndSearchedPosts() {
    //         return this.sortedPosts.filter(folder => folder.name.toLowerCase().includes(this.searchQuery.toLowerCase()))
    //     }
    // },
}
</script>

<style scoped lang="scss">
@import "@/styles/_variables.scss";

.flex {
    @include flex;
    // margin-bottom: 20px;
    // background-color: #ccc;
}
.photo {
    @include photo;
}
.button {
    @include button;
}

.profile {
    background-color: #fff;
    border-radius: 10px;
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
    cursor: default;
}
.active:hover {
    background-color: #F6F7FF;
    border-radius: 10px;
    color: #6069E0;
    cursor: pointer;
}


.stop {
    cursor: pointer;
} 
.user-actions {
    cursor: pointer;
}

.nav-item__icon {
    margin-right: 15px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.img {
    display: flex;
    align-items: center;
}


.cards {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}
.card-test {
    flex-basis: 49%;
    border-radius: 10px;
    background-color: #ccc;
    padding: 30px;
    margin-bottom: 10px;
    cursor: pointer;
    img {
        width: 100%;
    }
}
// .subscribe {
//    padding: 15px 20px;
//    border-radius: 10px;
//    border: none;
// }

.profile-items {
    margin-top: 30px;
}
</style>