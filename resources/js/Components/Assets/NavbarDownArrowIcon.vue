<script setup>
defineProps({
    height: Number,
    width: Number,
    color: {
        type: String,
        default: '#384455'
    }
})
</script>

<template>
    <svg :width="width" :height="height" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M3 4.5L6 7.5L9 4.5" :fill="color"/>
        <path d="M3 4.5L6 7.5L9 4.5" :stroke="color" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</template>