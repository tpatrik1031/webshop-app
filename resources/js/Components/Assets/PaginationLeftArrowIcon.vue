<script setup>
defineProps({
    height: Number,
    width: Number,
})
</script>

<template>
    <svg :width="width" :height="height" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M17.1133 15L11.4997 10L17.1133 5" stroke="#8986E9" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round"/>
        <path d="M10.5 15L4.88644 10L10.5 5" stroke="#3A36DB" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round"/>
    </svg>

</template>
