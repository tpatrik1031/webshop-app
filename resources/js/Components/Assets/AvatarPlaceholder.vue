<script setup>
defineProps({
    height: {
        type: Number,
        default: 96
    },
    width: {
        type: Number,
        default: 96
    },
})
</script>

<template>
    <svg :width="width" :height="height" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g clip-path="url(#clip0_269_1438)">
            <circle cx="50" cy="50" r="50" fill="#F3F7FD" />
            <path
                d="M49 66C36.9554 66 27.2857 56.6484 27.2857 45C27.2857 33.5156 36.9554 24 49 24C60.875 24 70.7143 33.5156 70.7143 45C70.7143 56.6484 60.875 66 49 66ZM57.4821 73.875C73.7679 73.875 87 86.6719 87 102.422C87 105.539 84.2857 108 81.0625 108H16.7679C13.5446 108 11 105.539 11 102.422C11 86.6719 24.0625 73.875 40.3482 73.875H57.4821Z"
                fill="#8986E9" />
        </g>
        <rect x="2" y="2" width="96" height="96" rx="48" stroke="#8986E9" stroke-width="4" />
        <defs>
            <clipPath id="clip0_269_1438">
                <rect width="100" height="100" rx="50" fill="white" />
            </clipPath>
        </defs>
    </svg>
</template>

<style scoped></style>
