<template>
    <component :is="layoutComponent">
        <div class="bg-gray-200 min-h-screen">
            <div class="w-full h-[750px]">
                <img
                    src="/hero-img.png"
                    alt="Hero"
                    class="w-full h-full object-cover"
                />
            </div>

            <div class="flex flex-col md:flex-row text-center gap-6 justify-center my-8 mx-2">
                <div class="border rounded-full bg-cyan-500 text-white px-8 py-2 font-semibold text-xl cursor-pointer hover:bg-cyan-400 shadow-md">
                    Rólunk
                </div>
                <div class="border rounded-full bg-white text-cyan-500 px-8 py-2 font-semibold text-xl cursor-pointer hover:bg-gray-100 shadow-md">
                    Kapcsolat
                </div>
                <div class="border rounded-full bg-cyan-500 text-white px-8 py-2 font-semibold text-xl cursor-pointer hover:bg-cyan-400 shadow-md">
                    Segítség
                </div>
            </div>
            
            <div class="max-w-6xl mx-auto py-12 space-y-12">
                <div>
                    <h1 class="text-3xl font-bold text-cyan-500 p-2 md:p-0">
                        Kutyaeledelek
                    </h1>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-12 cursor-pointer p-4">
                    <div
                        v-for="product in foodProducts"
                        :key="product.id"
                        @click="showProductDetail(product.id)"
                        class="h-48 border-2 border-gray-400 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow relative my-2 md:my-0"
                    >
                        <img :src="product.media[0]?.original_url" alt="" class="h-full w-full pb-8" />
                        <p class="absolute bottom-2 left-2 font-medium text-sm">{{ product.title }}</p>
                        <p class="absolute bottom-2 right-2 font-semibold text-sm">{{ product.price }} HUF</p>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-cyan-500 p-2 md:p-0">
                        Játékok
                    </h1>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-12 cursor-pointer p-4">
                    <div
                        v-for="product in toyProducts"
                        :key="product.id"
                        @click="showProductDetail(product.id)"
                        class="h-48 border-2 border-gray-400 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow relative my-2 md:my-0"
                    >
                        <img :src="product.media[0]?.original_url" alt="" class="h-full w-full pb-8" />
                        <p class="absolute bottom-2 left-2 font-medium text-sm">{{ product.title }}</p>
                        <p class="absolute bottom-2 right-2 font-semibold text-sm">{{ product.price }} HUF</p>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-cyan-500 p-2 md:p-0">
                        Kiegészítők
                    </h1>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-12 cursor-pointer p-4">
                    <div
                        v-for="product in accessoryProducts"
                        :key="product.id"
                        @click="showProductDetail(product.id)"
                        class="h-48 border-2 border-gray-400 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow relative my-2 md:my-0"
                    >
                        <img :src="product.media[0]?.original_url" alt="" class="h-full w-full pb-8" />
                        <p class="absolute bottom-2 left-2 font-medium text-sm">{{ product.title }}</p>
                        <p class="absolute bottom-2 right-2 font-semibold text-sm">{{ product.price }} HUF</p>
                    </div>
                </div>
            </div>

            <div class="max-w-3xl mx-auto rounded-xl p-8">
                <div class="flex justify-center items-center text-cyan-500 text-xl font-bold uppercase tracking-wider mb-6">
                    <span class="text-2xl px-2">🐾</span>
                    Tápláló Kutyaeledelek
                    <span class="text-2xl px-2">🐾</span>
                </div>

                <div class="text-center text-gray-700 text-lg">
                    A <span class="font-semibold text-gray-800">prémium minőségű kutyaeledelek</span> gondosan kiegyensúlyozott összetételben tartalmazzák a létfontosságú tápanyagokat: magas minőségű fehérjéket, egészséges szénhidrátokat, esszenciális zsírokat, valamint vitaminokat és ásványi anyagokat.

                    <p class="mt-4">
                    Az ideális táplálék kiválasztása mindig figyelembe veszi kedvenced egyedi igényeit, beleértve korát, méretét, fajtáját, aktivitási szintjét és esetleges egészségügyi sajátosságait.
                    </p>
                </div>

                <div class="mt-6 text-center text-cyan-500 font-medium">
                    A megfelelő táplálék a boldog és egészséges kutyaélet alapja!
                </div>
            </div>
        </div>
    </component>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    foodProducts: Array,
    toyProducts: Array,
    accessoryProducts: Array,
    layout: Object,
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    auth: Object,
})

const layoutComponent = computed(() => {
    return props.auth?.user ? AuthenticatedLayout : GuestLayout;
});

const showProductDetail = (id) => {
    router.visit(route('shop.product.show', id));
};
</script>
