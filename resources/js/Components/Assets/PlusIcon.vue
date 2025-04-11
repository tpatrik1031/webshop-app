<script setup>
defineProps({
    height: Number,
    width: Number,
})
</script>

<template>
    <svg :width="width" :height="height" viewBox="0 0 100 99" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g filter="url(#filter0_i_842_6169)">
            <path d="M95.5 50.5573H4.5" stroke="#3A36DB" stroke-width="8" stroke-linecap="round"/>
            <path d="M48.9414 4L48.9414 95" stroke="#3A36DB" stroke-width="8" stroke-linecap="round"/>
        </g>
        <defs>
            <filter id="filter0_i_842_6169" x="0.5" y="0" width="99" height="99" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                <feOffset/>
                <feGaussianBlur stdDeviation="1.4"/>
                <feComposite in2="hardAlpha" operator="arithmetic" k2="-1" k3="1"/>
                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.4 0"/>
                <feBlend mode="normal" in2="shape" result="effect1_innerShadow_842_6169"/>
            </filter>
        </defs>
    </svg>

</template>

<style scoped>

</style>
