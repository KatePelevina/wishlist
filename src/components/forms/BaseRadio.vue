<template>
    <label v-if="label">{{ label }}</label>
    <input 
        type="radio"
        :checked="modelValue === value"
        :value="value"
        @change="$emit('update:modelValue', value)"
        v-bind="$attrs"
    >
</template>

<script>
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
        value: {
            type: [String, Number],
            required: true
        }
    }
}

</script>