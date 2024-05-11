<template>
  <div class="page">

    <div class="title-box">
      <h1>Идеи для твоего Bucket List</h1>
      <p v-if="wishes.length">Всего: {{ wishes.length }}</p>
    </div>
    
    <my-input
      v-if="wishes.length"
      v-model="searchQuery"
      placeholder="Поиск..."
    />

    <div class="sort">
      <n-space vertical  v-if="wishes.length">
        <n-select v-model:value="selectedSort" :options="options" />
      </n-space>
    </div>
    

    <IdeasBucketlist 
      :wishes="sortedAndSearchedPosts"
    />

  </div>
</template>
  
<script>
import axios from 'axios';
import { defineComponent } from "vue";

import MyInput from '@/components/layout/MyInput.vue';

import IdeasBucketlist from '@/components/wishes/IdeasBucketlist.vue';
import { NSpace, NSelect } from 'naive-ui';

export default defineComponent ({
  name: 'IdeasBucketList',
  components: {
    MyInput,
    IdeasBucketlist,
    NSpace, 
    NSelect
  },
  data() {
    return {
      wishes:[],
      selectedSort: '',
      searchQuery: '',
    }
  },
  methods: {
    async getAllPlaces(){
      await axios.get('http://localhost:8085/public/process.php?action=ideas-bucketlist')

      .then((response)=>{
      this.wishes = response.data.wishes; 
      })
      .catch((error)=>{
      console.log(error)
      })
    }
  },
  mounted() {
    this.getAllPlaces()
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
        label: "По цене",
        value: "price"
      },
      {
        label: "По дате создания",
        value: "date"
      },
      {
        label: "По видимости",
        value: "visible"
      },
      ],
      visible: [
      {
        label: "видят все пользователи",
        value: "0"
      },
      {
        label: "вижу только я",
        value: "1",
      },
      ],
      done: [
        {
          label: "Хочу",
          value: 0,
        },
        {
          label: "Выполнено",
          value: 1,
        }
      ]
    };
  }
})
</script>
  
  
  <style lang="scss" scoped>
  @import "@/styles/_variables.scss";
  // .card {
  //   background-color: #fff;
  //   border-radius: 10px;
  //   width: 600px;
  //   padding: 15px;
  //   margin-bottom: 10px;
  //   cursor: pointer;
  //   &:hover {
  //       box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
  //   }
  // }
  
  // .card-header {
  //   display: flex;
  //   align-items: center;
  //   justify-content: space-between;
  // }
  // .card-header__left {
  //   display: flex;
  //   align-items: center;
  // }
  // .card-title {
  //   font-weight: bold;
  //   font-size: 24px;
  //   text-transform: uppercase;
  // //    line-height: 17px;
  // }
  
  
  // .card-text {
  //   font-size: 12px;
  // }
  // .flex {
  //   display: flex;
  //   justify-content: space-between;
  //   align-items: center;
  //   margin-top: 10px;
  //   p {
  //       margin-right: 10px;
  //   }
  // }
  // .card-body__right {
  // //    background-color: #000;
  //   width: 150px;
  //   height: 150px;
  //   border-radius: 10px;
  // }
  // .card-body__right-img {
  //   width: 150px;
  //   height: 150px;
  //   border-radius: 10px;
  //   img {    
  //     height: 100%;
  //   }
  // }
  // .card-body {
  //   display: flex;
  //   justify-content: space-between;
  // }
  // .card-body__left {
  //   width: 390px;
  //   flex-direction: column;
  //   display: flex;
  //   justify-content: space-between;
  // }
  // .span {
  //   display: flex;
  // }
  // #overlay{
  //   position: fixed;
  //   top: 0;
  //   bottom: 0;
  //   left: 0;
  //   right: 0;
  //   background: rgba(0, 0, 0, 0.7);
  // }
  
  
  
  // .box {
  //     flex-basis: 49%;
  //     height: 200px;
  //     border-radius: 10px;
  //     overflow: hidden;
  //     position: relative;
  //     margin-bottom: 10px;
  //     img {
  //         height: 100%;
  //         width: 100%;
  //     }
     
  // }
  // .box:hover {
  //     box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
  // }
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
  // .span {
  //     background-color: $active;
  //     color: #fff;
  //     padding: 5px;
  //     border-radius: 5px;
  //     position: absolute;
  //     top: 10px;
  //     right: 10px;
  // }
  // .items {
  //     display: flex;
  //     justify-content: space-between;
  //     flex-wrap: wrap;
  // }
  // .item {
  //    width: 49%;
  //    margin-bottom: 10px;
  // }
  .page {
    @include page;
  }
  
  // .button {
  //  background-color: $active;
  //  border: none;
  //  padding: 5px 10px;
  //  border-radius: 5px;
  //  color: $white;
  // }
  .sort {
    margin-bottom: 20px;
  }
  .title-box {
    margin-bottom: 20px;
  }
  </style>