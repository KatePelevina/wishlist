<template>
  <div class="page">

    <div class="color">
        <n-breadcrumb>
            <n-breadcrumb-item @click="$router.push(`/my-wish-list-folders`)">Wish List / </n-breadcrumb-item>
            <n-breadcrumb-item>Идеи для твоего Wish List</n-breadcrumb-item> 
        </n-breadcrumb>
    </div>

    <div class="title">
      <h1>Идеи для твоего Wish List</h1>
      <p  v-if="wishes.length">Всего идей: {{ wishes.length }}</p>
    </div>
   
  
    <div class="search">
      <my-input
        v-if="wishes.length"
        v-model="searchQuery"
        placeholder="Поиск..."
      />
    </div>
    
    <div class="sort">
      <n-space vertical  v-if="wishes.length">
        <n-select v-model:value="selectedSort" :options="options" />
      </n-space>
    </div>
    

    <IdeasWishlist :wishes="sortedAndSearchedPosts"/>

  </div>
</template>

<script>
import axios from 'axios';
import { defineComponent } from "vue";

import { NBreadcrumb } from 'naive-ui';
import { NSpace, NSelect } from 'naive-ui';

import IdeasWishlist from '@/components/wishes/IdeasWishlist.vue';
import MyInput from '@/components/layout/MyInput.vue';

export default defineComponent ({
  name: 'AllWishListView',
  components: {
    IdeasWishlist,
    MyInput,
    NSpace, 
    NSelect,
    NBreadcrumb
  },
  data() {
    return {
      wishes:[],
      selectedSort: '',
      searchQuery: '',
    }
  },
  methods: {
    async getAllWishes(){
      await axios.get('http://localhost:8085/public/process.php?action=ideas-wishlist')

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
    this.getAllWishes()
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
          label: "вижу только я",
          value: "0",
        },
        {
          label: "видят все пользователи",
          value: "1"
        },
      ],
      done: [
        {
          label: "Хочу",
          value: 0
        },
        {
          label: "Исполнено",
          value: 1
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
.search {
  margin-bottom: 20px;
}
.search-input {
  margin-bottom: 0px;
}
.sort {
  margin-bottom: 20px;
}
.title {
  margin-bottom: 20px;
}
.color {
  border: 1px $bg solid;
  border-radius: 10px;
  padding: 10px;
  margin-bottom: 20px;
}
</style>