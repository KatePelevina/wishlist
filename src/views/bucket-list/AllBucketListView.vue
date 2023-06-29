<template>
  <div class="page">
    <!-- <p>Всего: {{ wishes.length }}</p> -->
  
    <!-- <h1>Все желания из моего Bucket List</h1> -->

    <!-- <div class="items">
        <div class="item" v-for="wish in wishes" :key="wish.id">
            <div class="box"  @click="$router.push(`/my-bucket-list-item/${wish.id}`)">
                <div class="box-inner">
                    <span class="span" v-if="wish.price">{{ wish.price }}</span>
                    <img :src="'/img/' + wish.photo" alt="">
                </div>
            </div>
            <div class="flex">
              <div>
                <p class="box-inner__hover">{{wish.name}}</p>
              </div>
            </div>
            
        </div>
    </div> -->

    <div class="flex">
      <h1 class="title">
        <img src="@/assets/location.svg" alt="icon" class="nav-item__icon"> 
        Bucket List
    </h1>
    <img src="@/assets/location.svg" alt="icon" class="nav-item__icon" @click="$router.push(`/my-bucket-list-folders`)"> 

    </div>
    

   <div class="flex rrrr">
        <div class="flex-left">
            <p class="ddddd">Количество желаний: {{ wishes.length }}</p>
        </div>
        <div class="flex-right">
            <n-button @click="showModal=true" class="btn" strong secondary type="success">+ Добавить желание</n-button>
        </div>
    </div>

    <my-select
        v-model="selectedSort"
        :options="sortOptions" 
    />

    <my-input
        v-model="searchQuery"
        placeholder="Поиск..."
    /> 

    <bucket-list-component
      :wishes="sortedAndSearchedPosts"
    />
    
    </div>
  </template>
  
  <script>
  import axios from 'axios';

  // import { NButton } from 'naive-ui';
  import BucketListComponent from '@/components/wishes/BucketListComponent.vue';
  // import MyInput from '@/components/layout/MyInput.vue';
  // import MySelect from '@/components/layout/MySelect.vue';


  
  export default {
    name: 'AllBucketListView',
    components: { 
        BucketListComponent,
        // MyInput,
        // MySelect,
        // NButton
    },
    data() {
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
      async getAllPlaces(){
          await axios.get('http://localhost:8085/public/process.php?action=get-all-bucketlist')
          
          .then((response)=>{
              this.wishes = response.data.wishes; 
          })
          .catch((error)=>{
              console.log(error)
          })
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
  }
  </script>
  
  
  <style lang="scss" scoped>
  @import "@/styles/_variables.scss";
  .card {
    background-color: #fff;
    border-radius: 10px;
    width: 600px;
    padding: 15px;
    margin-bottom: 10px;
    cursor: pointer;
    &:hover {
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
    }
  }
  
  .card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .card-header__left {
    display: flex;
    align-items: center;
  }
  .card-title {
    font-weight: bold;
    font-size: 24px;
    text-transform: uppercase;
  //    line-height: 17px;
  }
  
  
  .card-text {
    font-size: 12px;
  }
  .flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
    p {
        margin-right: 10px;
    }
  }
  .card-body__right {
  //    background-color: #000;
    width: 150px;
    height: 150px;
    border-radius: 10px;
  }
  .card-body__right-img {
    width: 150px;
    height: 150px;
    border-radius: 10px;
    img {    
      height: 100%;
    }
  }
  .card-body {
    display: flex;
    justify-content: space-between;
  }
  .card-body__left {
    width: 390px;
    flex-direction: column;
    display: flex;
    justify-content: space-between;
  }
  .span {
    display: flex;
  }
  #overlay{
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
  }
  
  
  
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

  .nav-item__icon {
    cursor: pointer;
  }
  </style>