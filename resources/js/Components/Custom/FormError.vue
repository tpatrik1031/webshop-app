<script setup>
import { trans } from 'laravel-vue-i18n'
const props = defineProps({
    error: String,
})
</script>

<template>
    <div v-if="props.error" class="text-red-500">
        {{props.error}}
    </div>
</template>

<style scoped></style>
