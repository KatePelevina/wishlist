<template>
    <div>
       
        <div class="flex">
            <div class="flex-left flex-item" v-if="wishes.length">
                <p class="ddddd">Количество желаний: {{ wishes.length }}</p>
            </div>
            <div class="flex-item">
                <n-space vertical v-if="wishes.length" >
                    <n-select v-model:value="selectedSort" :options="options" />
                </n-space>
            </div>
        </div>
       
        <my-input
            v-if="wishes.length"
            v-model="searchQuery"
            placeholder="Поиск..."
        />

        <DoneBucketlist
        :wishes="sortedAndSearchedPosts"
        />
        

    </div>
</template>

<script>
  import axios from 'axios';
  import { defineComponent, ref } from "vue";

  import { NSpace, NSelect } from 'naive-ui';

  import DoneBucketlist from '@/components/wishes/DoneBucketlist.vue';
  import MyInput from '@/components/layout/MyInput.vue';



  export default defineComponent ({
    name: "DoneBucketListView",
    components: { 
        DoneBucketlist,
        MyInput,
        NSpace,
        NSelect,
    },
    data(){
        return {
            wishes:[],
            // selectedSort: '',
            // searchQuery: '',
            // sortOptions: [
            //     {value: 'name', name: 'По name'},
            //     {value: 'date', name: 'По date'},
            //     {value: 'price', name: 'По price'},
            //     {value: 'visible', name: 'По visible'},
            // ],
        }
    },
    methods: {
        async getWishes(){
            let id = this.$route.params.id;
            
            await axios.get('http://localhost:8085/public/process.php?action=get-done-bucketlist-in-folder&id='+id)
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
                    label: "По названию",
                    value: "name",
                },
                {
                    label: "По дате создания",
                    value: "date"
                },
                {
                    label: "По цене",
                    value: "price"
                },
                {
                    label: "По видимости",
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
    img {
        height: 100%;
        width: 100%;
    }
    background-color: #fff;
    text-align: center;
    position: relative;
    p {
        opacity: 0;
    }
}
.box:hover {
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
    p {
        opacity: 1;
        position: absolute;
        bottom: 10px;
        left: 10px;
    }
}
// .box-inner {
//     background-color: #fff;
//     text-align: center;
//     position: relative;
//     p {
//         opacity: 0;
//     }
// }
// .box-inner:hover {
//     p {
//         opacity: 1;
//         position: absolute;
//         bottom: 10px;
//         left: 10px;
//     }
// }

.items {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}
.item {
   width: 49%;
   margin-bottom: 10px;
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
.flex-right  {
  button {
    width: 100%;
  }
}
.flex-item {
    width: 49%;
}
</style>