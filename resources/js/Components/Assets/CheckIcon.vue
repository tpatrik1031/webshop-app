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
    <svg :width="width" :height="height" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M1.5 4.54648L5.12265 8.33341L11.5 1.66681" :stroke="color" stroke-width="1.7" stroke-linecap="round"
              stroke-linejoin="round"/>
    </svg>

</template>

<style scoped>

</style>
