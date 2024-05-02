<template>
    <div class="search">
        <input class="search-input" :value="modelValue" @input="updateInput" type="search" placeholder="Поиск">
    </div>
</template>

<script>


export default ({
    name: 'my-input',
    props: {
        modelValue: [ String, Number ],
    },
    methods: {
        updateInput(event) {
            this.$emit('update:modelValue', event.target.value)
        }
    }
})
</script>

<style lang="scss" scoped>
.search-input  {
    width: 100%;
    border-radius: 5px;
    border: 1px #ccc solid;
    padding: 15px 40px;
    // margin-top: 15px;
    // margin-bottom: 15px;
}

.search {
    position: relative;
    margin-bottom: 20px;
    &:before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 15px;
        margin: auto 0;
        width: 20px;
        height: 20px;
        background: url('@/assets/search-input.svg') no-repeat;
        background-size: cover;
    }
}
</style>