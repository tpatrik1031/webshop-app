<template>
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Szállítási cím</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col gap-3">
                <InputLabel>Vezetéknév</InputLabel>
                <TextInput
                    v-model="form.last_name"
                    class="w-full"
                    placeholder="Vezetéknév..."
                    :errors="errors.last_name"
                />
            </div>

            <div class="flex flex-col gap-3">
                <InputLabel>Keresztnév</InputLabel>
                <TextInput
                    v-model="form.first_name"
                    class="w-full"
                    placeholder="Keresztnév..."
                    :errors="errors.first_name"
                />
            </div>

            <div class="flex flex-col gap-3">
                <InputLabel>Telefonszám</InputLabel>
                <TextInput
                    v-model="form.phone"
                    class="w-full"
                    placeholder="Telefonszám..."
                    :errors="errors.phone"
                />
            </div>

            <div class="flex flex-col gap-3">
                <InputLabel>Ország</InputLabel>
                <TextInput
                    v-model="form.country"
                    class="w-full"
                    placeholder="Ország..."
                    :errors="errors.country"
                />
            </div>

            <div class="flex flex-col gap-3">
                <InputLabel>Irányítószám</InputLabel>
                <TextInput
                    v-model="form.zip"
                    class="w-full"
                    placeholder="Irányítószám..."
                    :errors="errors.zip"
                />
            </div>

            <div class="flex flex-col gap-3">
                <InputLabel>Város</InputLabel>
                <TextInput
                    v-model="form.city"
                    class="w-full"
                    placeholder="Város..."
                    :errors="errors.city"
                />
            </div>

            <div class="flex flex-col gap-3 md:col-span-2">
                <InputLabel>Cím</InputLabel>
                <TextInput
                    v-model="form.address"
                    class="w-full"
                    placeholder="Utca, házszám, emelet, ajtó..."
                    :errors="errors.address"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    addressData: Object,
    errors: Object
});

const emit = defineEmits(['update:address']);

const form = ref({
    first_name: props.addressData?.first_name || '',
    last_name: props.addressData?.last_name || '',
    phone: props.addressData?.phone || '',
    country: props.addressData?.country || '',
    zip: props.addressData?.zip || '',
    city: props.addressData?.city || '',
    address: props.addressData?.address || ''
});

const watchForm = () => {
    emit('update:address', form.value);
};

for (const key in form.value) {
    watch(() => form.value[key], watchForm);
}
</script>
