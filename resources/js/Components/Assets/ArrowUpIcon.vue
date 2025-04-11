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
        <path d="M13 5.1803L7 0.819766L1 5.1803" stroke="#6A7380" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>

</template>
