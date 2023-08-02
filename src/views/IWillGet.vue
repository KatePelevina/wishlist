<template>
    <div class="page">
        <!-- <div class="items" v-if="wishes.length" >
            <div class="item" v-for="(wish,index) in wishes" :key="index">
                <div class="box" @click="$router.push(`/i-will-present-item/${wish.id}`)">
                    <div class="box-inner">
                        <span v-if="wish.price" class="span">{{ wish.price }} руб</span>
                        <img :src="'/img/' + wish.photo" alt="">
                    </div>
                </div>
                <p>{{ wish.name }}</p>
                <p class="box-inner__hover"><strong>{{ wish.nickname }} подарит мне</strong></p>
                
            </div>  
        </div> -->

        <my-input
        v-if="wishes.length"
        v-model="searchQuery"
        placeholder="Поиск..."
        />

        <IWillGet :wishes="sortedAndSearchedPosts"/>

    </div>
</template>

<script>
import axios from 'axios';
import IWillGet  from '@/components/wishes/IWillGet.vue';
import MyInput from '@/components/layout/MyInput.vue';



export default {
    name: 'WishListView',
    data() {
        return {
            wishes:[],
            selectedSort: '',
            searchQuery: '',
        }
    },
    components: { 
        IWillGet,
        MyInput
    },
    methods: {
        async getWishes(){

            await axios.get('http://localhost:8085/public/process.php?action=get-i-will-get-wishes')
            .then((response)=>{
                this.wishes = response.data.wishes;
                console.log(this.wishes);
            })
            .catch((error)=>{
                console.log(error)
            })
        },
    },
    mounted() {
        this.getWishes()
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
    img {
        height: 210px;
    }
   
}
.box:hover {
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
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
}
.item {
   width: 49%;
   margin-bottom: 10px;
}
.page {
    @include page;
}
</style>