<template>



  <msg-component
  :errorMsg="this.errorMsg"
  :successMsg="this.successMsg"
  />
  

 
      <div class="card" v-for="user in users" :key="user.id">
          <div class="card-header">
              <div class="card-header__left">
                  <div class="photo"></div>
                  <div>
                      <p class="card-title">{{ user.nickName }}</p>
                      <p class="card-title">{{ user.firstName }} {{ user.secondName }}</p>
                  </div>
              </div>
              <div class="card-header__right">
                  <a href="#" @click="showEditModal=true; selectUser(user);"  >
                      <img src="@/assets/edit-1.svg" alt="" class="place-btn">
                  </a>   
                                    
                  <a href="#" @click="showDeleteModal=true; selectUser(user);">
                      <img src="@/assets/delete.svg" alt="">
                  </a>
              </div>
          </div>
          <div>
              <p>{{user.about}}</p>
          </div>
          
        <n-upload
            action="https://www.mocky.io/v2/5e4bafc63100007100d8b70f"
            :headers="{
            'naive-info': 'hello!'
            }"
            :data="{
            'naive-data': 'cool! naive!'
            }"
            >
            <n-button>Загрузить фото</n-button>
        </n-upload>

        <n-button strong secondary type="warning" @click="showEditModal=true; selectUser(user);">
            Редактировать профиль
        </n-button>
        <n-button strong secondary type="error">
            Удалить профиль
        </n-button>
      </div>
 
      <!-- <div>
          <label>File
              <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
          </label>
          <button v-on:click="submitFile()">Submit</button>
      </div> -->

      



<!-- Edit Place -->
  <div v-if="showEditModal">
        <n-modal v-model:show="showEditModal">
            <n-card
            style="width: 600px"
            
            :bordered="false"
            size="huge"
            role="dialog"
            aria-modal="true"
            >
            <div class="add-component__modal">
                <div class="add-box">
                    <h2>Редактировать user</h2>
                    <form class="form" method="post">
                        <input class="add-box__input" type="text" name="firstName"  v-model="currentUser.firstName">
                        <input class="add-box__input" type="email" name="secondName"  v-model="currentUser.secondName">
                        <input class="add-box__input" type="text" name="nickName"  v-model="currentUser.nickName">
                        <input class="add-box__input" type="text" name="about"  v-model="currentUser.about">      
                        <button  @click="showEditModal=false; updateUser()" class="button">Обновить</button>
                    </form>
                </div>
            </div>
            
            </n-card>
        </n-modal>
  </div> 

  

</template>




<script>
import axios from 'axios';
import { defineComponent, ref } from "vue";

import MsgComponent from '@/components/layout/MsgComponent.vue';
import { NButton, NModal, NCard, NUpload } from 'naive-ui'


export default defineComponent({
  name: 'TestComponent',
  components: { 
      MsgComponent,
      NButton,
      NModal,
      NCard,
      NUpload
  },
  data() {
      return {
         
          errorMsg: "",
          successMsg: "",
          showEditModal: false,
        //   showDeleteModal: false,
          users:[],
          currentUser: {},
          file: '',
          photos: [],

      }
  },
  methods: {
      async getUser(){
          await axios.get('http://localhost:8085/public/process.php?action=get-my-profile')
          .then((response)=>{
              this.users = response.data.users; 
          })
          .catch((error)=>{
              console.log(error)
          })
      },
      updateUser(){
          let formData = this.toFormData(this.currentUser);

          axios.post("http://localhost:8085/public/process.php?action=update-user", formData)
          .then((response)=>{
              this.currentUser = {};
              if(response.data.error){
                  this.errorMsg = response.data.message;
              }else {
                  this.successMsg = response.data.message;
                  this.getUser();
              }
          });
      },
      // async submitFile(){
      // let formData = new FormData();
      // formData.append('file', this.file);
      // await axios.post( 'http://localhost:8085/public/process.php?action=user-image',
      //     formData,
      //     {
      //     headers: {
      //         'Content-Type': 'multipart/form-data'
      //     }
      //     }
      //     ).then((response) => {
      //         // this.$router('/user-image');
      //         console.log('SUCCESS!!');
      //         this.successMsg = response.data.successMsg;
      //     })
      //     .catch((error) => {
      //         console.log(error)
      //     });
      // },
      // handleFileUpload(){
      //     this.file = this.$refs.file[0].files;
      //     console.log(this.file);
      //     console.log(this.$refs.file[0].files);
      // },
      toFormData(obj){
          let fd = new FormData();
          for(let i in obj){
              fd.append(i,obj[i]);
          }
          return fd;
      },
      selectUser(user){
          this.currentUser = user;
      },
      clearMsg(){
          this.errorMsg = "";
          this.successMsg = "";
      },
  },
  mounted() {
      this.getUser()
  },
  setup() {
  return {
    showModal: ref(false)
  };
}
})
</script>

<style lang="scss" scoped>
@import "@/styles/_variables.scss";
.card {
  background-color: #fff;
  border-radius: 10px;
  padding: 15px;
}
.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.card-header__left {
  display: flex;
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
   
}
</style>