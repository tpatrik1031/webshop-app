<template>
    <component :is="layoutComponent">
      <Notification
        v-if="showNotification"
        :message="notificationMessage"
        :type="notificationType"
        @close="showNotification = false"
      />

      <div class="max-w-6xl mx-auto py-12 px-4 mt-12 bg-white rounded-xl shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-16 items-start">
          <div class="p-4">
            <img
              :src="product.media[0]?.url"
              alt="Termékkép"
              class="w-full h-auto rounded-lg border border-cyan-500 hover:shadow-xl transition-shadow duration-300"
            />
          </div>
          <div class="space-y-6 p-4 flex flex-col h-full">
            <div class="flex-grow">
              <h1 class="text-3xl font-bold text-cyan-500 mb-2">{{ product.title }}</h1>
              <div class="w-full h-1 bg-cyan-500 rounded mb-4"></div>
              <p class="text-gray-700 text-lg leading-relaxed">
                {{ product.description }}
              </p>

              <div class="text-2xl font-semibold text-cyan-500 mt-6">
                {{ product.price }} Ft
              </div>
            </div>

            <div class="flex flex-wrap justify-between gap-4 pt-6 mt-auto">
              <button
                @click="handleAddToCart"
                class="bg-cyan-500 hover:bg-cyan-600 text-white font-semibold py-3 px-6 rounded-lg shadow transition-all duration-200 flex items-center"
              >
                <span>Kosárba</span>
              </button>
              <button
                @click="buyThisItem()"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg shadow transition-all duration-200 flex items-center border-2 border-green-500"
              >
                <span>Vásárlás</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </component>
  </template>

<script setup>
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { ref } from 'vue';
import axios from 'axios';
import { useCart } from '@/Composables/useCart';
import Notification from '@/Components/ItemAddOrRemoveNotification.vue';

const props = defineProps({
    product: Object,
    layout: Object,
    auth: Object,
});

const showNotification = ref(false);
const notificationMessage = ref('');
const notificationType = ref('success');

const showSuccessMessage = (message) => {
  notificationMessage.value = message;
  notificationType.value = 'success';
  showNotification.value = true;
};

const showErrorMessage = (message) => {
  notificationMessage.value = message;
  notificationType.value = 'error';
  showNotification.value = true;
};

const layoutComponent = computed(() => {
    return props.auth?.user ? AuthenticatedLayout : GuestLayout;
});

const { addToCart } = useCart(props.auth.user);

function handleAddToCart() {
    addToCart(props.product, 1);
    showSuccessMessage('Hozzáadta kosarához')
}

function buyThisItem() {
    addToCart(props.product, 1);
    router.get(route('orders.create'));
}
</script>
