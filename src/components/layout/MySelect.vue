<template>
    <select :value="modelValue" @change="changeOption">
        <option disabled value="">Сортировать</option>
        <option 
            v-for="option in options" 
            :key="option.value" 
            :value="option.value"
            >
            {{ option.name }}
        </option>
    </select>

    <n-space vertical>
        <n-select v-model:value="value" :options="options" />
    </n-space>
</template>

<script>


export default ({
        name: 'my-select',
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
                this.$emit('update:modelValue', event.target.value)
            }
        },
        
        
        });

</script>


<style>
select {
    width: 100%;
    padding: 14px;
    border-radius: 10px;
    border: 1px #ccc solid;
    height: 100%;
}

</style>