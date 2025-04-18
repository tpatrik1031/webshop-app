<template>
    <component :is="layoutComponent">

        <Notification
            v-if="showNotification"
            :message="notificationMessage"
            :type="notificationType"
            @close="showNotification = false"
        />

        <div class="flex space-x-2 bg-cyan-500 p-2 items-center justify-center">
            <div @click="resetCategory"
                 class="cursor-pointer px-4 py-2 rounded-lg"
                 :class="!selectedCategory ? 'bg-white text-cyan-600' : 'text-white'">
                Összes
            </div>
            <div v-for="category in categories"
                 :key="category.id"
                 @click="chooseCategory(category.name)"
                 class="cursor-pointer px-4 py-2 rounded-lg"
                 :class="selectedCategory === category.name ? 'bg-white text-cyan-600' : 'text-white hover:text-cyan-500 hover:bg-white'">
                {{ category.name }}
            </div>
        </div>

        <div class="bg-gray-100 min-h-screen">
            <div class="max-w-6xl mx-auto py-12 space-y-12">
                <div class="flex items-center justify-center gap-4 max-w-6xl mx-auto px-2">
                    <div class="h-px flex-1 bg-gradient-to-r from-transparent via-cyan-500 to-cyan-500"></div>
                    <h1 class="text-3xl font-bold text-cyan-500 p-2 md:p-0 uppercase">
                        Kutyaeledelek
                    </h1>
                    <div class="h-px flex-1 bg-gradient-to-l from-transparent via-cyan-500 to-cyan-500"></div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-12 cursor-pointer p-4 col">
                    <div
                        v-for="product in products.data"
                        :key="product.id"
                        class="border-2 border-cyan-500 bg-white rounded-md shadow-md hover:shadow-lg transition-shadow relative my-2 md:my-0"
                    >
                        <div @click="showProductDetail(product.id)">
                            <img v-if="product.media && product.media.length"  :src="product.media[0]?.url" alt="" class="h-48 w-full object-cover rounded-t-md" />
                        </div>
                        <div class="flex items-center justify-between px-3 py-2">
                        <div>
                            <p class="font-medium text-sm">{{ product.title }}</p>
                            <p class="font-semibold text-sm">{{ product.price }} HUF</p>
                        </div>
                        <div>

                        </div>
                        <div
                            @click="handleAddToCart(product)"
                            class="border rounded-xl p-2 border-cyan-500 hover:bg-cyan-500">
                            <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6 text-cyan-500 hover:text-white transition-colors duration-200"
                        >
                            <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"
                            />
                        </svg>
                        </div>
                        </div>
                    </div>
                </div>
                <div v-if="products.length === 0" class="text-center py-8">
                    <p class="text-gray-500">Nincsenek termékek ebben a kategóriában.</p>
                </div>
                <div class="mt-4 flex justify-center items-center space-x-2 gap-8">
                    <Button
                        variant="secondary"
                        :disabled="pagination.current_page === 1"
                        @click="goToPage(pagination.current_page - 1)"
                        class="px-3 py-1 border rounded"
                    >
                        <PaginationLeftArrowIcon :width="18" :height="18" />
                    </Button>

                    <span>{{ pagination.current_page }} / {{ pagination.last_page }}</span>

                    <Button
                        variant="secondary"
                        :disabled="pagination.current_page === pagination.last_page"
                        @click="goToPage(pagination.current_page + 1)"
                        class="px-3 py-1 border rounded"
                    >
                        <PaginationRightArrowIcon :width="18" :height="18" />
                    </Button>
                </div>
            </div>
        </div>
    </component>
</template>

<script setup>
import { ref,computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { useCart } from '@/Composables/useCart';
import Notification from '@/Components/ItemAddOrRemoveNotification.vue';
import Button from "@/Components/Button.vue";
import PaginationRightArrowIcon from "@/Components/Assets/PaginationRightArrowIcon.vue";
import PaginationLeftArrowIcon from "@/Components/Assets/PaginationLeftArrowIcon.vue";

const props = defineProps({
    products: Object,
    categories: Array,
    selectedCategory: String,
    layout: Object,
    auth: Object,
    pagination: Object,
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

const chooseCategory = (categoryName) => {
    router.visit(`/shop/food?category=${encodeURIComponent(categoryName)}`, {
        preserveState: true,
        preserveScroll: true,
        only: ['products', 'selectedCategory'],
    });
};

const resetCategory = () => {
    router.visit('/shop/food', {
        preserveState: true,
        preserveScroll: true,
        only: ['products', 'selectedCategory'],
    });
};

const showProductDetail = (id) => {
    router.visit(route('shop.product.show', id));
};

const layoutComponent = computed(() => {
    return props.auth?.user ? AuthenticatedLayout : GuestLayout;
});

const { addToCart } = useCart(props.auth.user);

function handleAddToCart(product) {
    console.log(product);
    addToCart(product, 1);
    showSuccessMessage('Hozzáadta kosarához')
}

function goToPage(page) {
  router.get(route('shop.food'), { page }, { preserveScroll: false, preserveState: true });
}
</script>
