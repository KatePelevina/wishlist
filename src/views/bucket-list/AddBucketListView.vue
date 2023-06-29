<template>
    <!-- Add New Place -->
    <div class="add-component">

        
        <msg-component
            :errorMsg="this.errorMsg"
            :successMsg="this.successMsg"
         />

        <div>
            <h2>Добавить желание в Bucket List</h2>
            <div class="add-box">
                <form action="">
                    <input type="text" name="name" placeholder="Название" v-model="newBucket.name" required>
                    <input type="text" name="price" placeholder="Цена" v-model="newBucket.price">
                    <input type="text" name="description" placeholder="Описание" v-model="newBucket.description">
                    <input type="text" name="link" placeholder="Ссылка" v-model="newBucket.link">
                    
                    
                    <select name="folder_id" id="folder_id" v-model="newBucket.folder_id">
                        <option disabled value="">Сохранить в папку</option>
                        <option v-for="(folder,index) in folders" :key="index" :value="folder.id">{{ folder.name }}</option> 
                    </select>

                    <select name="visible" id="visible" v-model="newBucket.visible">
                        <option disabled value="">Кто видит желание</option>
                        <option v-for="(visible,index) in visible" :key="index" :value="index">{{ visible }}</option> 
                    </select>
                   
                    <!-- <div>
                        <label>
                            <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
                        </label>
                        <button v-on:click="submitFile()">Submit</button>
                    </div> -->

                    <!-- <input type="file" name="photo" placeholder="Фото"> -->
                    
                    <button class="button" @click="showAddModal=false; addPlace(); clearMsg();">Добавить желание</button>
                </form>
            </div>
        </div>
    </div> 
</template>




<script>
import axios from 'axios';
import MsgComponent from '@/components/layout/MsgComponent.vue';


export default {
    name: 'AddWishListView',
    components: { 
        MsgComponent,
    },
    data() {
        return {
            file: '',
            newBucket: { 
                name: "", 
                price: "",
                folder_id: "",
                description: "",
                photo: 'landscape.png',
                link: "",
                visible: "",
                done: "0"
            },
            errorMsg: "",
            successMsg: "",
            folders: [
                {id: "", name: ""},
            ],
            visible: {
                '1': 'вижу только я',
                '2': 'видят все пользователи',
            }
           
            
        }
    },
    methods: {
        addPlace(){
            let formData = this.toFormData(this.newBucket);

            axios.post("http://localhost:8085/public/process.php?action=add-bucketlist", formData)
            .then((response)=>{
                this.newBucket = {name: "", price: "", description: "",  photo: "", link: "", visible: "", folder_id: "", done: "" };

                if(response.data.error){
                    this.errorMsg = response.data.message;
                } else {
                    this.successMsg = response.data.message;             
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
        clearMsg(){
            this.errorMsg = "";
            this.successMsg = "";
        },
        async getFolders() {
            await axios.get('http://localhost:8085/public/process.php?action=get-bucketlist-folders')
            .then((response)=>{
                
                this.folders = response.data.folders; 
                
                
                console.log(this.folders);
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        // handleFileUpload(){
        //     this.file = this.$refs.file.files[0];
        // },
        // submitFile(){
        //     let formData = new FormData();
        //     formData.append('file', this.file);

        //     axios.post( '/single-file',
        //         formData,
        //         {
        //             headers: {
        //                 'Content-Type': 'multipart/form-data'
        //             }
        //         }
        //         ).then(function(){
        //         console.log('SUCCESS!!');
        //         })
        //         .catch(function(){
        //         console.log('FAILURE!!');
        //         });
        // },
    },
    mounted() {
        this.getFolders()
    }
}
</script>


<style lang="scss" scoped>
@import "@/styles/_variables.scss";
.add-component {
    background-color: $white;
    border-radius: 10px;
    width: 600px;
    padding: 15px;
    margin-top: 0px;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
    h2 {
        margin-bottom: 10px;
    }
    p {
        margin-bottom: 20px;
    }
    input {
        display: block;
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
        width: 100%;
    }
}
.add-box {
    width: 50%;
    margin-left: auto;
    margin-right: auto;
}

.button {
    @include button;
    width: 100%;
}

select {
    width: 100%;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 10px;
}
</style>