<template>
    <div class="card" @click="$router.push(`/place/${id}`)">

        <div class="card-body__left">
                <!-- <img class="card-body__right-img" :src="'/img/' + photo" /> -->
                <img src="@/assets/bag.webp" alt="" class="card-body__right-img">
            </div>
        <div class="card-body__right">
           
         
            <p class="subtitle" @click="showModal=true">Это желание 
                <span class="bold">видят все пользователи</span>
            </p>
        
            <div>
                <div class="name">
                    <h3>Сумка Furla</h3>
                </div>
                <div class="price">
                    <p>300$</p>
                </div>
            </div>
            <!-- <div class="span-category">
                <span class="category">сумки</span>
                <span class="category">fashion</span>
                <span class="category">furla</span>
            </div> -->
            <p>11 декабря 2021</p>
            
        </div>

        

        <!-- <div class="card-body">
            <div class="card-body__right">
                 <img class="card-body__right-img" :src="'/img/' + photo" />
             </div>
            <div class="card-body__left">
                <div>
                    <p>Это желание видят все пользователи</p>
                </div>
                <div>
                    <p>Сумка Furla</p>
                </div>
                <div>
                    <p>300$</p>
                </div>
            </div>
        </div>  -->
    </div>
    
    
</template>

<script>
export default {
    name: 'CardComponent',
    props: ['id','name', 'country', 'city', 'street', 'building', 'description','photo']
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
        &:hover {
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
        }
        display: flex;
        justify-content: space-between;
       
}

.card-body__right-img {
    // width: 150px;
    height: 200px;
    border-radius: 10px;
    width: 100%;
}
// .card-body {
//     display: flex;
//     justify-content: space-between;
// }


// .card-test {
//     background-color: red;
//     width: 50%;
//     border-radius: 10px;
//     padding: 10px;
//     img {
//         width: 100%;
//     }
// }
// .card-test + .card-test {
//     margin-left: 10px;
// }


.card-body__left {
    flex-basis: 40%;
}
.card-body__right {
    flex-basis: 60%;
    margin-right: 30px;
}

.bold {
    font-weight: bold;
}
.subtitle {
    margin-bottom: 20px;
}
.name {
    margin-bottom: 10px;
}
.category {
    padding: 5px;
    background-color: #ccc;
    border-radius: 5px;
}
.span-category {
    margin-top: 30px;
}
</style>
