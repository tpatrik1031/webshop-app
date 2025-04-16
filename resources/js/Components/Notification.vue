<template>
    <Teleport to="body">
      <Transition name="notification">
        <div
          v-if="isVisible"
          :class="[
            'fixed top-5 right-5 p-4 rounded-md shadow-lg z-50 max-w-md',
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
          ]"
        >
          <div class="flex items-center">
            <div v-if="type === 'success'" class="mr-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <div v-else class="mr-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </div>
            <div class="flex-1">{{ message }}</div>
            <button
              @click="hideNotification"
              class="ml-4 text-white hover:text-gray-200 focus:outline-none"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </Transition>
    </Teleport>
  </template>

  <script setup>
  import { ref, defineProps, defineEmits, onMounted } from 'vue';

  const props = defineProps({
    message: {
      type: String,
      required: true
    },
    type: {
      type: String,
      default: 'success',
      validator: (value) => ['success', 'error'].includes(value)
    },
    duration: {
      type: Number,
      default: 5000
    },
    autoClose: {
      type: Boolean,
      default: true
    }
  });

  const emit = defineEmits(['close']);
  const isVisible = ref(false);

  const hideNotification = () => {
    isVisible.value = false;
    emit('close');
  };

  onMounted(() => {
    isVisible.value = true;

    if (props.autoClose && props.duration > 0) {
      setTimeout(() => {
        hideNotification();
      }, props.duration);
    }
  });
  </script>

  <style scoped>
  .notification-enter-active,
  .notification-leave-active {
    transition: all 0.3s ease;
  }

  .notification-enter-from,
  .notification-leave-to {
    transform: translateX(20px);
    opacity: 0;
  }
  </style>
