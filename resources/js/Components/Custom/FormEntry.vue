<script setup>
import FormError from '@/Components/Custom/FormError.vue'

const props = defineProps({
    modelValue: [String, Number, Boolean],
    label: String,
    error: String,
})
</script>

<template>
    <div class="col-span-6 sm:col-span-12">
        <div class="flex flex-row gap-2">
            <label
                v-if="props.label"
                class="form-label inline-block mb-2 text-gray-700"
                v-html="props.label"
            />
            <slot/>
        </div>

        <FormError
            v-if="props.error"
            :error="props.error"
        />
    </div>
</template>

<style scoped>

</style>
