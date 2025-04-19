<script setup>

const props = defineProps({
    modelValue: {
        type: Number,
        required: true,
    },
    placeholder: String,
    readonly: Boolean,
    min: {
        type: Number,
        required: false,
        default: 0,
    },
    max: {
        type: Number,
        required: false,
        default: Infinity,
    },
    measure: {
        type: String,
        required: false,
        default: null,
    },
    step: {
        type: Number,
        required: false,
        default: 1,
    },
    disabled: {
        type: Boolean,
        required: false,
        default: false
    }
});

const emit = defineEmits(['update:modelValue']);

const onInput = (event) => {
    let value = parseFloat(event.target.value);

    if (!isNaN(value) && value >= props.min && value <= props.max) {
        emit('update:modelValue', value);
    } else {
        event.target.value = props.modelValue;
    }
};

</script>

<template>
    <div class="flex flex-row items-center">
        <input
            :class="[
                'focus:border-cyan-500 rounded-md shadow-sm custom-padding no-arrows w-full',
                {
                    'text-gray-400': disabled
                }
            ]"
            :value="modelValue"
            :placeholder="placeholder"
            :readonly="readonly"
            :disabled="disabled"
            :step="step"
            :min="min"
            :max="max"
            type="number"
            @input="onInput"
        />
        <span v-if="measure" class="pl-1"> {{ measure }}</span>
    </div>
</template>

<style scoped>
.custom-padding {
    padding-top: 0.375rem;
    padding-bottom: 0.375rem;
    border-color: #D1D5DB;
}

.no-arrows {
    -moz-appearance: textfield;
}

.no-arrows::-webkit-inner-spin-button,
.no-arrows::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
