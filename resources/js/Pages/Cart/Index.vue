<template>
    <component :is="layoutComponent" :cartQuantity="totalQuantity">
        <div class="bg-gray-200 min-h-screen py-12 px-4">
            <div class="max-w-6xl mx-auto space-y-8">
                <h1 class="text-4xl font-bold text-cyan-600">Kosár</h1>

                <div v-if="cartItems.length === 0" class="text-center text-lg text-gray-600">
                    Jelenleg nincs termék a kosárban.
                </div>

                <div v-else>
                    <div class="space-y-4">
                        <div v-for="(item, index) in products" :key="item.id" class="bg-white p-4 rounded-lg shadow-md">
                            <div class="flex items-center space-x-4">
                                <img :src="item.image" alt="product image" class="w-16 h-16 object-cover rounded-md">
                                <div class="flex-grow">
                                    <h2 class="text-lg font-semibold">{{ item.title }}</h2>
                                    <div class="text-sm text-gray-500">Ár: {{ item.price }} Ft</div>
                                    <div class="text-sm text-gray-500">Mennyiség: {{ item.quantity }}</div>
                                </div>
                                <div class="space-x-2">
                                    <button @click="updateQuantity(item.id, item.quantity - 1)"
                                            :disabled="item.quantity <= 1"
                                            class="px-4 py-2 text-cyan-500 bg-white hover:bg-cyan-600 hover:text-white border border-cyan-500 rounded-lg">
                                        -
                                    </button>
                                    <button @click="updateQuantity(item.id, item.quantity + 1)"
                                            class="px-4 py-2 text-white bg-cyan-500 hover:bg-cyan-600 rounded-lg">
                                        +
                                    </button>
                                    <button @click="removeFromCart(item.id)"
                                            class="px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg">
                                        Törlés
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-md mt-6">
                        <div class="flex justify-between text-lg font-semibold">
                            <span>Összesen:</span>
                            <span>{{ total }} Ft</span>
                        </div>
                        <div v-if="auth.user" class="mt-4 flex justify-end items-center">
                            <button @click="orderFinish()" class="w-min py-2 text-white bg-cyan-600 hover:bg-cyan-700 rounded-lg px-4">
                                Vásárlás
                            </button>
                        </div>
                        <div v-else class="mt-4 flex justify-end items-center text-center">
                            <Link :href="route('login')" class="w-min py-2 text-white bg-cyan-600 hover:bg-cyan-700 rounded-lg px-4">
                                Vásárlás
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

const props = defineProps({
    layout: Object,
    auth: Object,
    cartItems: Array,
    total: Number,
    products: Array,
});

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
        })
        .catch(error => {
            console.error(error);
        });
};

const orderFinish = () => {
    router.get(route('orders.create'));
};

const totalQuantity = computed(() => {
    return props.products.reduce((sum, item) => sum + item.quantity, 0);
});
</script>
