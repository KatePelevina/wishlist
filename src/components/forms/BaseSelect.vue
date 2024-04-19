<template>
    <label v-if="label">{{ label }}</label>
    <select
        :value="modelValue"
        class="field"
        v-bind="{
            ...$attrs,
            onChange: ($event) => { $emit('update:modelValue', $event.target.value) }
        }"
    >
        <option 
            v-for="option in options"
            :value="option"
            :key="option"
            :selected="option === modelValue"
            >
            {{ option }}
        </option>
    </select>

    <n-space vertical class="select">
        <n-select  
            v-model:value="currentWish.folder_id" 
            :options="folderSelector"
        />
    </n-space>

    
</template>

<script>
// import { NSelect } from 'naive-ui';

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
        options: {
            type: Array,
            required: true
        }
    },
    // components: {
    //     NSelect
    // }
}

</script>