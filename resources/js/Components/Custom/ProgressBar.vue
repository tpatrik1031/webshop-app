<script setup>
const props = defineProps({
    currentStep: Number,
    numberOfSteps: Number,
})
</script>

<template>
    <div class="w-full flex flex-row gap-2 items-center">
        <!-- Progress Bar Container -->
        <div class="relative w-full h-3 bg-gray-200 rounded-full">
            <!-- Gradient Progress Bar -->
            <div
                class="absolute h-full transition-all duration-300 rounded-full"
                :style="{
          width: (currentStep / numberOfSteps) * 100 + '%',
          background: 'linear-gradient(45deg, #3a36db, #7c4ef1)'
        }"
            ></div>
        </div>
        <!-- Step Count -->
        <div class="text-blue-500 font-semibold">
            <span>{{ currentStep }}</span>
            <span>/</span>
            <span>{{ numberOfSteps }}</span>
        </div>
    </div>
</template>
