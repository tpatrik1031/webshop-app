<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-cyan-500 text-sm font-medium leading-5 text-sky-800 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out font-bold'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-sky-950 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out font-bold',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
