<template>
  <div class="page">

    <div class="flex color">
      <div>
        <n-space @click="$router.push(`/my-bucket-list-folders`)">
          <n-switch v-model:value="active" />
        </n-space>
      </div>
      <div>
        <n-icon size="25" @click="showInfo=true">
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M10.492 8.91A.5.5 0 0 0 9.5 9v4.502l.008.09a.5.5 0 0 0 .992-.09V9l-.008-.09zm.307-2.16a.75.75 0 1 0-1.5 0a.75.75 0 0 0 1.5 0zM18 10a8 8 0 1 0-16 0a8 8 0 0 0 16 0zM3 10a7 7 0 1 1 14 0a7 7 0 0 1-14 0z" fill="currentColor"></path></g></svg>
        </n-icon>
      </div>
    </div>
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
        <!-- <img src="@/assets/location.svg" alt="icon" class="nav-item__icon">  -->
        Bucket List
    </h1>
    <!-- <img src="@/assets/location.svg" alt="icon" class="nav-item__icon" @click="$router.push(`/my-bucket-list-folders`)">  -->

    </div>
    

   <!-- <div class="flex rrrr">
        <div class="flex-left">
            <p class="ddddd">Количество желаний: {{ wishes.length }}</p>
        </div>
        <div class="flex-right">
            <n-button @click="showModal=true" class="btn" strong secondary type="success">+ Добавить желание</n-button>
        </div>
    </div> -->

    <!-- <my-select
        v-model="selectedSort"
        :options="sortOptions" 
    /> -->

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

    <div class="flex">
      <div class="flex-left">
        <n-space vertical>
          <n-select v-model:value="selectedSort" :options="options" />
        </n-space>
      </div>
      <div class="div-button flex-right">
        <n-button @click="showModal=true; openForm()" class="btn" strong secondary type="success">+ Новое желание</n-button>
      </div>
    </div>

    <!-- <div class="select"  v-if="folders.length">
      <n-space vertical>
          <n-select v-model:value="selectedSort" :options="options" />
      </n-space>
    </div> -->

    <my-input
        v-model="searchQuery"
        placeholder="Поиск..."
    /> 

    <!-- <n-button @click="showModal=true; openForm()" class="btn" strong secondary type="success">+ Новое желание</n-button> -->

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

                            <n-space vertical class="select">
                                <n-select v-model:value="newWish.folder_id" :options="folderSelector"/>
                            </n-space>
                            

                            <n-space vertical class="select">
                                <n-select v-model:value="newWish.done" :options="done" />
                            </n-space>

                           <n-button strong secondary type="success" attr-type="submit" class="add-btn" @click="showModal=false; addBucketList();">Добавить желание</n-button>
                       </form>
                   </div>
               </div>
               
               </n-card>
           </n-modal>
    </div> 

    <bucket-list-component
      :wishes="sortedAndSearchedPosts"
    />

    <div v-if="showInfo">
            <n-modal v-model:show="showInfo">
                <n-card
                style="width: 600px"
                :bordered="false"
                size="huge"
                role="dialog"
                aria-modal="true"
                >
                <div>
                    <p>Bucket List - это</p>
                </div>
                </n-card>
            </n-modal>
        </div>
    
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { NButton } from 'naive-ui';
  import { NModal, NCard } from 'naive-ui';
  import { NInput, NInputNumber, NSpace, NSelect, NSwitch, NIcon, NProgress } from 'naive-ui';
  import { defineComponent, ref } from "vue";


  import BucketListComponent from '@/components/wishes/BucketListComponent.vue';
  import MyInput from '@/components/layout/MyInput.vue';
  // import MySelect from '@/components/layout/MySelect.vue';


  
  export default defineComponent ({
    name: 'AllBucketListView',
    components: { 
        BucketListComponent,
        MyInput,
        // MySelect,
        NButton,
        NModal, 
        NCard,
        NInput, 
        NInputNumber,
        NSpace, 
        NSelect,
        NSwitch,
        NIcon,
        NProgress
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
            showModal: false,
            showInfo: false,
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
            folders: [],
            done_count: [],
            
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
      addBucketList(){
            let formData = this.toFormData(this.newWish);

            axios.post("http://localhost:8085/public/process.php?action=add-bucketlist", formData)
            .then((response)=>{
                this.newWish = {name: "", price: "", description: "", photo: "", link: "", visible: "", folder_id: "", done: "", wish_list: "", bucket_list: "" };
                
                if (response.data.error) {
                    this.errorMsg = response.data.message;
                } else {
                    // location.reload(); 
                    this.successMsg = response.data.message;
                    this.getAllWishlist();         
                }
            });
      },
      getPercent() {          
            this.percent = Math.round(this.done_count/this.wishes.length * 100);

            console.log(this.percent);
            return this.percent
        },
      async getFolders() {
          await axios.get('http://localhost:8085/public/process.php?action=get-bucketlist-folders')
            .then(response => {
                this.folders = response.data.folders; 
                console.log(this.folders);
            })
            .catch(error => {
                console.log(error);
            });
        },
      openForm() {
          this.folders.forEach(element => {
            this.folderSelector.push({
              label: element.name,
              value: element.id,
            });
          });
        },
        async getCountDoneWishList() {
            // let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-count-done-bucketlist')
            .then((response)=>{
                this.done_count = response.data.count; 
            })
            .catch((error)=>{
                console.log(error)
            })
        },
    },
    mounted() {
        this.getAllPlaces()
        this.getFolders()
        this.openForm()
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
                value: "0",
                },
                {
                label: "видят все пользователи",
                value: "1"
                }
            ],
            done: [
              {
                label: "Статус",
                value: "",
                disabled: true
              },
              {
                label: "хочу",
                value: "0",
              },
              {
                label: "исполнено",
                value: "1"
              }
            ],
            folderSelector: [
                {
                  label: "Добавить в папку",
                  value: "",
                  disabled: true
                }
            ]
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
  .color {
    border: 1px $bg solid;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 20px;
}
  </style>