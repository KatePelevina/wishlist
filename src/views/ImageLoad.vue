<template>
    <div class="container">
        <div>
            <label>File
                <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
            </label>
            <button v-on:click="submitFile()">Submit</button>
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
            <n-button>Upload File</n-button>
        </n-upload>
       
    </div>
</template>

<script>
import axios from 'axios';
import { NUpload, NButton} from 'naive-ui'



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
        async submitFile(){
            let formData = new FormData();
            formData.append('file', this.file);
            await axios.post( 'http://localhost:8085/public/process.php?action=image-load',
                formData,
                {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
                }
            ).then(function(){
                this.$router('/image-load');
                console.log('SUCCESS!!');
            })
            .catch(function(){
            console.log('FAILURE!!');
            });
        },
        handleFileUpload(){
            this.file = this.$refs.file.files[0];
            console.log(this.file);
        },
    },
}
</script>

<style>
.img-box img {
    width: 200px;
    height: 200px;
    border-radius: 10px;
}
</style>