<template>
    <div class="page">
  
    
    <h1 class="title">Все пользователи</h1>


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
            count_wishlist: '',
            count: '',
            pageNumber: 1,
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
                    label: "По firstName",
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