<template>
    <div class="items" v-if="wishes.length" >
        <div class="item" v-for="(wish,index) in wishes" :key="index">
            <div class="box" @click="$router.push(`/my-bucket-list-item/wish=${wish.id}`)">
                <div class="box-inner">
                    <span v-if="wish.price" class="span">{{ wish.price }} руб</span>

                    <img v-if="wish.photo" :src="'/img/' + wish.photo" alt="">
                    <n-empty v-else size="large" description="Фотографии нет" class="empty"></n-empty>
                </div>
            </div>
            <p class="box-inner__hover">{{ wish.name }}</p>
            <p class="box-inner__hover">{{ wish.date }}</p>
            <p class="box-inner__hover">кто видит: {{ wish.visible }}</p>
            <p class="box-inner__hover">done: {{ wish.done }}</p>
            <p class="box-inner__hover">папка: {{ wish.folder_id }}</p>
        </div>
    </div> 
    <div v-else>
        <n-empty size="large" description="пока ничего нет" class="empty"></n-empty>
        <!-- <p>пока ничего нет</p> -->
    </div>

   

   
</template>

<script>
import { NEmpty } from 'naive-ui';


export default {
    props: {
        wishes: {
            type: Array,
            required: true
        }
    },
    components: {
        NEmpty,
    }

}

</script>

<style lang="scss" scoped>
@import "@/styles/_variables.scss";

.box {
    flex-basis: 49%;
    height: 200px;
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    margin-bottom: 10px;
    border: 1px solid $bg;
    cursor: pointer;
    img {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }
}
.box:hover {
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
    border: none;
}
.box-inner {
    background-color: #fff;
    text-align: center;
    position: relative;
    p {
        opacity: 0;
    }
}
.box-inner:hover {
    p {
        opacity: 1;
        position: absolute;
        bottom: 10px;
        left: 10px;
    }
}
.span {
    background-color: $active;
    color: #fff;
    padding: 5px;
    border-radius: 5px;
    position: absolute;
    top: 10px;
    right: 10px;
}
.items {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}
.item {
   width: 49%;
   margin-bottom: 10px;
}

.flex {
    @include flex;
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
    width: 100%;
}
.empty {
    padding-top: 50px;
    padding-bottom: 50px;
}
</style>