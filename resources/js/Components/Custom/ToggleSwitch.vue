<script setup>
import {ref, watch} from "vue";

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['update:modelValue']);

const checkbox = ref(props.modelValue);

watch(checkbox, (newValue) => {
    emit('update:modelValue', newValue)
});

const toggleCheckbox = () => {
    checkbox.value = !checkbox.value;
};
</script>

<template>
    <div class="panel-body">
        <label class="switch">
            <input type="checkbox" :checked="checkbox" @click="toggleCheckbox">
            <div class="slider round"></div>
        </label>
    </div>
</template>

<style scoped>
.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}

.switch input {
    display: none;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: #3A36DB;
    transition: 0.4s;
}

input:checked + .slider:before {
    transform: translateX(24px);
}

.slider.round {
    border-radius: 24px;
    background-color: white;
    border: 1px solid #3A36DB;
}

.slider.round:before {
    border-radius: 50%;
}
</style>
