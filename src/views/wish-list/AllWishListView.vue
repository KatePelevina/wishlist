<template>
  <div class="page">
    
    <div class="flex color">
      <div class="popover">
        <n-popover trigger="hover">
            <template #trigger>
                <n-space @click="$router.push(`/my-wish-list-folders`)">
                  <n-icon size="25" @click="showInfo=true">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M408 96H252.11a23.89 23.89 0 0 1-13.31-4L211 73.41A55.77 55.77 0 0 0 179.89 64H104a56.06 56.06 0 0 0-56 56v24h416c0-30.88-25.12-48-56-48z" fill="currentColor"></path><path d="M423.75 448H88.25a56 56 0 0 1-55.93-55.15L16.18 228.11v-.28A48 48 0 0 1 64 176h384.1a48 48 0 0 1 47.8 51.83v.28l-16.22 164.74A56 56 0 0 1 423.75 448zm56.15-221.45z" fill="currentColor"></path></svg>                  
                  </n-icon>
                </n-space>
            </template>
            <span>Просмотр желаний в папках</span>
        </n-popover>
      </div>
      <div>
        <n-icon size="25" @click="showInfo=true" class="nav-item__icon">
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M10.492 8.91A.5.5 0 0 0 9.5 9v4.502l.008.09a.5.5 0 0 0 .992-.09V9l-.008-.09zm.307-2.16a.75.75 0 1 0-1.5 0a.75.75 0 0 0 1.5 0zM18 10a8 8 0 1 0-16 0a8 8 0 0 0 16 0zM3 10a7 7 0 1 1 14 0a7 7 0 0 1-14 0z" fill="currentColor"></path></g></svg>
        </n-icon>
      </div>
    </div>
        

            <h1 class="title">Wish List</h1>
       

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


        <div class="sort">
          <n-space vertical>
            <n-select v-model:value="selectedSort" :options="options" />
          </n-space>

        </div>
        
            

      
        

        <my-input
          v-model="searchQuery"
          placeholder="Поиск..."
        />

        <wish-list-component
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
                    <p>Wish List - это</p>
                </div>
                </n-card>
            </n-modal>
        </div>
    
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { defineComponent, ref } from "vue";

  // import { NButton } from 'naive-ui';
  import { NSpace, NSelect } from 'naive-ui';
  import { NProgress }  from 'naive-ui';
  import { NModal, NCard, NPopover } from 'naive-ui';
  // import { NInput, NInputNumber } from 'naive-ui';

  import WishListComponent from '@/components/wishes/WishListComponent.vue';
  import MyInput from '@/components/layout/MyInput.vue';
  // import MySelect from '@/components/layout/MySelect.vue';

  import { NIcon } from 'naive-ui';
  // import { NSwitch } from 'naive-ui';
// import { Sunny, Moon } from "@vicons/ionicons5";

  
  export default defineComponent ({
    name: 'AllWishListView',
    components: {
      // NButton,
      NSpace,
      NSelect,
      WishListComponent,
      MyInput,
      NProgress,
      NModal, 
      NCard,
      // NInput, 
      // NInputNumber,
      // NSwitch,
      NIcon,
      NPopover
    },
    data() {
        return {
          wishes:[],
          done_count: [],
          selectedSort: '',
          searchQuery: '',
          showInfo: false,
          newWish: { 
               name: "", 
               price: "",
               description: "",
               photo: '',
               link: "",
               visible: "",
               folder_id: "1",
               done: "0",
              
          },
          folders: [],
        }
    },
    methods: {
        async getAllWishlist() {
            await axios.get('http://localhost:8085/public/process.php?action=get-all-wishlist')
  
            .then((response)=>{
                this.wishes = response.data.wishes; 
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        // async getDoneWishList() {
        //     let id = this.$route.params.id;

        //     await axios.get('http://localhost:8085/public/process.php?action=get-done-wishlist')
        //     .then((response)=>{
        //       this.wishes = response.data.wishes;
               
        //       console.log(this.wishes);
        //     })
        //     .catch((error)=>{
        //         console.log(error)
        //     })
        // },
        async getCountDoneWishList() {
            // let id = this.$route.params.id;

            await axios.get('http://localhost:8085/public/process.php?action=get-count-done-wishlist')
            .then((response)=>{
                this.done_count = response.data.count; 
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
          
            let formData = this.toFormData(this.newWish);
        

            axios.post('http://localhost:8085/public/process.php?action=add-wishlist', formData)

            .then((response)=>{
                this.newWish = {name: "", price: "", description: "", photo: "", link: "", visible: "", folder_id: "", done: "" };
                
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
        toFormData(obj){
            let fd = new FormData();
            for(let i in obj){
                fd.append(i,obj[i]);
            }
            return fd;
        },
        async getFolders() {
          await axios.get('http://localhost:8085/public/process.php?action=get-wishlist-folders')
            .then(response => {
                this.folders = response.data.folders; 
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
        }
    },
      
    mounted() {
        this.getAllWishlist()
        // this.getDoneWishList() 
        this.getCountDoneWishList()
        this.getFolders()
        this.openForm()
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
            // folderSelector: [
            //     {
            //       label: "Добавить в папку",
            //       value: "",
            //       disabled: true
            //     }
            // ],
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
    // margin-top: 10px;
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
    @include page;
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
    margin-bottom: 20px;
  }
  .color {
    border: 1px $bg solid;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 20px;
}
.sort {
  margin-bottom: 20px;
}
.popover {
    cursor: pointer;
}
.nav-item__icon {
    cursor: pointer;
}
.title {
  margin-bottom: 20px;
}
  </style>