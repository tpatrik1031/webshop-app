<script setup>
defineProps({
    height: Number,
    width: Number,
})
</script>

<template>
    <svg :width="width" :height="height" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M6.77246 13L12.386 7L6.77246 1" stroke="#8986E9" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round"/>
        <path d="M13.3867 13L19.0003 7L13.3867 1" stroke="#3A36DB" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round"/>
    </svg>
</template>
