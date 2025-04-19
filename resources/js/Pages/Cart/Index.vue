<template>
    <component :is="layoutComponent" :cartQuantity="totalQuantity" :cartItems="cartItems" :cartProducts="products" :total="total">
      <Notification
        v-if="showNotification"
        :message="notificationMessage"
        :type="notificationType"
        @close="showNotification = false"
      />

      <ItemNotification
        v-if="showNotification"
        :message="notificationMessage"
        :type="notificationType"
        @close="showNotification = false"
      />

      <div class="bg-gray-100 min-h-screen py-12 px-4">
        <div class="max-w-6xl mx-auto space-y-8">
            <div class="flex items-center justify-center gap-4 max-w-6xl mx-auto px-2">
                    <div class="h-px flex-1 bg-gradient-to-r from-transparent via-cyan-500 to-cyan-500"></div>
                    <h1 class="text-3xl font-bold text-cyan-500 p-2 md:p-0 uppercase">
                        Kosár
                    </h1>
                    <div class="h-px flex-1 bg-gradient-to-l from-transparent via-cyan-500 to-cyan-500"></div>
                </div>

          <div v-if="cartItems.length === 0" class="text-center py-12 bg-white rounded-xl shadow-lg">
            <div class="text-xl text-gray-600 mb-4">Jelenleg nincs termék a kosárban.</div>
            <button class="px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-lg shadow transition-all duration-200">
              Vásárlás folytatása
            </button>
          </div>

          <div v-else class="space-y-6">
            <div v-for="(item, index) in products" :key="item.id" class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
              <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <img :src="item.image" alt="product image" class="w-24 h-24 object-cover rounded-lg shadow">
                <div class="flex-grow space-y-2">
                  <h2 class="text-xl font-semibold text-gray-800">{{ item.title }}</h2>
                  <div class="text-cyan-500 font-medium">{{ item.price }} Ft</div>
                </div>
                <div class="flex items-center space-x-3 mt-4 sm:mt-0">
                  <button
                    @click="updateQuantity(item.id, item.quantity - 1), showErrorMessage('Eltávolítva')"
                    :disabled="item.quantity <= 1"
                    class="p-2 w-10 h-10 flex items-center justify-center text-cyan-500 bg-white hover:bg-cyan-500 hover:text-white border-2 border-cyan-500 rounded-lg transition-colors duration-200"
                    :class="{'opacity-50 cursor-not-allowed': item.quantity <= 1}"
                  >
                    <span class="text-lg font-bold">-</span>
                  </button>
                  <span class="text-lg font-medium w-8 text-center">{{ item.quantity }}</span>
                  <button
                    @click="updateQuantity(item.id, item.quantity + 1), showSuccessMessage('Hozzáadta kosarához')"
                    class="p-2 w-10 h-10 flex items-center justify-center text-white bg-cyan-500 hover:bg-cyan-600 rounded-lg transition-colors duration-200"
                  >
                    <span class="text-lg font-bold">+</span>
                  </button>
                  <button
                    @click="removeFromCart(item.id)"
                    class="ml-2 p-2 px-4 text-white bg-red-500 hover:bg-red-600 rounded-lg transition-colors duration-200"
                  >
                    Törlés
                  </button>
                </div>
              </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg mt-8">
              <div class="flex justify-between text-xl font-semibold">
                <span>Összesen:</span>
                <span class="text-cyan-500">{{ total }} Ft</span>
              </div>

              <div v-if="auth.user" class="mt-6 flex justify-end">
                <button
                  @click="orderFinish()"
                  class="py-3 px-8 text-white bg-cyan-500 hover:bg-cyan-600 rounded-lg shadow transition-all duration-200 font-semibold"
                >
                  Vásárlás befejezése
                </button>
              </div>

              <div v-else class="mt-6 flex justify-end">
                <Link
                  :href="route('login')"
                  class="py-3 px-8 text-white bg-cyan-500 hover:bg-cyan-600 rounded-lg shadow transition-all duration-200 font-semibold"
                >
                  Bejelentkezés a vásárláshoz
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </component>
  </template>

<script setup>
import { computed, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Link } from '@inertiajs/vue3';
import ItemNotification from '@/Components/ItemAddOrRemoveNotification.vue';

const props = defineProps({
    layout: Object,
    auth: Object,
    cartItems: Array,
    total: Number,
    products: Array,
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

const updateQuantity = (productId, newQuantity) => {
    if (newQuantity < 1) return;
    axios.post(route('cart.updateQuantity'), { product_id: productId, quantity: newQuantity })
        .then(() => {
            router.reload();
        })
        .catch(error => {
            console.error(error);
        });
};

const removeFromCart = (productId) => {
    axios.post(route('cart.remove'), { product_id: productId })
        .then(() => {
            router.reload();
            showErrorMessage('Sikeresen eltávolítva a kosarából')
        })
        .catch(error => {
            console.error(error);
            showErrorMessage('Hiba a törlés közben')
        });
};

const orderFinish = () => {
    router.get(route('orders.create'));
};

const totalQuantity = computed(() => {
    return props.products.reduce((sum, item) => sum + item.quantity, 0);
});
</script>
