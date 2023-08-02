<template>
    <div class="wrapper">
        <h1>CountriesView.vue</h1>
        <p>Страны</p>
        <ul>
            <li class="card">
                <router-link to="/checklist">Дубай</router-link>
            </li>
            <li class="card">Бали</li>
            <li class="card">Мальдивы</li>
            <li class="card">США</li>
            <li></li>
            <li></li>
        </ul>
    </div>

       
</template>

<style scoped lang="scss">
@import "@/styles/_variables.scss";
.card {
    background-color: #fff;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 10px;
    cursor: pointer;
}



</style>