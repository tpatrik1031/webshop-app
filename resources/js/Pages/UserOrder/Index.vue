<template>
    <AuthenticatedLayout>

        <Notification
            v-if="showNotification"
            :message="notificationMessage"
            :type="notificationType"
            @close="showNotification = false"
         />


    <div class="flex flex-col items-center justify-center w-full">
        <div class="flex flex-col md:flex-row p-8 pb-0 justify-between w-full">
            <div class="flex flex-col pb-6 md:pb-0">
                <h1 class="text-2xl font-bold">Rendelés leadása</h1>
                <h2 class="text-gray-500">Kérjük, add meg a rendelésed adatait</h2>
            </div>
        </div>

        <div class="w-full p-8">
            <form @submit.prevent="submitOrder">
                <OrderAddressForm
                    :address-data="addressData"
                    :errors="errors"
                    @update:address="updateAddress"
                />

                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4">Rendelési információk</h2>
                    <div v-for="item in cartItems" :key="item.id" class="flex justify-between py-1 font-bold">
                        <p>{{ item.title }}</p>
                        <p>{{ item.price }}</p>
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Összesen fizetendő:</h2>
                        <span class="text-2xl font-bold">{{ total }} Ft</span>
                    </div>

                    <div class="flex justify-end mt-6">
                        <Button
                            type="submit"
                            variant="primary"
                            class="justify-center text-center gap-2 !px-6"
                        >
                            Rendelés leadása
                        </Button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';
import OrderAddressForm from './components/OrderForm.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Notification from '@/Components/Notification.vue';

const props = defineProps({
    addressData: Object,
    errors: Object,
    cartItems: Array,
    total: Object
});

const showNotification = ref(false);
const notificationMessage = ref('');
const notificationType = ref('success');

const showSuccessMessage = (message) => {
  notificationMessage.value = message;
  notificationType.value = 'success';
  showNotification.value = true;
};

const showErrorMessage = (message) => {
  notificationMessage.value = message;
  notificationType.value = 'error';
  showNotification.value = true;
};

const orderData = ref({
    address: {
        first_name: props.addressData?.first_name || '',
        last_name: props.addressData?.last_name || '',
        phone: props.addressData?.phone || '',
        country: props.addressData?.country || '',
        zip: props.addressData?.zip || '',
        city: props.addressData?.city || '',
        address: props.addressData?.address || ''
    },
    payment_method: 'transaction',
    total: props.total || '',
});

const updateAddress = (address) => {
    orderData.value.address = address;
};

const submitOrder = () => {
    const formData = {
        ...orderData.value.address,
        payment_method: orderData.value.payment_method,
        total: orderData.value.total
    };

    router.post(route('orders.finish'), formData);
    showSuccessMessage('Sikeresen rögzítettük rendelését');
};
</script>
