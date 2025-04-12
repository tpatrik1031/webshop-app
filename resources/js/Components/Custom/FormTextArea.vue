<script setup>
import {computed, onMounted, ref} from 'vue'
import FormEntry from '@/Components/Custom/FormEntry.vue'

const props = defineProps({
    modelValue: [String, Number],
    label: String,
    placeholder: String,
    error: String,
    type: {
        type: String,
        default: 'text',
    },
    classes: String,
    readonly: Boolean,
    disabled: Boolean,
    rows: Number,
})

defineEmits(['update:modelValue'])

const input = ref(null)

onMounted(() => {
    if (input.value && input.value.hasAttribute('autofocus')) {
        input.value.focus()
    }
})

const classes = computed(() => {
    return [
        'block w-full px-3 py-2 text-base font-normal text-gray-700 bg-white border transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:outline-none',
        {
            'border-gray-300 focus:border-indigo-500': !props.error,
            'border-red-500 focus:border-red-600': props.error,
        },
        props.classes,
    ]
})

defineExpose({focus: () => input.value.focus()})
</script>

<template>
    <FormEntry
        :error="error"
        :label="label"
        :model-value="modelValue"
    >
    <textarea
        ref="input"
        :class="classes"
        :disabled="disabled"
        :placeholder="placeholder"
        :readonly="readonly"
        :value="modelValue"
        :rows="rows ?? 4"
        @input="$emit('update:modelValue', $event.target.value)"
    />
    </FormEntry>
</template>

<style scoped>
textarea {
    resize: none;
}
</style>
