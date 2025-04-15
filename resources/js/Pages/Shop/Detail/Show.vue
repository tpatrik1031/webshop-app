<template>
    <component :is="layoutComponent">
        <div class="max-w-6xl mx-auto py-12 px-4 mt-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-32 items-start">
                <div>
                    <img
                        :src="product.media[0]?.url"
                        alt="Termékkép"
                        class="w-full h-auto rounded-lg shadow-md"
                    />
                </div>
                <div class="space-y-6">
                    <h1 class="text-3xl font-bold text-cyan-600">{{ product.title }}</h1>
                    <p class="text-gray-700 text-lg leading-relaxed">
                        {{ product.description }}
                    </p>

                    <div class="text-2xl font-semibold text-green-600">
                        {{ product.price }} Ft
                    </div>

                    <div class="flex space-x-4 pt-4">
                        <button
                            @click="handleAddToCart"
                            class="bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-2 px-4 rounded-lg shadow"
                        >
                            Kosárba
                        </button>
                        <button
                            @click="buyThisItem()"
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow"
                        >
                            Vásárlás
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

const props = defineProps({
    product: Object,
    layout: Object,
    auth: Object,
});

const layoutComponent = computed(() => {
    return props.auth?.user ? AuthenticatedLayout : GuestLayout;
});

const { addToCart } = useCart(props.auth.user);

function handleAddToCart() {
    addToCart(props.product, 1);
}

function buyThisItem() {
    addToCart(props.product, 1);
    router.get(route('orders.create'));
}
</script>
