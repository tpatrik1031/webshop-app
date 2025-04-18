<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  show: Boolean,
  cartItems: Array,
  products: Array,
  total: Object,
});

defineEmits(['close']);
</script>

<template>
  <div v-if="show" @click.self="$emit('close')" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-start justify-end">
    <div class="bg-cyan-500 w-full sm:w-[400px] h-screen shadow-lg flex flex-col">
      <div class="bg-cyan-500 p-6">
        <div class="flex justify-between items-center">
          <h2 class="text-2xl font-bold text-white">Kosár</h2>
          <button @click="$emit('close')" class="text-white hover:text-gray-200 text-xl">&times;</button>
        </div>
      </div>
      <div class="bg-white flex-1 overflow-y-auto">
        <div v-if="cartItems === 0" class="p-6 text-gray-600 text-center">
          A kosár üres.
        </div>
        <div v-else class="divide-y">
          <div
            v-for="item in products"
            :key="item.id"
            class="p-6 bg-white flex space-x-4"
          >
            <img
              :src="item.image"
              class="w-16 h-16 object-cover rounded-md"
              alt="Product image"
            />
            <div class="flex-1">
              <h3 class="text-md font-semibold">{{ item.title }}</h3>
              <div class="text-sm text-gray-500">Ár: {{ item.price }} Ft</div>
              <div class="text-sm text-gray-500">Mennyiség: {{ item.quantity }}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-white p-6 border-t border-gray-200">
        <div class="flex justify-between font-semibold text-lg mb-4">
          <span>Összesen:</span>
          <span>{{ total }} Ft</span>
        </div>
        <Link :href="route('cart.index')" @click="$emit('close')" class="block w-full text-center bg-cyan-600 hover:bg-cyan-700 text-white py-2 rounded-lg">
          Ugrás a kosárhoz
        </Link>
      </div>
    </div>
  </div>
</template>
