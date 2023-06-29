<template>

  <!-- <div class="card" v-for="place in places" :key="place.id">
      <div class="card-header">
          <div class="card-header__left">
              <div class="box box-green"></div>
          <div>
              <p class="card-title">{{ name }}</p>
              <p class="card-text">{{ country }} | {{ city }}</p>
              <p class="card-text">{{ street }}, {{ building }}</p> 
              <img :src="'/img/' + photo" />
          </div>
          </div>
          
          <div class="card-header__right">
              <a href="#" @click="showEditModal=true; selectPlace(place);"  >
                  <img src="@/assets/edit-1.svg" alt="" class="place-btn">
              </a>                     
              <a href="#" @click="showDeleteModal=true; selectPlace(place);">
                  <img src="@/assets/delete.svg" alt="">
              </a>
          </div>
      </div>
      <div>
          <p>{{ place.description }}</p>
      </div>

      <div v-for="photo in photos" :key="photo.id">
          <div class="img-box">
              <img :src="'/img/' + photo.path" />
          </div>
      </div>
  </div> -->

  <div 
  v-for="(place,index) in places" 
  :key="index"
  
  >
      <div class="card-header__right">
          <a href="#" @click="showEditModal=true; selectPlace(place);"  >
              <img src="@/assets/edit-1.svg" alt="" class="place-btn">
          </a>                     
          <a href="#" @click="showDeleteModal=true; selectPlace(place);">
              <img src="@/assets/delete.svg" alt="">
          </a>
      </div>

      <my-card
      :id="place.id"
      :name="place.name"
      :country="place.country"
      :city="place.city"
      :street="place.street"
      :building="place.building"
      :description="place.description"
      :photo="place.photo"
      />
      
  </div>
          
  <!-- Edit Place -->

  <!-- <div id="overlay" v-if="showEditModal">
      <div class="modal">
          <button type="button" class="close" @click="showEditModal=false">
              <span aria-hidden="true">&times;</span>
          </button>
          <h2>Редактировать место ggg</h2>
          <div class="add-box">
              <form method="post">
                  <input type="text" name="name"  v-model="currentPlace.name">
                  <input type="email" name="country" v-model="currentPlace.country">
                  <input type="text" name="city" placeholder="Город" v-model="currentPlace.city">
                  <input type="text" name="street" placeholder="Улица" v-model="currentPlace.street">
                  <input type="text" name="building" placeholder="Здание" v-model="currentPlace.building">
                  <input type="text" name="description" placeholder="Описание" v-model="currentPlace.description">
                  
                  <button  @click="showEditModal=false; updatePlace()" class="button">Обновить</button>
              </form>
          </div>
          
      </div>
  </div> -->

  <div v-if="showEditModal">
      <div class="modal">
          <n-button @click="showEditModal = true">
              Start Me up
          </n-button>
          <n-modal v-model:show="showEditModal">
              <n-card
              style="width: 600px"
              title="Modal"
              :bordered="false"
              size="huge"
              role="dialog"
              aria-modal="true"
              >
              
              <form method="post">
                  <input type="text" name="name"  v-model="currentPlace.name">
                  <input type="email" name="country" v-model="currentPlace.country">
                  <input type="text" name="city" placeholder="Город" v-model="currentPlace.city">
                  <input type="text" name="street" placeholder="Улица" v-model="currentPlace.street">
                  <input type="text" name="building" placeholder="Здание" v-model="currentPlace.building">
                  <input type="text" name="description" placeholder="Описание" v-model="currentPlace.description">
                  
                  <button  @click="showEditModal=false; updatePlace()" class="button">Обновить</button>
              </form>
              
              
              </n-card>
          </n-modal>
      </div>
  </div>

  <!-- Delete User Model -->

  <div v-if="showDeleteModal">
      <div class="modal">
          <n-button @click="showDeleteModal = true">
              Start Me up
          </n-button>
          <n-modal v-model:show="showDeleteModal">
              <n-card
              style="width: 600px"
              title="Modal"
              :bordered="false"
              size="huge"
              role="dialog"
              aria-modal="true"
              >
              
              <div>
                  <h4>Удалить место '{{ currentPlace.name }}'? </h4>
                  
                  <button @click="showDeleteModal=false; deletePlace(); clearMsg();" class="red">Да</button>
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <button @click="showDeleteModal=false" class="green">Нет</button>
              </div>
              
              
              </n-card>
          </n-modal>
      </div>
  </div>

  
  <!-- <div id="overlay" v-if="showDeleteModal">
      <div class="add-component__modal">
          <button type="button" class="close" @click="showDeleteModal=false">
              <span aria-hidden="true">&times;</span>
          </button>
          <h5>Удалить место</h5>
      
          <div>
              <h4>Удалить место '{{ currentPlace.name }}'? </h4>
              
              <button @click="showDeleteModal=false; deletePlace(); clearMsg();" class="red">Да</button>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <button @click="showDeleteModal=false" class="green">Нет</button>
          </div>
      </div>
  </div> -->
  
</template>

<script>
import axios from 'axios';
import MyCard from '@/components/MyCard.vue'
import { NModal, NButton, NCard} from 'naive-ui'


export default {
  name: 'PlaceItem',
  components: {
      MyCard,
      NModal,
      NButton,
      NCard
  },
  data() {
      return {
          errorMsg: "",
          successMsg: "",
          showEditModal: false,
          showDeleteModal: false,
          places:[],
          currentPlace: {},
          users: [],
          photos: []
      }
  },
  methods: {
      async getPlace() {
          let id = this.$route.params.id;

          await axios.get('http://localhost:8085/public/process.php?action=get-place&id='+id)
          .then((response)=>{
              this.places = response.data.places;
          })
      },
      async getUsersOfPlace() {
          let id = this.$route.params.id;

          await axios.get('http://localhost:8085/public/process.php?action=get-place-users&id='+id)
          .then((response)=>{
              this.users = response.data.users; 
          })
      },
      updatePlace(){
          let formData = this.toFormData(this.currentPlace);

          axios.post("http://localhost:8085/public/process.php?action=update", formData)
          .then((response)=>{
              this.currentPlace = {};
              if(response.data.error){
                  this.errorMsg = response.data.message;
              }else {
                  this.successMsg = response.data.message;
                  this.getAllPlaces();
              }
          });
      },
      deletePlace(){
          let formData = this.toFormData(this.currentPlace);

          axios.post("http://localhost:8085/public/process.php?action=delete", formData)
          .then((response)=>{
              this.currentPlace = {};
              if(response.data.error){
                  this.errorMsg = response.data.message;
              } else {
                  // this.successMsg = response.data.message;
                  this.$router.push('/'); 
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
      selectPlace(place){
          this.currentPlace = place;
      },
      clearMsg(){
          this.errorMsg = "";
          this.successMsg = "";
      },
      addToVisitedPlaces() {
          let id = this.$route.params.id;
          axios.post('http://localhost:8085/public/process.php?action=add-visited&id='+id)
          .then((response)=>{
              this.msg = response.data.msg; 
          })
          .catch((error)=>{
              console.log(error)
          })

      },
      // async getPhotoPlace() {
      //     let id = this.$route.params.id;

      //     await axios.post('http://localhost:8085/public/process.php?action=image-get-place&id='+id)
      //     .then((response)=>{
      //         this.photos = response.data.photos; 
      //         console.log(this.photos);
      //     })
      //     .catch((error)=>{
      //         console.log(error)
      //     })
      // }
  },
  mounted() {
      this.getPlace(),
      this.getUsersOfPlace()
  }
}
</script>
