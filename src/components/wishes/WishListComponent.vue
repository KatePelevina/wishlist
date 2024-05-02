<template>
    <!-- <div class="items" v-if="wishes.length" >
        <div class="item" v-for="(wish,index) in wishes" :key="index">
            <div class="box" @click="$router.push(`/my-wish-list-item/${wish.id}`)">
                <div class="box-inner">
                    <span v-if="wish.price" class="span">{{ wish.price }} руб</span>
                    <img :src="'/img/' + wish.photo" alt="">
                </div>
            </div>
            <p class="box-inner__hover">{{ wish.name }}</p>
            <p class="box-inner__hover">{{ wish.date }}</p>
            <p class="box-inner__hover">{{ wish.visible }}</p>
        </div>
    </div>

    <div v-else>
        <p>пока ничего нет</p>
    </div> -->

    <div v-if="wishes.length">
        <div class="items">
            <test-component 
            v-for="wish in wishes" 
            :wish="wish"
            :key="wish.id"
            :done="done"
            />
        </div>
    </div>
    <div v-else>
        <n-empty size="large" description="Пока ничего нет" class="empty"></n-empty>
    </div>
    
    
</template>

<script>
import TestComponent from '@/components/TestComponent.vue';
import { NEmpty } from 'naive-ui';
// import { NButton } from 'naive-ui';

export default {
    props: {
        wishes: {
            type: Array,
            required: true
        },
        done: {
            type: Array,
        }
    },
    components: {
        TestComponent,
        NEmpty,
        // NButton
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