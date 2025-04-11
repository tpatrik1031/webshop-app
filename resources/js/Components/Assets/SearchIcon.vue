<script setup>
defineProps({
    height: Number,
    width: Number,
    color: {
        type: String,
        default: '#3A36DB'
    }
})
</script>

<template>
    <svg :width="width" :height="height" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M9.5236 16.1905C13.2055 16.1905 16.1903 13.2057 16.1903 9.52384C16.1903 5.84195 13.2055 2.85718 9.5236 2.85718C5.8417 2.85718 2.85693 5.84195 2.85693 9.52384C2.85693 13.2057 5.8417 16.1905 9.5236 16.1905Z" stroke="#384455" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M17.8574 17.8571L14.2324 14.2321" stroke="#384455" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</template>
    