<template>
    <div class="item">
        <div class="box" @click="$router.push(`/my-wish-list-item/wish=${wish.id}`)">
            <div class="box-inner">
                <span v-if="wish.price" class="span">{{ wish.price }} $</span>
                <div>
                    <img :src="'/img/' + wish.photo" alt="photo" v-if="wish.photo">
                    <n-empty v-else size="large" description="Фотографии нет" class="empty"></n-empty>
                </div>
                
            </div>
        </div>
        <div class="flex">
            <img src="@/assets/lock.png" alt="icon" class="nav-item__icon" v-if="wish.visible == 0"> 
            <p class="box-inner__hover">{{ wish.name }}</p>

        </div>

        <!-- <p class="box-inner__hover">{{ wish.date }}</p> -->

        <!-- <p class="box-inner__hover">Кто видит: {{ wish.visible }}</p> -->
        <!-- <p class="box-inner__hover">Папка: {{ wish.folder_id }}</p> -->
        <!-- <p class="box-inner__hover">done: {{ wish.done }}</p> -->

        <!-- <p>done: {{ statusToText[wish.done] }}</p> -->
        <!-- <p>желание: {{ statusOFvisible[wish.visible] }}</p> -->
       
        
    </div>
</template>

<script>
import { NEmpty } from 'naive-ui';


export default {
    props: {
        wish: {
            type: Object,
            requered: true
        },
        done: {
            type: Array
        }
    },
    components: {
        NEmpty
    },
    data() {
        return {
            statusOFvisible: {
                '0': 'вижу только я',
                '1': 'видят все пользователи'
            },
            statusToText: {
                '0': 'хочу',
                '1': 'исполнено',
            }
        }
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
   justify-content: flex-start;
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
    @include empty;
}

.nav-item__icon {
    width: 30px;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 5px;
}

</style>