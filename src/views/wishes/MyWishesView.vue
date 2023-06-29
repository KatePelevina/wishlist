<template>

  <h2>Все желания {{ places.length }}</h2>
  <h2>Fashion (название папки)</h2>
  

  <div 
  v-for="(place,index) in places" 
  :key="index"
  >
      <card-component
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
      
</template>

<script>
import axios from 'axios';
import CardComponent from '@/components/CardComponent.vue'

export default {
  name: 'MyPlaces',
  components: {
      CardComponent
  },
  data() {
      return {
          places:[],
          pages: 3,
          currentPage: 1,
      }
  },
  methods: {
      async getAllPlaces(){
          await axios.get('http://localhost:8085/public/process.php?action=read')
          .then((response)=>{
              this.places = response.data.places; 
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
      }
  },
  mounted() {
      this.getAllPlaces()
  }
}
</script>