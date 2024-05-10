<template>
    <div class="page">
  
 
     <!-- <div v-for="user in users" :key="user.id" @click="$router.push(`/user-profile/${user.id}`)">
       <div class="card" >
         <div class="card-header">
             <div class="card-header__left">
                 <div>
                     <img class="photo" :src="'/img/' + user.img" />
                 </div>
                 <div>
                     
                     <p class="card-text">{{ user.firstName }} {{ user.secondName }}</p>
                     <p class="card-text">{{ user.nickname }}</p>  
                 </div>
             </div>
             <div class="card-header__right">
                 
                 
                 
             </div>
         </div>
       </div>        
     </div> -->
    
    <h1 class="title">Все пользователи</h1>

    <!-- <my-select
    v-model="selectedSort"
    :options="sortOptions" 
    /> -->


    <div v-if="users.length" class="search">
        <label for="my-input">Поиск по никнейму</label>
        <my-input
        v-model="searchQuery"
        placeholder="Поиск..."
        />
    </div>

    <div class="sort">
        <n-space vertical v-if="users.length">
            <n-select v-model:value="selectedSort" :options="options" />
        </n-space>
    </div>
  


    
    
    
    <users-list 
    :users="sortedAndSearchedPosts" 
    
    />
    
    <div v-intersection="loadMoreUsers" class="observer"></div>
    

<!-- <n-pagination v-model:page="page" :page-count="pageCount" :click-handler="changePage" /> -->


</div>
</template>

<script>
import axios from 'axios';
import { defineComponent, ref } from "vue";

import UsersList from '@/components/users/UsersList.vue';
import MyInput from '@/components/layout/MyInput.vue';
import { NSpace, NSelect } from 'naive-ui';

export default defineComponent ({
    name: 'AllUsers',
    components: {
        UsersList,
        MyInput,
        NSpace,
        NSelect,
    },
    data() {
        return {
            users:[],
            selectedSort: '',
            searchQuery: '',
            // sortOptions: [
            //     {value: 'nickname', name: 'По nickname'},
            //     {value: 'firstName', name: 'По firstName'},
            //     {value: 'secondName', name: 'По secondName'},
            // ],
            count_wishlist: '',
            count: '',
            pageNumber: 1,
            // limit: 3,
            page: 0
            
        }
    },
    methods: {
        // async getAllUsers(){
        //     await axios.post('http://localhost:8085/public/process.php?action=read-users', this.toFormData({
        //         offset: 2
        //     }))
        //     .then((response)=>{
        //         this.users = response.data.users; 
        //     })
        //     .catch((error)=>{
        //         console.log(error)
        //     })

        // },

        //перестать загружать посты, когда дошли до конца 
        async loadMoreUsers() {
            try {
                const response = await axios.post('http://localhost:8085/public/process.php?action=read-users', this.toFormData({
                    offset: this.page
                }))
                // this.totalPages = Math.ceil(response.headers['x-total-count'] / this.limit)
                this.users = [...this.users, ...response.data.users];
                this.page += 1;
            } catch(e) {
                alert('Ошибка')
            } 
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
        // this.getAllUsers();
    },
    computed: {
            // pageCount() {
               
            //     return Math.ceil(this.users.length / this.limit);
            // },
            // displayedPosts () {
            //     return this.paginate(this.users);
            // },
            sortedPosts() {
                return [...this.users].sort((user1, user2) => user1[this.selectedSort]?.localeCompare(user2[this.selectedSort]))
            },
            // сейчас есть поиск только по никнейму, добавить по имени и фамилии
            sortedAndSearchedPosts() {
                return this.sortedPosts.filter(
                    user => user.nickname.toLowerCase().includes(this.searchQuery.toLowerCase())
                )
            }
    },
    setup() {
        return {
            value: ref(null),
            // page: ref(0),
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
.page {
    @include page;
}
.observer {
    height: 30px;
    background: green;
}
.title {
    text-align: center;
    margin-bottom: 20px;
}
.sort {
    margin-bottom: 20px;
}
.search {
    margin-bottom: 20px;
}
</style>