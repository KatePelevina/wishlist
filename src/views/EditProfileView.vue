<template>

    <msg-component
    :errorMsg="this.errorMsg"
    :successMsg="this.successMsg"
    />
  

    <div class="card" v-for="user in users" :key="user.id">
        <div class="flex-btn">
            <n-button strong secondary type="warning" @click="showEditModal=true; selectUser(user);">
                Редактировать профиль
            </n-button>
            <n-button strong secondary type="error">
                Удалить профиль
            </n-button>
        </div>
    </div>
 
    <!-- Edit  -->
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
                        <form class="form" method="post" @submit.prevent="updateUser">
                            <label>Имя</label>
                            <n-input v-model:value="currentUser.firstName" type="text" placeholder="firstName"/>

                            <label>Фамилия</label>
                            <n-input v-model:value="currentUser.secondName" type="text" placeholder="secondName"/>

                            <label>nickname</label>
                            <n-input v-model:value="currentUser.nickName" type="text" placeholder="nickName"/>

                            <label>about</label>
                            <n-input v-model:value="currentUser.about" type="text" placeholder="about"/>
                            
                            <n-upload
                                v-model:value="currentUser.img"
                                action="http://localhost:8085/public/process.php?action=update-user-img"
                                :headers="{
                                'naive-info': 'hello!'
                                }"
                                :data="{
                                'naive-data': 'cool! naive!'
                                }"
                                >
                                <n-button>Загрузить фото</n-button>
                            </n-upload>  

                            <n-button type="success"  @click="showEditModal=false; updateUser(); uploadFile()" class="edit-btn">Обновить</n-button>
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
import { NInput } from 'naive-ui'


export default defineComponent({
  name: 'TestComponent',
  components: { 
      MsgComponent,
      NButton,
      NModal,
      NCard,
      NUpload,
      NInput
  },
  data() {
      return {
         
          errorMsg: "",
          successMsg: "",
          showEditModal: false,
          users:[],
          currentUser: {},
          file: '',
          photos: [],

      }
  },
  methods: {
    uploadFile() {
            const formData = new FormData();
            formData.append('bytes', this.file, this.currentUser);

            let user = this.toFormData(this.currentUser);

            console.log(user);

            axios.post('http://localhost:8085/public/process.php?action=update-user-img',
            user, formData, 
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
            ).then(function (data) {
                console.log(data.data);
                // this.$router.reload();
            })
            .catch(function () {
                console.log('FAILURE!!');
            });
        },
      async getUser(){
          await axios.get('http://localhost:8085/public/process.php?action=get-my-profile')
          .then((response)=>{
              this.users = response.data.users; 
          })
          .catch((error)=>{
              console.log(error)
          })
      },
      updateUser() {
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
            // showModal: ref(false)
            value: ref(null),
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
    // text-align: center;
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
.n-input {
    margin-bottom: 10px;
}
.edit-btn {
    width: 100%;
}
.flex-btn {
    display: flex;
    justify-content: space-around;
    align-items: center;
}
</style>