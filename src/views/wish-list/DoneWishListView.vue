<template>
    <div>
        
        <div class="flex rrrr">
            <div class="flex-left">
                <p class="ddddd" v-if="wishes.length">Количество желаний: {{ wishes.length }}</p>
            </div>
           
        </div>

        <n-space vertical v-if="wishes.length">
            <n-select v-model:value="selectedSort" :options="options" />
        </n-space>

        <my-input
            v-if="wishes.length"
            v-model="searchQuery"
            placeholder="Поиск..."
        />
        
        <DoneWishlist :wishes="sortedAndSearchedPosts"/>
        
    </div>
</template>

<script>
import axios from 'axios';
import { defineComponent, ref } from "vue";
import DoneWishlist from '@/components/wishes/DoneWishlist.vue';
import MyInput from '@/components/layout/MyInput.vue';

export default defineComponent ({
    name: "DoneWishListView",
    components: { 
        DoneWishlist,
        MyInput
    },
    data(){
        return {
            wishes:[],
            selectedSort: '',
            searchQuery: '',
            showModal: false,
            newWish: { 
               name: "", 
               price: "",
               description: "",
               photo: "",
               link: "",
               visible: "0",
               folder_id: "",
               done: "0",
           },
        }
    },
    methods: {
        async getWishes(){
            
            await axios.get('http://localhost:8085/public/process.php?action=get-done-wishlist')
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
    margin-bottom: 20px;
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