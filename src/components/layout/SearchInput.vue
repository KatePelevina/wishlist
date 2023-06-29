<template>
    <div class="search">
        <input class="search-input" type="search" placeholder="Искать" :value="modelValue" @change="changeOption">
    </div>
</template>

<script>
export default {
    name: 'SearchInput', 
    props: {
        modelValue: {
            type: String,
        },
        options: {
            type: Array,
            default: ()=> []
        }
    },
    methods: {
        changeOption(event) {
            console.log(event);
            this.$emit('update:modelValue', event.target.value)
        }
    },
}
</script>

<style lang="scss" scoped>
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
    &-input {
        width: 100%;
        height: 100%;
        border-radius: 10px;
        border: none;
        padding: 15px 50px;
    }
}
</style>