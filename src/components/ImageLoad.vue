<template>
    <div class="container">
        <!-- <div>
            
            <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
            
            <button v-on:click="submitFile()" >Submit</button>
        </div> -->

        <n-upload
            
            action="http://localhost:8085/public/process.php?action=image-load"
            
        >
            <n-button>Upload File</n-button>
        </n-upload>


       
    </div>
</template>

<script>
// import axios from 'axios';
import { NUpload, NButton} from 'naive-ui'

// import { defineComponent, ref } from "vue";

export default {
    data(){
        return {
            file: ''
        }
    },
    components: {
        NUpload,
        NButton
    },
    methods: {
        // async submitFile(){
        //     let formData = new FormData();
        //     formData.append('file', this.file);
        //     await axios.post( 'http://localhost:8085/public/process.php?action=image-load',
        //         formData,
        //         {
        //         headers: {
        //             'Content-Type': 'multipart/form-data'
        //         }
        //         }
        //     ).then(function(){
        //         // this.$router('/image-load');
        //         location.reload();
        //         console.log('SUCCESS!!');
        //     })
        //     .catch(function(){
        //     console.log('FAILURE!!');
        //     });
        // },
        // handleFileUpload(){
        //     this.file = this.$refs.file.files[0];
        //     console.log(this.file);
        // },
    }
}
</script>

<!-- <style>
.img-box img {
    width: 200px;
    height: 200px;
    border-radius: 10px;
}


</style> -->