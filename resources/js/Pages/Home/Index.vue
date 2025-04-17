<template>
    <component :is="layoutComponent">

        <Notification v-if="showNotification" :message="notificationMessage" :type="notificationType"
            @close="showNotification = false" />

        <div class="bg-gray-100 min-h-screen">
            <div class="w-full h-[750px]">
                <img src="/hero-img.png" alt="Hero" class="w-full h-full object-cover" />
            </div>

            <div class="flex flex-col md:flex-row text-center gap-6 justify-center mb-10 mt-12 mx-2">
                <div
                    class="border rounded-full bg-cyan-500 text-white px-8 py-2 font-semibold text-xl cursor-pointer hover:bg-cyan-400 shadow-md">
                    Rólunk
                </div>
                <div
                    class="border border-cyan-500 rounded-full bg-white text-cyan-500 px-8 py-2 font-semibold text-xl cursor-pointer hover:bg-cyan-500 hover:text-white shadow-md">
                    Kapcsolat
                </div>
                <div
                    class="border rounded-full bg-cyan-500 text-white px-8 py-2 font-semibold text-xl cursor-pointer hover:bg-cyan-400 shadow-md">
                    Segítség
                </div>
            </div>

            <div class="max-w-6xl mx-auto py-12 space-y-12">
                <div class="flex items-center justify-center gap-4 max-w-6xl mx-auto px-2">
                    <div class="h-px flex-1 bg-gradient-to-r from-transparent via-cyan-500 to-cyan-500"></div>
                    <h1 class="text-3xl font-bold text-cyan-500 p-2 md:p-0 uppercase">
                        Kutyaeledelek
                    </h1>
                    <div class="h-px flex-1 bg-gradient-to-l from-transparent via-cyan-500 to-cyan-500"></div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-12 cursor-pointer p-4 col">
                    <div v-for="product in foodProducts" :key="product.id"
                        class="border-2 border-cyan-500 bg-white rounded-md shadow-md hover:shadow-lg transition-shadow relative my-2 md:my-0">
                        <div @click="showProductDetail(product.id)">
                            <img :src="product.media[0]?.original_url" :alt="product.title"
                                class="h-48 w-full object-cover rounded-t-md" />
                        </div>
                        <div class="flex items-center justify-between px-3 py-2">
                            <div>
                                <p class="font-medium text-sm">{{ product.title }}</p>
                                <p class="font-semibold text-sm">{{ product.price }} HUF</p>
                            </div>
                            <div>
                            </div>
                            <div @click="handleAddToCart(product)"
                                class="border rounded-xl p-2 border-cyan-500 bg-cyan-500 hover:bg-cyan-600 focus:bg-cyan-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6 text-white transition-colors duration-200">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-md bg-gray-600 shadow-md hover:shadow-lg hover:bg-gray-500 focus:bg-gray-400 transition-shadow relative my-2 md:my-0">
                        <Link :href="route('shop.food')">
                            <div class="h-full w-full rounded-t-md flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </div>
                        </Link>
                    </div>
                </div>
                <div class="flex items-center justify-center gap-4 max-w-6xl mx-auto px-2">
                    <div class="h-px flex-1 bg-gradient-to-r from-transparent via-cyan-500 to-cyan-500"></div>
                    <h1 class="text-3xl font-bold text-cyan-500 p-2 md:p-0 uppercase">
                        Játékok
                    </h1>
                    <div class="h-px flex-1 bg-gradient-to-l from-transparent via-cyan-500 to-cyan-500"></div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-12 cursor-pointer p-4 col">
                    <div v-for="product in toyProducts" :key="product.id"
                        class="border-2 border-cyan-500 bg-white rounded-md shadow-md hover:shadow-lg transition-shadow relative my-2 md:my-0">
                        <div @click="showProductDetail(product.id)">
                            <img :src="product.media[0]?.original_url" :alt="product.title"
                                class="h-48 w-full object-cover rounded-t-md" />
                        </div>
                        <div class="flex items-center justify-between px-3 py-2">
                            <div>
                                <p class="font-medium text-sm">{{ product.title }}</p>
                                <p class="font-semibold text-sm">{{ product.price }} HUF</p>
                            </div>
                            <div>
                            </div>
                            <div @click="handleAddToCart(product)"
                                class="border rounded-xl p-2 border-cyan-500 bg-cyan-500 hover:bg-cyan-600 focus:bg-cyan-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6 text-white transition-colors duration-200">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-md bg-gray-600 shadow-md hover:shadow-lg hover:bg-gray-500 focus:bg-gray-400 transition-shadow relative my-2 md:my-0">
                        <Link :href="route('shop.toy')">
                            <div class="h-full w-full rounded-t-md flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </div>
                        </Link>
                    </div>
                </div>
                <div class="flex items-center justify-center gap-4 max-w-6xl mx-auto px-2">
                    <div class="h-px flex-1 bg-gradient-to-r from-transparent via-cyan-500 to-cyan-500"></div>
                    <h1 class="text-3xl font-bold text-cyan-500 p-2 md:p-0 uppercase">
                        Kiegészítők
                    </h1>
                    <div class="h-px flex-1 bg-gradient-to-l from-transparent via-cyan-500 to-cyan-500"></div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-12 cursor-pointer p-4 col">
                    <div v-for="product in accessoryProducts" :key="product.id"
                        class="border-2 border-cyan-500 bg-white rounded-md shadow-md hover:shadow-lg transition-shadow relative my-2 md:my-0">
                        <div @click="showProductDetail(product.id)">
                            <img :src="product.media[0]?.original_url" :alt="product.title"
                                class="h-48 w-full object-cover rounded-t-md" />
                        </div>
                        <div class="flex items-center justify-between px-3 py-2">
                            <div>
                                <p class="font-medium text-sm">{{ product.title }}</p>
                                <p class="font-semibold text-sm">{{ product.price }} HUF</p>
                            </div>
                            <div>
                            </div>
                            <div @click="handleAddToCart(product)"
                                class="border rounded-xl p-2 border-cyan-500 bg-cyan-500 hover:bg-cyan-600 focus:bg-cyan-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6 text-white transition-colors duration-200">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-md bg-gray-600 shadow-md hover:shadow-lg hover:bg-gray-500 focus:bg-gray-400 transition-shadow relative my-2 md:my-0">
                        <Link :href="route('shop.accessories')">
                            <div class="h-full w-full rounded-t-md flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </div>
                        </Link>
                    </div>
                </div>
                <div class="flex justify-center items-center pt-28">
                    <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-cyan-500 uppercase text-center">
                        Ismerje meg kedvencei étkezési szokásait, és mindent amit tudni érdemes róluk
                    </h1>
                </div>
                <div class="flex flex-col md:flex-row items-center justify-center gap-4 md:gap-36 justify-center py-4">
                    <div class="relative w-64 h-64 border-1 border-white rounded mt-8 cursor-pointer">
                        <img src="/dogy.webp" alt="Dog" class="w-full h-full object-cover rounded-lg border-2 border-cyan-500 shadow-md" />
                        <div class="absolute bottom-6 right-0 bg-cyan-500 text-white text-xl px-6 py-4 rounded-lg border-2 border-white font-bold uppercase">
                            Kutya
                        </div>
                    </div>
                    <div class="relative w-64 h-64 border-1 border-white rounded mt-8 cursor-pointer">
                        <img src="/cat.jpg" alt="Dog" class="w-full h-full object-cover rounded-lg border-2 border-cyan-500 shadow-md" />
                        <div class="absolute bottom-6 right-0 bg-cyan-500 text-white text-xl px-6 py-4 rounded-lg border-2 border-white font-bold uppercase">
                            Macska
                        </div>
                    </div>
                    <div class="relative w-64 h-64 border-1 border-white rounded mt-8 cursor-pointer">
                        <div class="w-full h-full object-cover rounded-lg bg-cyan-500 border-2 border-white shadow-md" />
                        <div class="absolute bottom-6 right-0 bg-white text-cyan-500 text-xl px-6 py-4 rounded-lg border-2 border-white font-bold uppercase">
                            Egyéb
                        </div>
                    </div>
                </div>
                <div class="flex justify-center items-center pt-28">
                    <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-cyan-500 uppercase text-center">
                        Nálunk mindig ÖN az első
                    </h1>
                </div>
                <div class="flex flex-col md:flex-row justify-center items-center gap-4 md:gap-48 py-12">
                    <div class="text-center cursor-default">
                        <div
                            class="h-24 w-24 bg-white shadow-md rounded-full mx-auto flex items-center justify-center mb-6">
                            <img src="/fast-delivery.webp" alt="Gyors szállítás" class="w-16 h-16 object-contain" />
                        </div>
                        <p class="font-semibold text-lg mb-4">Gyors szállítás</p>
                    </div>
                    <div class="text-center cursor-default">
                        <div
                            class="h-24 w-24 bg-white shadow-md rounded-full mx-auto flex items-center justify-center mb-6">
                            <img src="/gold.jpg" alt="Prémium minőség" class="w-16 h-16 object-contain" />
                        </div>
                        <p class="font-semibold text-lg mb-4">Prémium minőség</p>
                    </div>
                    <div class="text-center cursor-default">
                        <div
                            class="h-24 w-24 bg-white shadow-md rounded-full mx-auto flex items-center justify-center mb-6">
                            <img src="/hun.jpg" alt="Magyarország" class="w-16 h-16 object-contain" />
                        </div>
                        <p class="font-semibold text-lg mb-4">Magyarország</p>
                    </div>
                </div>
            </div>
        </div>
    </component>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { computed, ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import Notification from '@/Components/ItemAddOrRemoveNotification.vue';
import { useCart } from '@/Composables/useCart';

const props = defineProps({
    foodProducts: Array,
    toyProducts: Array,
    accessoryProducts: Array,
    layout: Object,
    auth: Object,
})

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

const { addToCart } = useCart(props.auth.user);

function handleAddToCart(product) {
    addToCart(product, 1);
    showSuccessMessage('Hozzáadta kosarához')
}

const layoutComponent = computed(() => {
    return props.auth?.user ? AuthenticatedLayout : GuestLayout;
});

const showProductDetail = (id) => {
    router.visit(route('shop.product.show', id));
};
</script>
