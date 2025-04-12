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
    <svg :width="width" :height="height" viewBox="0 0 94 94" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M85.3638 23.4673C89.5727 30.3141 92 38.3736 92 47.0001C92 71.8529 71.8528 92.0001 47 92.0001C22.1472 92.0001 2 71.8529 2 47.0001C2 38.3736 4.42732 30.3141 8.63622 23.4673" stroke="#3A36DB" stroke-width="4" stroke-linecap="round"/>
        <path d="M75.197 11.9288C67.4818 5.71771 57.6745 2.00024 46.9989 2.00024C36.3233 2.00024 26.516 5.71771 18.8008 11.9288" :stroke="color" stroke-width="4" stroke-linecap="round"/>
    </svg>

</template>

<style scoped>

</style>
