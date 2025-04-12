<script setup>
defineProps({
    height: Number,
    width: Number,
})
</script>

<template>
    <svg :width="width" :height="height" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M3.4165 7.58341L7.58317 3.41675" stroke="#3A36DB" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M3.4165 3.41675H7.58317V7.58341" stroke="#3A36DB" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</template>