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
    <svg :width="width" :height="height" viewBox="0 0 14 14" fill="white" xmlns="http://www.w3.org/2000/svg">
        <path d="M12.8332 1.75H1.1665L5.83317 7.26833V11.0833L8.1665 12.25V7.26833L12.8332 1.75Z" :stroke="color" stroke-linecap="round" stroke-linejoin="round" />
    </svg>    
</template>