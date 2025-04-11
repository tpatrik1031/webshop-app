<script setup>
defineProps({
    height: Number,
    width: Number,
    color: {
        type: String,
        default: 'white'
    }
})
</script>

<template>
    <svg :width="width" :height="height" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M1 0.819702L7 5.18023L13 0.819702" stroke="#6A7380" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>

</template>
