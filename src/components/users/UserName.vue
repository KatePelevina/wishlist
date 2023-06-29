<template>
    <div>
        <div v-if="this.statusIn">
            <p class="card-text">{{ this.statusIn }}</p>
            <p>{{statusFol}}</p>
            <button class="unSubscribe" @click="unsubscribeUser(); statusOut=true">Отписаться</button>
        </div>
        <div v-if="this.statusOut">
            <p class="card-text">{{ this.statusOut }}</p>
            <p>{{statusFol}}</p>
            <button class="subscribe" @click="subscribe(); statusOut=false;">Подписаться</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default ({
    name: 'UserName',
    data(){
        return {
            statusIn: false,
            statusOut: false,
            users: []
        }
    },
    methods: {
        async getUserId() {
            let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-user&id='+id)
            .then((response)=>{
                this.users = response.data.users; 
                this.statusIn =  response.data.statusIn;
                this.statusOut =  response.data.statusOut; 
                this.statusFol = response.data.statusFol; 
            })
            
        },
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
                }else {
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
        testFunction() {
            this.$emit('testFunction')
        }
    }
})
</script>

<style>
    .photo {
       width: 40px;
       height: 40px;
       border-radius: 50%;
       background-color: "#ссс";
       margin-right: 10px;
       background-image: url('@/assets/photo.jpg');
       background-size: 40px;
   }
   .friend-item {
       display: flex;
       align-items: center;
   }
</style>
