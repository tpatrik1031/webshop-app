<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="block w-full px-4 py-2 text-start text-sm leading-5 text-white transition duration-150 ease-in-out hover:rounded-xl hover:bg-cyan-300 focus:bg-cyan-200 focus:outline-none"
    >
        <slot />
    </Link>
</template>
