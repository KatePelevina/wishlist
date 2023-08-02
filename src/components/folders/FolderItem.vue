<template>
    <div class="card-test" @click="$router.push(`/${folder.type}/folder=${folder.id}`)">
        <p>{{ folder.name }}</p>
        <!-- <p>{{ folder.date }}</p> -->
        <!-- <p>{{ folder.type }}</p> -->
    </div>
</template>

<script>
export default {
    props: {
        folder: {
            type: Object,
            required: true
        }
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
    padding: 30px;
    margin-bottom: 10px;
    cursor: pointer;
    img {
        width: 100%;
    }
}
.card-test:hover {
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25); 
    border: none;
}
.button {
    @include button;
}
.flex {
    @include flex;
    margin-bottom: 20px;
}
</style>