<script setup>
import {trans} from 'laravel-vue-i18n'
import InputLabel from '@/Components/InputLabel.vue'

const props = defineProps({
    placeholder: String | null,
    label: String | null,
    options: Array,
    id: String,
    modelValue: [String, Number],
})

const emit = defineEmits(['update:modelValue'])
</script>

<template>
    <div class="col-span-6 sm:col-span-6">
        <InputLabel v-if="label" :for="id" :value="trans(label)"/>

        <select
            :id="id"
            :value="modelValue"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            @input="$emit('update:modelValue', $event.target.value)"
        >
            <option disabled value="">
                {{ placeholder ? trans(placeholder) : trans('Select an option...') }}
            </option>
            <option v-for="(option, index) in options" :key="index" :value="option.value">
                {{ option.text }}
            </option>
        </select>
    </div>
</template>
