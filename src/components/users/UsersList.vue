<template>
    
    <div v-if="users.length">
        <div v-for="user in users" :key="user.id" @click="$router.push(`/user-wish-list/user=${user.id}`)">
            <div class="card" >
                <div class="card-header">
                    <div class="card-header__left">
                        <div>
                            <img class="photo" :src="'/img/' + user.img" />
                        </div>
                        <div>
                            <!-- <p class="card-text">{{ user.firstName }} {{ user.secondName }}</p> -->
                            <p class="card-text">{{ user.nickname }}</p>  
                        </div>
                    </div>
                    <div class="card-header__right">
                        <!-- <p class="card-text">user_id: {{ user.id }}</p>   -->
                        <p class="card-text">{{ user.firstName }} {{ user.secondName }}</p>
                    </div>
                </div>
            </div>        
        </div>
    </div>
    <div v-else>
        <n-empty size="large" class="empty"></n-empty>
    </div>
</template>

<script>
import { NEmpty } from 'naive-ui';

export default {
    props: {
        users: {
            type: Array,
            required: true
        }
    },
    components: {
        NEmpty
    }
}
</script>

<style scoped lang="scss">
@import "@/styles/_variables.scss";
.card {
    // background-color: #fff;
    border: 1px #ccc solid;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 10px;
    cursor: pointer;
}
.card:hover {
   box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
   border: none;
}
.card-header {
    @include flex;
}
.card-header__left {
    
    @include flex;
}
.photo {
    @include photo;
}
</style>