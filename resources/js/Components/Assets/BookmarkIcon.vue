<script setup>
defineProps({
    height: Number,
    width: Number,
})
</script>

<template>
    <svg :width="width" :height="height" viewBox="0 0 17 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M13.0663 0.653809H3.73153C1.67979 0.653809 0 2.33352 0 4.38517V18.0148C0 19.7545 1.24784 20.4984 2.77165 19.6466L7.48705 17.019C7.99098 16.7431 8.80688 16.7431 9.29882 17.019L14.0142 19.6466C15.55 20.4864 16.7979 19.7545 16.7979 18.0148V4.38517C16.7979 2.33352 15.1181 0.653809 13.0663 0.653809Z"
            fill="#3A36DB"/>
    </svg>
</template>

<style scoped>

</style>
