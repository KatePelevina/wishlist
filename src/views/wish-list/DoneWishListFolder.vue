<template>
    <div>
        
        <!-- <div class="items">
            <div class="item" v-for="wish in wishes" :key="wish.id">
                <div class="box">
                    <div class="box-inner">
                        <span v-if="wish.price" class="span">{{ wish.price }} руб</span>
                        <img :src="'/img/' + wish.photo" alt="">
                    </div>
                </div>
                <p class="box-inner__hover">{{ wish.name }}</p>
            </div>
        </div> -->

        <!-- <my-select
        v-model="selectedSort"
        :options="sortOptions" 
        /> -->

        <div class="flex rrrr">
            <div class="flex-left">
                <p class="ddddd">Кол-во желаний: {{ wishes.length }}</p>
            </div>
            <div class="div-button">
                <n-button @click="showModal=true" class="btn" strong secondary type="success">+ Добавить желание</n-button>
            </div>
            <!-- <div class="flex-right">
                <n-space vertical v-if="wishes.length">
                    <n-select v-model:value="selectedSort" :options="options" />
                </n-space>
            </div> -->
        </div>

        <!-- <n-space vertical v-if="wishes.length">
            <n-select v-model:value="selectedSort" :options="options" />
        </n-space> -->

        <my-input
        v-if="wishes.length"
        v-model="searchQuery"
        placeholder="Поиск..."
        />
        
        <DoneWishlist :wishes="sortedAndSearchedPosts"/>

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
                   <div class="add-box">
                       <h4 class="add-box-title">Добавить желание в эту папку</h4>
                       <form class="form" method="post" @submit.prevent="addWishList">
                           <n-input v-model:value="newWish.name" type="text" placeholder="Название" class="input" />
                           <n-input-number  v-model:value="newWish.price" type="text" placeholder="Цена"/>
                           <n-input v-model:value="newWish.description" type="text" placeholder="Описание" class="input"  />
                           <n-input v-model:value="newWish.link" type="text" placeholder="Ссылка" class="input" />
                           
                            <n-space vertical class="select">
                                <n-select v-model:value="newWish.visible" :options="visible" />
                            </n-space>

                            <n-space vertical class="select">
                                <n-select v-model:value="newWish.done" :options="done" />
                            </n-space>

                            <n-button strong secondary type="success" attr-type="submit" class="add-btn" @click="showModal=false; addWishList(); addPhoto()">Добавить желание</n-button>
                       </form>
                   </div>
               </div>
               
               </n-card>
           </n-modal>
       </div> 
      

        
    </div>
</template>

<script>
import axios from 'axios';
import { defineComponent, ref } from "vue";

import { NSpace, NSelect } from 'naive-ui';
import { NModal, NButton, NCard, NInput, NInputNumber  } from 'naive-ui';


import DoneWishlist from '@/components/wishes/DoneWishlist.vue';
import MyInput from '@/components/layout/MyInput.vue';
// import MySelect from '@/components/layout/MySelect.vue';



export default defineComponent ({
    name: "DoneWishListView",
    components: { 
        DoneWishlist,
        MyInput,
        NButton,
        NCard,
        NModal,
        NInput, 
        NInputNumber,
        NSpace, 
        NSelect 
    },
    data(){
        return {
            wishes:[],
            selectedSort: '',
            searchQuery: '',
            showModal: false,
            // sortOptions: [
            //     {value: 'name', name: 'По name'},
            //     {value: 'date', name: 'По date'},
            //     {value: 'price', name: 'По price'},
            //     {value: 'visible', name: 'По visible'},
            // ]
        }
    },
    methods: {
        // async getWishes(){
            
        //     await axios.get('http://localhost:8085/public/process.php?action=get-done-wishlist')
        //     .then((response)=>{
        //         this.wishes = response.data.wishes; 
        //         console.log(this.wishes)
        //     })
        //     .catch((error)=>{
        //         console.log(error)
        //     })
        // },
        async getDoneWishes(){
            
            let id = this.$route.params.id; 
            await axios.get('http://localhost:8085/public/process.php?action=get-done-wishlist-in-folder&id='+id)
            .then((response)=>{
                this.wishes = response.data.wishes; 
                console.log(this.wishes)
            })
            .catch((error)=>{
                console.log(error)
            })
        },
    },
    mounted() {
        // this.getWishes()
        this.getDoneWishes()
    },
    computed: {
        sortedPosts() {
            return [...this.wishes].sort((wish1, wish2) => wish1[this.selectedSort]?.localeCompare(wish2[this.selectedSort]))
        },
        sortedAndSearchedPosts() {
            return this.sortedPosts.filter(wish => wish.name.toLowerCase().includes(this.searchQuery.toLowerCase()))
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
                label: "По name",
                value: "name",
                },
                {
                label: "По date",
                value: "date"
                },
                {
                label: "По price",
                value: "price"
                },
                {
                label: "По visible",
                value: "visible"
                }
            ],
        };
    }
})

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
    border: 1px solid $bg;
    cursor: pointer;
    img {
        height: 100%;
        width: 100%;
    }
}
.box:hover {
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
    border: none;
}
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

.flex {
    @include flex;
}


.add-box {
    text-align: center;
    width: 50%;
    margin: auto;
    input {
        display: block;
        width: 100%;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 10px;
    }
}

.ddddd {
    text-align: center;
    background-color: $bg;
    width: 100%;
    padding: 6px;
    border-radius: 5px;
}

.flex-left, .flex-right {
    flex-basis: 49%;
}
.flex-right {
    button {
        width: 100%;
    }
}
</style>