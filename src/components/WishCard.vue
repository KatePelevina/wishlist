<template>
    <div>
        <div class="card" v-for="(wish,index) in wishes" :key="index">
            
            <div class="flex">
                <div>
                    <p class="card-title">{{ wish.name }}</p>
                </div>
                <div class="card-header__right">
                    <a href="#" @click="showEditModal=true; selectWish(wish);"  >
                        <img src="@/assets/edit-1.svg" alt="" class="place-btn">
                    </a>                     
                    <a href="#" @click="showDeleteModal=true; selectWish(wish);">
                        <img src="@/assets/delete.svg" alt="">
                    </a>
                </div>
            </div>

            <div class="card-body flex">
                <div class="card-body__left">
                    <img :src="'/img/' + wish.photo" alt="" class="card-body__right-img">
                </div>
                <div class="card-body__right">
                    
                    <p class="card-text">Дата создания: {{wish.date}}</p>
                    <p class="card-text">{{ wish.price }}</p>
                </div>           
            </div>

            <div> 
                <div class="show">
                    <p class="subtitle show">Это желание <strong>{{ wish.visible }}</strong></p>
                </div>
                    
                <p class="card-description">{{ wish.description }}</p>
                            
                <div class="card-link">
                    <a :href="wish.link" class="link">Ссылка</a>
                </div>

                <p class="card-book">Это желание забронировано (имя / анонимно): исполню сам(а)</p>
            </div>

        </div>


        
    </div>
</template>

<script>
export default {
    props: {
        wishes: {
            type: Array,
            required: true
        }
    }

}

</script>

<style lang="scss" scoped>
@import "@/styles/_variables.scss";
.card {
       background-color: #fff;
       border-radius: 10px;
       
       padding: 15px;
       margin-bottom: 10px;
       cursor: pointer;
    //    &:hover {
    //        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
    //    }
}
// .card-body__left {
//     display: flex;
//     flex-direction: row;
// }

.card {
    background-color: #fff;
    color: #000;
    border-radius: 10px;
   
    padding: 15px;
    margin-bottom: 10px;
    cursor: pointer;
    // &:hover {
    //     box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
    // }
}
// .card-header {
//     display: flex;
//     align-items: center;
//     justify-content: space-between;
// }
.card-header__left {
    display: flex;
    align-items: center;
}
.card-title {
    font-weight: bold;
    font-size: 24px;
    text-transform: uppercase;
//    line-height: 17px;
}

.card-text {
    font-size: 12px;
}
.flex {
    @include flex;
    align-items: start;
    p {
        margin-right: 10px;
    }
}

.card-body {
    margin-bottom: 20px;
}
.card-body__right {
//    background-color: #000;
    // width: 150px;
    // height: 150px;
    border-radius: 10px;
}
.card-body__right-img {
    
    border-radius: 10px;
    width: 100%;
}

.span {
    display: flex;
}







.hover {
    @include hover;
}
.modal {
    @include modal;
}

.card-body__left {
    width: 50%;
    margin-right: 20px;
}
.card-body__right {
    width: 50%;
}

.show {
    background-color: #F6F7FF;
    display: inline-block;
    border-radius: 10px;
    padding: 5px;
}


.card-description {
    margin-bottom: 10px;
    margin-top: 10px;
}
.card-link {
    margin-top: 20px;
}
.link:hover {
    color: $active;
}

.card-book {
    margin-top: 20px;
}
.bold {
    font-weight: bold;
}

</style>