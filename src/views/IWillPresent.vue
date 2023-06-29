<template>
    <div>
        <!-- <div class="items" v-if="wishes.length" >
            <div class="item" v-for="(wish,index) in wishes" :key="index">
                <div class="box" @click="$router.push(`/i-will-present-item/${wish.id}`)">
                    <div class="box-inner">
                        <span v-if="wish.price" class="span">{{ wish.price }} руб</span>
                        <img :src="'/img/' + wish.photo" alt="">
                    </div>
                </div>
                <p>{{ wish.name }}</p>
                <p class="box-inner__hover">Я подарю <strong>{{ wish.nickname }}</strong></p>
            </div>  
        </div> -->

        <my-input
        v-model="searchQuery"
        placeholder="Поиск..."
        />

        <IWillPresent :wishes="sortedAndSearchedPosts"/>
    </div>
</template>

<script>
import axios from 'axios';
import IWillPresent from '@/components/wishes/IWillPresent.vue';
import MyInput from '@/components/layout/MyInput.vue';



export default {
    name: 'IWillPresentView',
    data() {
        return {
            wishes:[],
            selectedSort: '',
            searchQuery: '',
        }
    },
    components: { 
        IWillPresent,
        MyInput
    },
    methods: {
        async getWishes(){

            await axios.get('http://localhost:8085/public/process.php?action=get-i-will-present-wishes')
            .then((response)=>{
                this.wishes = response.data.wishes;

                console.log(response.data);
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
    border: 1px solid $bg;
    cursor: pointer;
    img {
        height: 100%;
        width: 100%;
        object-fit: cover;
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

.button {
    @include button;
    width: 100%;
}

</style>