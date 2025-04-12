<script setup>

import FormEntry from '@/Components/Custom/FormEntry.vue'
import { computed } from "vue";

const props = defineProps({
    modelValue: [String, Number],
    possibleValues: Array,
    label: String,
    placeholder: String,
    errors: Object | Array | String | null,
    type: {
        type: String,
        default: 'text',
    },
})

defineEmits(['update:modelValue'])


const hasError = computed(() => {
    if (Array.isArray(props.errors)) {
        return props.errors.length > 0;
    }
    if (typeof props.errors === 'object' && props.errors !== null) {
        return Object.keys(props.errors).length > 0;
    }
    return typeof props.errors === 'string' && props.errors.trim().length > 0;
});
</script>

<template>
    <FormEntry :label="label" :model-value="modelValue" :error="errors">
        <select :value="modelValue" :class="[
            'border border-gray-300 text-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500',
            hasError ? '!border-red-600' : ''
        ]" @input="$emit('update:modelValue', $event.target.value)">
            <option v-if="placeholder" disabled value="">
                {{ placeholder }}
            </option>

            <option v-for="possibleValue in possibleValues" :id="'type_' + possibleValue.value" :key="possibleValue"
                :value="possibleValue.value">
                {{ possibleValue.label }}
            </option>
        </select>
    </FormEntry>
</template>

<style scoped></style>
