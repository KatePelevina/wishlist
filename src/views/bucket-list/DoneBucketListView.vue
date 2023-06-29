<template>
    <div>
        <!-- <div class="items">
            <div class="item" v-for="(wish,index) in wishes" :key="index">
                <div class="box" @click="$router.push(`/done-bucket-list-item/${wish.id}`)">
                    <img :src="'/img/' + wish.photo" alt="">
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
                <p class="ddddd">Количество желаний: {{ wishes.length }}</p>
            </div>
            <div class="flex-right">
                <n-button @click="showModal=true" class="btn" strong secondary type="success">+ Добавить желание</n-button>
            </div>
        </div>

        <n-space vertical>
            <n-select v-model:value="selectedSort" :options="options" />
        </n-space>

        <my-input
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
  import { NButton } from 'naive-ui';

  import DoneBucketlist from '@/components/wishes/DoneBucketlist.vue';
  import MyInput from '@/components/layout/MyInput.vue';
//   import MySelect from '@/components/layout/MySelect.vue';



  export default defineComponent ({
    name: "DoneBucketListView",
    components: { 
        DoneBucketlist,
        MyInput,
        NSpace,
        NSelect,
        NButton
        // MySelect
    },
    data(){
        return {
            wishes:[],
            selectedSort: '',
            searchQuery: '',
            sortOptions: [
                {value: 'name', name: 'По name'},
                {value: 'date', name: 'По date'},
                {value: 'price', name: 'По price'},
                {value: 'visible', name: 'По visible'},
            ],
        }
    },
    methods: {
        async getWishes(){
            
            await axios.get('http://localhost:8085/public/process.php?action=get-done-bucketlist')
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
</style>