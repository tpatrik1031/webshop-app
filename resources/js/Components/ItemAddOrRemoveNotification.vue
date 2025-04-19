<template>
    <Teleport to="body">
      <Transition name="notification">
        <div
          v-if="isVisible"
          :class="[
            'fixed top-6 right-5 p-4 rounded-md mt-8 shadow-lg z-50 max-w-md',
            type === 'success' ? 'bg-cyan-400 text-white border border-white' : 'bg-red-500 text-white'
          ]"
        >
          <div class="flex items-center">
            <div v-if="type === 'success'" class="mr-2">
                <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-6 h-6 text-white hover:text-cyan-600 transition-colors duration-200">
                    <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>
            </div>
            <div v-else class="mr-2">
                <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-6 h-6 text-white hover:text-cyan-600 transition-colors duration-200">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
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
