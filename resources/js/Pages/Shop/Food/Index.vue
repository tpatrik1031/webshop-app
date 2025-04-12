<template>
    <AuthenticatedLayout>
        <div class="flex space-x-2 bg-cyan-600 p-2">
            <div @click="resetCategory"
                 class="cursor-pointer px-4 py-2 rounded"
                 :class="!selectedCategory ? 'bg-white text-cyan-600' : 'text-white hover:bg-cyan-500'">
                Összes
            </div>
            <div v-for="category in categories"
                 :key="category.id"
                 @click="chooseCategory(category.name)"
                 class="cursor-pointer px-4 py-2 rounded"
                 :class="selectedCategory === category.name ? 'bg-white text-cyan-600' : 'text-white hover:bg-cyan-500'">
                {{ category.name }}
            </div>
        </div>

        <div class="bg-gray-200 min-h-screen">
            <!-- Termékek -->
            <div class="max-w-6xl mx-auto py-12 space-y-12">
                <div>
                    <h1 class="text-3xl font-bold text-cyan-500 text-center">
                        Kutyaeledelek
                    </h1>
                </div>

                <div v-if="selectedCategory">
                    <h2 class="text-3xl font-bold text-cyan-500 text-center">
                        {{ selectedCategory }} Termékei
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="product in products"
                        :key="product.id"
                        class="h-48 border-2 border-gray-400 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow"
                    >
                        <p class="text-center py-12 font-medium">{{ product.title }}</p>
                    </div>
                </div>

                <div v-if="products.length === 0" class="text-center py-8">
                    <p class="text-gray-500">Nincsenek termékek ebben a kategóriában.</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    products: Array,
    categories: Array,
    selectedCategory: String,
});

// Kategória kiválasztása
const chooseCategory = (categoryName) => {
    router.visit(`/shop/food?category=${encodeURIComponent(categoryName)}`, {
        preserveState: true,
        preserveScroll: true,
        only: ['products', 'selectedCategory'],
    });
};

// Kategória visszaállítása (összes termék megjelenítése)
const resetCategory = () => {
    router.visit('/shop/food', {
        preserveState: true,
        preserveScroll: true,
        only: ['products', 'selectedCategory'],
    });
};
</script>
