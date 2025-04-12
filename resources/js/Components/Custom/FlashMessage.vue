<script setup>
import { usePage } from '@inertiajs/vue3'
import { computed, onMounted, ref } from 'vue';
import { trans } from 'laravel-vue-i18n'

const page = usePage();

const props = defineProps({
    message: String,
    type: String
});

const isVisible = ref(false);

const hideMessage = () => {
    isVisible.value = false;
    page.props.flash.messages = [];
}

onMounted(() => {
    isVisible.value = true;

    setTimeout(() => {
        hideMessage();
    }, 3000);
});

const getTypeClass = computed(() => {
    return `flash-${props.type}`;
})
</script>

<style>
.flash-message {
    font-size: .95em;
    color: #fff;
    padding: 1rem;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 10px;
    align-items: center;
    z-index: 9999 !important;
}

.flash-error {
    background-color: #ff5252;
}

.flash-success {
    background-color: #4caf50;
}

.flash-warning {
    background-color: #ffab40;
}

.flash-message-enter-active,
.flash-message-leave-active {
    transition: opacity 0.5s, transform 0.5s;
}

.flash-message-enter-from,
.flash-message-leave-to {
    opacity: 0;
    transform: translateY(-20px);
}
</style>

<template>
    <transition name="flash-message">
        <div v-if="isVisible" :class="[getTypeClass, 'flash-message', 'cursor-pointer', 'w-[300px]']"
            @click="hideMessage" class="cursor-pointer w-[300px]">
            <div>{{ trans(message) }}</div>
            <button>&times;</button>
        </div>
    </transition>
</template>
