<template>
    <component
        :is="href ? 'a' : 'button'"
        :href="href"
        type="button"
        class="inline-flex items-center rounded-lg border text-sm text-center font-medium text-slate-900 shadow-sm focus:outline-none"
        :class="[
            customClass,
            {
                'px-6 py-3': size === 'lg',
                'px-4 py-2': size === 'md',
                'px-2.5 py-1.5': size === 'sm',
                'text-white border-cyan-600 bg-cyan-500 hover:bg-blue-500 hover:border-blue-500': variant === 'primary',
                '!text-blue-500 border-blue-500 bg-white hover:bg-blue-500 hover:!text-white': variant === 'secondary',
                '!rounded-full !text-blue-500 border-blue-500 bg-white hover:bg-blue-500 hover:!text-white': variant === 'thirdly',
                '!rounded-full bg-white !text-[#3A36DB] hover:bg-[#F8F9FC] active:bg-[#F1F3F9]': variant === 'fourthly',
                '!rounded-full text-white border-blue-500 bg-blue-500 hover:bg-blue-500 hover:border-blue-500': variant === 'fifthly',
                'text-white border-red-500 bg-red-500 hover:bg-red-600 hover:border-red-600': variant === 'error',
                'bg-transparent hover:bg-transparent': outline,
            }
        ]"
    >
        <slot/>
    </component>
</template>

<script setup>
const props = defineProps({
    size: {
        type: String, // sm | md | lg
        default: 'md',
    },
    variant: {
        type: String, // primary | secondary | error
        default: 'primary',
    },
    outline: Boolean,
    href: {
        type: String,
        default: null,
    },
    customClass: {
        type: String,
        default: '',
    },
});
</script>
