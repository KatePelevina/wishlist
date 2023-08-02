<template>
    <div class="page">
        
      
        
        <!-- <div v-if="users.length">
        
        <a href="#">
            <div class="card" v-for="user in users" :key="user.id" @click="$router.push(`/user-profile/${user.id}`)">
                <div class="card-header">
                    <div class="card-header__left">
                        <img class="photo" :src="'/img/' + user.img" />
                        <div>
                            <p class="card-text">{{ user.nickname }}</p>  
                            <p class="card-text">{{ user.firstName }} {{ user.secondName }}</p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </a>
        </div>
        <div v-else>
            <p>пока ничего нет</p>
        </div> -->

        <div class="page-title">
            <!-- <h1>Мои подписчики {{ users.length }}</h1> -->
            <h1>Мои подписчики: {{ followers }}</h1>
        </div>

        <n-space vertical>
            <n-select v-model:value="selectedSort" :options="options" />
        </n-space>

        <my-input
        v-if="users.length"
        v-model="searchQuery"
        placeholder="Поиск..."
        />

        <div v-if="users.length">
            <users-list :users="sortedAndSearchedPosts" />
        </div>
        <div v-else>
            <n-empty size="large" description="Нет подписчиков" class="empty"></n-empty>
        </div>

        <div v-intersection="loadMorePosts" class="observer"></div>


    </div>
</template>

<script>
import axios from 'axios';
import { defineComponent, ref } from "vue";

import { NEmpty } from 'naive-ui';
import { NSpace, NSelect } from 'naive-ui';

import UsersList from '@/components/users/UsersList.vue';
import MyInput from '@/components/layout/MyInput.vue';



export default defineComponent( {
    name: 'FollowersView',
    components: {
        UsersList,
        MyInput,
        NEmpty,
        NSpace,
        NSelect
    },
    data() {
        return {
            users:[],
            count: "",
            selectedSort: '',
            searchQuery: '', 
            page: 0,
            followers: ''
        }
    },
    methods: {
        // async getFollowers(){
        //     await axios.get('http://localhost:8085/public/process.php?action=get-followers')
        //     .then((response)=>{
        //         this.users = response.data.users; 
        //         this.status = "Подписчик";
        //     })
        //     .catch((error)=>{
        //         console.log(error)
        //     })
        // },
        async loadMorePosts() {
            try {
                const response = await axios.post('http://localhost:8085/public/process.php?action=get-followers', this.toFormData({
                    offset: this.page
                }))
                this.users = [...this.users, ...response.data.users];
                this.page += 1;
            } catch(e) {
                alert('Ошибка')
            } 
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
        toFormData(obj){
            let fd = new FormData();
            for(let i in obj){
                fd.append(i,obj[i]);
            }
            return fd;
        },
    },
    mounted() {
        // this.getFollowers()
        this.getCountFollowers()
    },
    computed: {
            sortedPosts() {
                return [...this.users].sort((user1, user2) => user1[this.selectedSort]?.localeCompare(user2[this.selectedSort]))
            },
            sortedAndSearchedPosts() {
                return this.sortedPosts.filter(
                    user => user.nickname.toLowerCase().includes(this.searchQuery.toLowerCase())
                )
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
                label: "По nickname",
                value: "nickname",
                },
                {
                label: "По дате firstName",
                value: "firstName"
                },
                {
                label: "По secondName",
                value: "secondName"
                }
            ],
        };
    }
})
</script>

<style lang="scss" scoped>
@import "@/styles/_variables.scss";
.page-title {
    background-color: #fff;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 10px;
}
.page {
    @include page;
}
.observer {
    height: 30px;
    background: green;
}
</style>