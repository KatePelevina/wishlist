
<template>
    <div class="cards" v-if="folders.length">
       
        <UserFolderItem
            v-for="folder in folders" 
            :folder="folder"
            :key="folder.id"
        />
    </div>
    <div v-else>
        <n-empty size="large" description="Пока ничего нет"></n-empty>
    </div>
</template>

<script>
import UserFolderItem from '@/components/folders/UserFolderItem.vue';
import { NEmpty } from 'naive-ui';


export default {
    components: {
        UserFolderItem,
        NEmpty
    },
    props: {
        folders: {
            type: Array,
            required: true
        },
    }
}


</script>

<style lang="scss" scoped>
@import "@/styles/_variables.scss";

.cards {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}
.card-test {
    flex-basis: 49%;
    border-radius: 10px;
    background-color: #fff;
  
    border: 1px #ccc solid;

    padding: 30px;
    margin-bottom: 10px;
    cursor: pointer;
    img {
        width: 100%;
    }
}
.button {
    @include button;
}
.flex {
    @include flex;
    margin-bottom: 20px;
}
</style>