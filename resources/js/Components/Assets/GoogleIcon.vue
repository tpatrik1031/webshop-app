<script setup>
defineProps({
    height: Number,
    width: Number,
})
</script>

<template>
    <svg :width="width" :height="height"  viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path opacity="0.7" d="M19.0625 10.2344C19.0625 15.7812 15.2734 19.6875 9.6875 19.6875C4.29688 19.6875 0 15.3906 0 10C0 4.64844 4.29688 0.3125 9.6875 0.3125C12.2656 0.3125 14.4922 1.28906 16.1719 2.85156L13.5156 5.39062C10.0781 2.07031 3.67188 4.57031 3.67188 10C3.67188 13.3984 6.36719 16.1328 9.6875 16.1328C13.5156 16.1328 14.9609 13.3984 15.1562 11.9531H9.6875V8.63281H18.9062C18.9844 9.14062 19.0625 9.60938 19.0625 10.2344Z" fill="url(#paint0_linear_33_116)"/>
        <defs>
            <linearGradient id="paint0_linear_33_116" x1="0" y1="-1.5" x2="21.1064" y2="-0.435454" gradientUnits="userSpaceOnUse">
                <stop stop-color="#3A36DB"/>
                <stop offset="1" stop-color="#7C4EF1"/>
            </linearGradient>
        </defs>
    </svg>

</template>

<style scoped>

</style>
