<template>
    <!-- <label>{{ label }}</label>
    <input 
        v-bind="$attrs"
        :placeholder="label"
        class="fiels"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    > -->

    <label>{{ label }}</label>
    <n-input 
        v-bind="$attrs"
        :placeholder="label"
        :value="modelValue"  
        @input="$emit('update:modelValue', $event.target.value)"
    />
    <p v-if="error" class="errorMsg">{{ error }}</p>
</template>

<script>
import { NInput} from 'naive-ui'

export default {
    props: {
        label: {
            type: String,
            default: ''
        },
        modelValue: {
            type: [String, Number],
            default: ''
        },
        error: {
            type: String,
            default: ''
        }
    },
    components: {
        NInput
    }
}

</script>

<style scoped>
.errorMsg {
    color: red;
}
</style>