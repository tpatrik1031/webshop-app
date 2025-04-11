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

    readonly: Boolean,
    disabled: Boolean,
})

defineEmits(['update:modelValue'])

const input = ref(null)

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus()
    }
})

const classes = computed(() => {
    return 'block w-full px-3 py-2 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-500 focus:outline-none'
})

defineExpose({focus: () => input.value.focus()})
</script>

<template>
    <FormEntry
        :error="error"
        :label="label"
        :model-value="modelValue"
    >
        <input
            ref="input"
            :class="classes"
            :disabled="disabled"
            :placeholder="placeholder"
            :readonly="readonly"
            :type="type"
            :value="modelValue"
            @input="$emit('update:modelValue',$event.target.value)"
        />
    </FormEntry>
</template>

<style scoped>

</style>
