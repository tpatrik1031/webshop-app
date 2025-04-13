<template>
    <AuthenticatedLayout>
        <div class="max-w-6xl mx-auto py-12 px-4">
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
                            class="bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-2 px-4 rounded-lg shadow"
                        >
                            Kosárba
                        </button>
                        <button
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow"
                        >
                            Vásárlás
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    product: Object,
});
</script>
