<template>
    <div>
  
    
      <!-- <p>Всего: {{ wishes.length }}</p> -->
    
      
          <!-- <div class="card" v-for="place in places" :key="place.id" @click="$router.push(`/place/${place.id}`)">
              <div class="card-header">
                  
                  <div class="card-header__right">
                      <a href="#"><img src="@/assets/dots.svg" alt="dots-icon"></a>
                      <img src="@/assets/dots.svg" alt="dots-icon">
                  </div>
              </div>
              <div class="card-body">
                  <div class="card-body__right">
                    <div class="card-body__right-img">
                      <img src="@/assets/paris.jpg" alt="">
                    </div>
                  </div>
                  <div class="card-body__left">
                      <div>
                          <p class="card-title">Сумка</p>
                          <p class="card-text">300$</p>
                          <p class="card-text"></p>     
                      </div>
                      <p>{{ place.description }}</p>
                      <div class="flex">
                          <p>11 декабря 2021</p>
                          <p>Имя автора</p>
                      </div>
                      <button>Добавить в свой WishList</button>
                  </div>
                  
              </div>
          </div> -->
    
          <!-- <h1>Все желания из моего Wish List</h1> -->
  
          <!-- <div class="items">
            <div class="item" v-for="wish in wishes" :key="wish.id">
                <div class="box" @click="$router.push(`/my-wish-list-item/${wish.id}`)">
                    <div class="box-inner">
                        <span v-if="wish.price" class="span">{{ wish.price }}</span>
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
  
  
          <!-- <div class="flex rrrr">
              <div class="flex-left">
                  <p class="ddddd">Кол-во желаний: {{ wishes.length }}</p> 
              </div>
              <div class="flex-right">
                  <p class="ddddd">Кол-во исполненных: {{ done_count  }}</p>
                  
              </div>
          </div> -->
  
          <div class="progress ddddd percent">
              <p>Исполнено: {{ done_count  }} / {{ wishes.length }}</p>
             
              <n-space vertical>
                  <n-progress
                  type="line"
                  :percentage="getPercent()"
                  :indicator-placement="'inside'"
                  :border-radius="4"
                  />
              </n-space>
          </div>
  
  
          <!-- <div class="flex"> -->
              <div>
                <n-space vertical>
                  <n-select v-model:value="selectedSort" :options="options" />
                </n-space>
              </div>
              <!-- <div class="div-button flex-right">
                  <n-button @click="showModal=true" class="btn" strong secondary type="success">+ Новое желание</n-button>
              </div> -->
          <!-- </div> -->
  
          <!-- <my-select
          v-model="selectedSort"
          :options="sortOptions" 
          /> -->
  
          <!-- <div class="select">
            <n-space vertical>
              <n-select v-model:value="selectedSort" :options="options" />
            </n-space>
          </div> -->
          
  
          <my-input
          v-model="searchQuery"
          placeholder="Поиск..."
          />
  
          <wish-list-component
          :wishes="sortedAndSearchedPosts"
          />

  
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
                         <form class="form" method="post">
                             <n-input v-model:value="newWish.name" type="text" placeholder="Название" class="input" />
                             <n-input-number  v-model:value="newWish.price" type="text" placeholder="Цена"/>
                             <n-input v-model:value="newWish.description" type="text" placeholder="Описание" class="input"  />
                             <n-input v-model:value="newWish.link" type="text" placeholder="Ссылка" class="input" />
  
                              <n-space vertical class="select">
                                  <n-select v-model:value="newWish.visible" :options="visible" />
                              </n-space>
  
                             <n-button strong secondary type="success" attr-type="submit" class="add-btn" @click="showModal=false; addWishList();">Добавить желание</n-button>
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
  
    import { NButton } from 'naive-ui';
    import { NSpace, NSelect } from 'naive-ui';
    import { NProgress }  from 'naive-ui';
    import { NModal, NCard } from 'naive-ui';
    import { NInput, NInputNumber } from 'naive-ui';
  
    import WishListComponent from '@/components/wishes/WishListComponent.vue';
    import MyInput from '@/components/layout/MyInput.vue';
    // import MySelect from '@/components/layout/MySelect.vue';
  
    
    export default defineComponent ({
      name: 'AllWishListView',
      components: {
        NButton,
        NSpace,
        NSelect,
        WishListComponent,
        MyInput,
        NProgress,
        NModal, 
        NCard,
        NInput, 
        NInputNumber 
        // MySelect
       
      },
      data() {
          return {
            wishes:[],
            done_count: [],
            selectedSort: '',
            searchQuery: '',
            showModal: false,
            newWish: { 
                 name: "", 
                 price: "",
                 description: "",
                 photo: '',
                 link: "",
                 visible: "",
                 folder_id: "",
                 done: "0",
                 wish_list: '1',
                 bucket_list: '0'
             },
             page: ''
            // sortOptions: [
            //       {value: 'name', name: 'По name'},
            //       {value: 'date', name: 'По date'},
            //       {value: 'price', name: 'По price'},
            //       {value: 'visible', name: 'По visible'},
            // ],
          }
      },
      methods: {
          async getAllBucketList() {
              let id = this.$route.params.id;
  
              await axios.get('http://localhost:8085/public/process.php?action=get-all-my-bucketlist&id='+id)
              .then((response)=>{
                this.wishes = response.data.wishes;
                 
                console.log(this.wishes);
              })
              .catch((error)=>{
                  console.log(error)
              })
          },
          async getCountDoneWishList() {
              let id = this.$route.params.id;
  
              await axios.get('http://localhost:8085/public/process.php?action=get-done-bucketlist-for-folder&id='+id)
              .then((response)=>{
                  this.done_count = response.data.count; 
                 
                  console.log(response.data);
              })
              .catch((error)=>{
                  console.log(error)
              })
          },
          getPercent() {          
              this.percent = Math.round(this.done_count/this.wishes.length * 100);
  
              console.log(this.percent);
              return this.percent
          },
          async addWishList(){
              let id = this.$route.params.id;
              let formData = this.toFormData(this.newWish);
          
  
              axios.post('http://localhost:8085/public/process.php?action=add-wishlist-to-folder&id='+id, formData)
  
              .then((response)=>{
                  this.newWish = {name: "", price: "", description: "", photo: "", link: "", visible: "", folder_id: "", done: "", wish_list: "", bucket_list: "" };
                  
                  if (response.data.error) {
                      console.log(response.data);
                      // this.errorMsg = response.data.message;
  
                  } else {
                      console.log(response.data);
                      // this.successMsg = response.data.message;
                      this.getWishes();              
                  }
              });
              },
          },
        mounted() {
            this.getAllBucketList() 
            this.getCountDoneWishList()
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
                    label: "Сортировать",
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
                    label: "По price",
                    value: "price",
                    },
                    {
                    label: "По visible",
                    value: "visible"
                    }
                ],
                visible: [
                    {
                    label: "Кто видит желание",
                    value: "",
                    disabled: true
                    },
                    {
                    label: "вижу только я",
                    value: "1",
                    },
                    {
                    label: "видят все пользователи",
                    value: "2"
                    }
                ],
            };
        }
    })
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
            height: 230px;
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
    
    // .button {
    //  background-color: $active;
    //  border: none;
    //  padding: 5px 10px;
    //  border-radius: 5px;
    //  color: $white;
    // }
  
    .page {
      background-color: #fff;
      padding: 15px;
    }
  
    .flex-left, .flex-right {
      flex-basis: 49%;
    }
    .div-button {
      flex-basis: 49%;
    }
    .ddddd {
      text-align: center;
      background-color: $bg;
      width: 100%;
      padding: 6px;
      border-radius: 5px;
    }
    .btn {
      width: 100%;
    }
  
    .select {
      margin-top: 20px;
    }
    .percent {
      margin-top: 20px;
      margin-bottom: 20px;
    }
    </style>