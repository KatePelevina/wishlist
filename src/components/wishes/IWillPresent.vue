<template>
    <div class="items" v-if="wishes.length" >
        <div class="item" v-for="(wish,index) in wishes" :key="index">
            <div class="box" @click="$router.push(`/i-will-present-item/wish=${wish.id}`)">

                <span v-if="wish.price" class="span">{{ wish.price }}</span>
                
                <img :src="'/img/' + wish.photo" alt="" v-if="wish.photo">
                <n-empty v-else size="large" description="Фотографии нет" class="empty"></n-empty>
                   
            </div>
            <p class="box-inner__hover">{{ wish.name }}</p>
            <p class="box-inner__hover">{{ wish.date }}</p>
            <p class="box-inner__hover">visible: {{ wish.visible }}</p>
            <p>Я подарю {{ wish.nickname }}</p>
        </div>
    </div>

    <div v-else>
        <n-empty size="large" description="Пока ничего нет" class="empty"></n-empty>
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
        NEmpty
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

    :hover {
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
        border: none;
    }
    img {
        height: 100%;
        width: 100%;
        object-fit: cover;
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
.empty {
    @include empty;
}
</style>