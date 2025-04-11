<script setup>
import FormEntry from '@/Components/Custom/FormEntry.vue'
import Multiselect from '@vueform/multiselect'
import '../../../css/multiselect.css'
import {ref, watch} from "vue";

const props = defineProps({
    modelValue: Array | Object,
    possibleValues: {
        type: Array,
        required: true,
    },
    createOption: {
        type: Boolean,
        required: false,
        default: false
    },
    closeOnSelect: {
        type: Boolean,
        required: false,
        default: true
    },
    canClear: {
        type: Boolean,
        required: false,
        default: false
    },
    mode: {
        type: String,
        required: false,
        default: 'single'
    },
    searchable: {
        type: Boolean,
        required: false,
        default: false
    },
    disabled: {
        type: Boolean,
        required: false,
        default: false
    },
    type: {
        type: String,
        required: false,
        default: 'text',
    },
    onChange: Function,
    label: String,
    placeholder: String,
    errors: String,
    max: Number,
})

const emit = defineEmits(['update:modelValue']);
const modelValue = ref(props.modelValue);

const clearSelection = () => {
    emit('update:modelValue', []);
};

const deselectOption = (option) => {
    const updatedValue = Array.isArray(modelValue.value)
        ? modelValue.value.filter(item => item !== option)
        : modelValue.value;
    emit('update:modelValue', updatedValue);
};

const selectOption = (option) => {
    if (props.mode.value === 'single') {
        emit('update:modelValue', option.value);
    } else if (Array.isArray(modelValue.value) && !modelValue.value.includes(option)) {
        emit('update:modelValue', [...modelValue.value, option]);
    }
};

const handleSingleChange = (newValue) => {
    emit('update:modelValue', newValue);
}

watch(
    () => props.modelValue,
    (newValue) => {
        modelValue.value = newValue;
    },
    {immediate: true}
);
</script>

<template>
    <FormEntry :error="errors" :label="label">
        <Multiselect
            class="bg-gray-50"
            :value="modelValue"
            :options="possibleValues"
            :mode="mode ?? 'single'"
            :placeholder="placeholder"
            :searchable="searchable"
            :close-on-select="closeOnSelect"
            :create-option="createOption"
            :max="max ?? 100"
            :can-clear="canClear"
            :disabled="disabled"
            append-to-body
            auto-position
            @clear="clearSelection"
            @deselect="deselectOption"
            @select="selectOption"
            @change="handleSingleChange"
        />
        <template v-for="(_, name) in $slots" #[name]="slotProps">
            <slot :name="name" v-bind="slotProps || {}"/>
        </template>
    </FormEntry>
</template>
