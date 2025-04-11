<template>
    <AuthenticatedLayout>
        <div class="bg-cyan-500 py-3">
            <p class="px-2 text-white">
                asd
            </p>
        </div>
        <div class="bg-gray-200 min-h-screen">

            <!-- Termékek -->
            <div class="max-w-6xl mx-auto py-12 space-y-12">
                <div>
                    <h1 class="text-3xl font-bold text-cyan-500 text-center">
                        Játékok
                    </h1>
                </div>
                <div class="grid grid-cols-3 gap-6">
                    <div class="h-48 border-2 border-gray-400 bg-white rounded-lg"></div>
                    <div class="h-48 border-2 border-gray-400 bg-white rounded-lg"></div>
                    <div class="h-48 border-2 border-gray-400 bg-white rounded-lg"></div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

</script>
