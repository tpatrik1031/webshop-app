<script setup>
import Modal from './Modal.vue'

const emit = defineEmits(['close'])

defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
})

const close = () => {
    emit('close')
}
</script>

<template>
    <Modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
        <div class="flex justify-end items-center px-4 py-1 bg-[#f3f4f6]">
            <button @click="close" class="p-2 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <div class="px-6 py-4">
            <div class="text-xl font-medium text-gray-900 text-center">
                <slot name="title" />
            </div>

            <div class="mt-4 text-sm text-gray-600 text-center">
                <slot name="content" />
            </div>
        </div>

        <div class="flex flex-row justify-between px-6 py-4 text-center">
            <slot name="footer" />
        </div>
    </Modal>
</template>
