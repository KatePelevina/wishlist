<template>
    <div class="page">

        <!-- <div v-if="users.length">
            <h1>Подписки {{ users.length }}</h1>
            <div class="card" v-for="user in users" :key="user.id" @click="$router.push(`/user-profile/${user.id}`)">
                <div class="card-header">
                    <div class="card-header__left">
                        <div class="photo">
                            <img class="photo" :src="'/img/' + user.img" />
                        </div>
                        <div>
                            <p class="card-text">{{ user.nickname }}</p>  
                            <p class="card-text">{{ user.firstName }} {{ user.secondName }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <p>пока ничего нет</p>
        </div> -->

        <h1 class="title">Мои подписки: {{ subs }}</h1>

        <div class="div-search" v-if="users.length">
            <label for="my-input" class="label">Поиск по никнейму</label>
            <my-input v-model="searchQuery" />
        </div>

        <n-space vertical v-if="users.length" class="sort">
            <n-select v-model:value="selectedSort" :options="options" />
        </n-space>

        
       

        <div v-if="users.length">
            <users-list :users="sortedAndSearchedPosts" />
        </div>
        <div v-else>
            <n-empty size="large" description="Нет подписок" class="empty"></n-empty>
        </div>

        <div v-intersection="loadMorePosts" class="observer"></div>

       
    </div>
</template>

<script>
import axios from 'axios';
import UsersList from '@/components/users/UsersList.vue';
import MyInput from '@/components/layout/MyInput.vue';
import { NEmpty } from 'naive-ui';
import { NSpace, NSelect } from 'naive-ui';

import { defineComponent, ref } from "vue";

export default defineComponent  ({
    name: 'SubscriptionsItem',
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
            selectedSort: '',
            searchQuery: '',
            page: 0,
            subs: ''
            // sortOptions: [
            //     {value: 'title', name: 'По названию'},
            //     {value: 'body', name: 'По содержимому'},
            // ]
        }
    },
    methods: {
        // async getSubscriptions(){
        //     await axios.get('http://localhost:8085/public/process.php?action=get-subscriptions')
        //     .then((response)=>{
        //         this.users = response.data.users; 
        //         this.status = "В подписках";
        //     })
        //     .catch((error)=>{
        //         console.log(error)
        //     })
        // },
        async loadMorePosts() {
            try {
                const response = await axios.post('http://localhost:8085/public/process.php?action=get-subscriptions', this.toFormData({
                    offset: this.page
                }))
                this.users = [...this.users, ...response.data.users];
                this.page += 1;
            } catch(e) {
                alert('Ошибка')
            } 
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
    },
    mounted() {
        // this.getSubscriptions()
        this.getCountSubscriptions()
    },
    computed: {
        sortedPosts() {
            return [...this.users].sort((user1, user2) => user1[this.selectedSort]?.localeCompare(user2[this.selectedSort]))
        },
        sortedAndSearchedPosts() {
            return this.sortedPosts.filter(
                user => user.nickname.toLowerCase().includes(this.searchQuery.toLowerCase()),
                
            )
        }
    },
    setup() {
        return {
            value: ref(null),
            options: [
                {
                label: "Сортировать",
                value: "",
                disabled: true
                },
                {
                label: "По никнейму",
                value: "nickname",
                },
                {
                label: "По имени",
                value: "firstName"
                },
                {
                label: "По фамилии",
                value: "secondName"
                }
            ]
        };
    }
})
</script>

<style lang="scss" scoped>
@import "@/styles/_variables.scss";
.page {
    @include page;
}
.div-search {
    margin-bottom: 20px;
}
.observer {
    height: 30px;
    background: green;
}
.title {
    margin-bottom: 20px;
    text-align: center;
}
.sort {
    margin-bottom: 20px;
}
.label {
    display: inline-block;
    margin-bottom: 5px;
}
</style>