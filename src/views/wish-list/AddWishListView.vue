<template>
    <!-- Add New Place -->
    <div class="add-component">

        
        <msg-component
            :errorMsg="this.errorMsg"
            :successMsg="this.successMsg"
         />

        <div>
            <h2>Добавить желание в Wish List</h2>
            <div class="add-box">
                <form action="">
                    <input type="text" name="name" placeholder="Название" v-model="newWish.name">
                    <input type="text" name="name" placeholder="Цена" v-model="newWish.price">
                    <input type="text" name="description" placeholder="Описание" v-model="newWish.description">
                    <input type="text" name="link" placeholder="Ссылка" v-model="newWish.link">

                    <select name="folder_id" id="folder_id" v-model="newWish.folder_id" >
                        <option disabled value="" selected>Сохранить в папку</option>
                        <option v-for="(folder,index) in folders" :key="index" :value="folder.id">{{ folder.name }}</option> 
                    </select>

                    <select name="visible" id="visible" v-model="newWish.visible">
                        <option disabled value="">Кто видит желание</option>
                        <option v-for="(visible,index) in visible" :key="index" :value="index">{{ visible }}</option> 
                    </select>

                    


                    
                   
                    <!-- <input type="text" name="folder_id" id="folder_id" placeholder="В какую папку сохранить" v-model="newWish.folder_id"> -->

                    <!-- <n-tooltip trigger="hover">
                        <template #trigger>
                            <input type="text" name="folder_id" id="folder_id" placeholder="В какую папку сохранить" v-model="newWish.folder_id">
                        </template>
                        Введите название существующей папки
                    </n-tooltip> -->


                    <!-- <input type="text" name="description" placeholder="Ссылка" v-model="newWish.link"> -->
                    
                    <!-- <input type="file"> -->

                    <!-- <n-space vertical>
                        <n-select v-model:value="value" :options="options" />
                    </n-space>

                    <n-space vertical>
                        <n-input v-model:value="value" type="text" placeholder="Basic Input" />
                    </n-space>

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
                    </n-upload> -->

                    <button class="button" @click="addWishList()">Добавить желание</button>
                </form>
                
            </div>
        </div>
    </div> 
</template>




<script>
import axios from 'axios';
import MsgComponent from '@/components/layout/MsgComponent.vue';
// import { NTooltip} from 'naive-ui'
// import { NUpload, NButton, NSpace, NInput, NSelect } from 'naive-ui'


export default {
    name: 'AddWishListView',
    components: { 
        MsgComponent,
        // NTooltip
        // NUpload,
        // NButton,
        // NSpace,
        // NInput,
        // NSelect
    },
    data() {
        return {
            newWish: { 
                name: "", 
                price: "",
                description: "",
                link: "",
                visible: "",
                photo: 'landscape.png',
                folder_id: "",
                done: "0",
                wish_list: '1',
                bucket_list: '0'
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
        addWishList(){
            let formData = this.toFormData(this.newWish);

            axios.post("http://localhost:8085/public/process.php?action=add-wishlist", formData)
            .then((response)=>{
                this.newWish = {name: "", price: "", description: "", photo: "", link: "", visible: "", folder_id: "", done: "", wish_list: "", bucket_list: "" };
                
                if (response.data.error) {
                    this.errorMsg = response.data.message;
                } else {
                    
                    // location.reload(); 
                    this.successMsg = response.data.message;
                    // this.$router.push('/'); 
                                  
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
            await axios.get('http://localhost:8085/public/process.php?action=get-wishlist-folders')
            .then((response)=>{
                
                this.folders = response.data.folders; 
            })
            .catch((error)=>{
                console.log(error)
            })
        },
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
    width: 100%;
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
        @include input;
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
