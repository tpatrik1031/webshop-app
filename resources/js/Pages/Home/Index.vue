<template>
    <AuthenticatedLayout>
        <div class="bg-gray-200 min-h-screen">
            <!-- Hero Section -->
            <div class="w-full h-[750px]">
                <img
                    src="/hero-img.png"
                    alt="Hero"
                    class="w-full h-full object-cover"
                />
            </div>

            <!-- Szöveg -->
            <div class="flex text-center gap-6 justify-center my-8">
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

            <!-- Termékek -->
            <div class="max-w-6xl mx-auto py-12 space-y-12">
                <div>
                    <h1 class="text-3xl font-bold text-cyan-500">
                        Kutyaeledelek
                    </h1>
                </div>
                <div v-for="product in foodProducts" :key="product.id" class="grid grid-cols-3 gap-6 cursor-pointer">
                    <div>
                        <div class="h-48 border-2 border-gray-400 bg-white rounded-lg">
                            <img :src="product.media[0]?.original_url" alt="" class="h-full w-full" />
                        </div>
                        <div class="flex justify-between mt-4">
                            <p class="font-bold">
                                {{ product.title }}
                            </p>
                            <p class="font-bold">
                                {{ product.price }} HUF
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-cyan-500">
                        Játékok
                    </h1>
                </div>
                <div v-for="product in toyProducts" :key="product.id" class="grid grid-cols-3 gap-6 cursor-pointer">
                    <div>
                        <div class="h-48 border-2 border-gray-400 bg-white rounded-lg">
                            <img :src="product.media[0]?.original_url" alt="" class="h-full w-full" />
                        </div>
                        <div class="flex justify-between mt-4">
                            <p class="font-bold">
                                {{ product.title }}
                            </p>
                            <p class="font-bold">
                                {{ product.price }} HUF
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-cyan-500">
                        Kiegészítők
                    </h1>
                </div>
                <div v-for="product in accessoryProducts" :key="product.id" class="grid grid-cols-3 gap-6 cursor-pointer">
                    <div>
                        <div class="h-48 border-2 border-gray-400 bg-white rounded-lg">
                            <img :src="product.media[0]?.original_url" alt="" class="h-full w-full" />
                        </div>
                        <div class="flex justify-between mt-4">
                            <p class="font-bold">
                                {{ product.title }}
                            </p>
                            <p class="font-bold">
                                {{ product.price }} HUF
                            </p>
                        </div>
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
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    foodProducts: Array,
    toyProducts: Array,
    accessoryProducts: Array,
})
</script>
