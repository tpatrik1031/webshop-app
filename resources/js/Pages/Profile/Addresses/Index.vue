<template>
    <AuthenticatedLayout>

        <Notification
            v-if="showNotification"
            :message="notificationMessage"
            :type="notificationType"
            @close="showNotification = false"
         />

        <div class="flex flex-col md:flex-row items-center justify-center w-full">
            <div class="flex flex-col md:flex-row p-8 pb-0 justify-between w-full">
                <div class="flex flex-col pb-6 md:pb-0">
                    <h1 class="text-2xl font-bold">Címek kezelése</h1>
                    <h2 class="text-gray-500">Itt kezelheted a szállítási és számlázási címedet</h2>
                </div>
                <div class="flex flex-col md:flex-row justify-between gap-6">
                    <div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-between w-full p-8 gap-8 mt-8 mb-16">
            <div class="flex-col w-full border rounded-xl bg-white shadow-md">
                <div class="flex p-4">
                    <h1 class="text-xl md:text-2xl font-bold">Szállítási cím</h1>
                </div>
                <div class="pt-4 px-4 flex flex-col gap-3 max-h-[50vh]">
                    <InputLabel>Ország</InputLabel>
                    <TextInput
                        v-model="shippingForm.country"
                        class="w-full pb-4"
                        placeholder="Ország..."
                        :errors="errors.country"
                    />
                    <InputLabel>Irányítószám</InputLabel>
                    <TextInput
                        v-model="shippingForm.zip"
                        class="w-full pb-4"
                        placeholder="Irányítószám..."
                        :errors="errors.zip"
                    />
                    <InputLabel>Város</InputLabel>
                    <TextInput
                        v-model="shippingForm.city"
                        class="w-full pb-4"
                        placeholder="Város..."
                        :errors="errors.city"
                    />
                    <InputLabel>Cím</InputLabel>
                    <TextInput
                        v-model="shippingForm.address"
                        class="w-full pb-4"
                        placeholder="Cím..."
                        :errors="errors.address"
                    />
                    <div class="flex items-center space-x-2 mx-1 pt-3">
                        <input
                            id="same_address"
                            type="checkbox"
                            v-model="shippingForm.same_address"
                            class="form-checkbox h-5 w-5 text-cyan-500 rounded my-1"
                        />
                        <label for="same_address" class="text-sm select-none">
                            Ugyanaz, mint a számlázási cím
                        </label>
                    </div>
                </div>
                <div class="flex flex-grow flex-row justify-end front pt-6 px-6 mt-14">
                    <Button @click="saveShippingAddress" variant="primary">Mentés</Button>
                </div>
            </div>
            <div class="flex-col w-full border rounded-xl bg-white shadow-md">
                <div class="flex p-4">
                    <h1 class="text-xl md:text-2xl font-bold">Számlázási cím</h1>
                </div>
                <div class="pt-4 px-4 flex flex-col gap-3 max-h-[50vh]">
                    <InputLabel>Ország</InputLabel>
                    <TextInput
                        v-model="billingForm.country"
                        class="w-full pb-4"
                        placeholder="Ország..."
                        :errors="errors.country"
                    />
                    <InputLabel>Irányítószám</InputLabel>
                    <TextInput
                        v-model="billingForm.zip"
                        class="w-full pb-4"
                        placeholder="Irányítószám..."
                        :errors="errors.zip"
                    />
                    <InputLabel>Város</InputLabel>
                    <TextInput
                        v-model="billingForm.city"
                        class="w-full pb-4"
                        placeholder="Város..."
                        :errors="errors.city"
                    />
                    <InputLabel>Cím</InputLabel>
                    <TextInput
                        v-model="billingForm.address"
                        class="w-full pb-4"
                        placeholder="Cím..."
                        :errors="errors.address"
                    />
                </div>
                <div class="flex flex-grow flex-row justify-end front px-6 pt-20 pb-6">
                    <Button @click="saveBillingAddress" variant="primary">Mentés</Button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {ref,onMounted} from "vue";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Button from "@/Components/Button.vue";
import {router} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import FormTextArea from '@/Components/Custom/FormTextArea.vue';
import FormNumberInput from '@/Components/Custom/FormNumberInput.vue';
import FormError from '@/Components/Custom/FormError.vue';
import Notification from '@/Components/Notification.vue';

const props = defineProps({
    billingAddress: Object,
    shippingAddress: Object,
    errors: Object
})

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

const shippingForm = ref({
    country: '',
    zip: '',
    city: '',
    address: '',
    same_address: '',
});

const billingForm = ref({
    country: '',
    zip: '',
    city: '',
    address: '',
});

const saveShippingAddress = () => {
    router.post(route('account.shipping-addresses.save'), shippingForm.value, {
        onSuccess: () => {
            router.reload();
            showSuccessMessage('Sikeresen frissítette adatait');
        },
        onError: () => {
            showErrorMessage('Hiba történt a szállítási cím mentésekor');
        }
    });
};

const saveBillingAddress = () => {
    router.post(route('account.billing-addresses.save'), billingForm.value, {
        onSuccess: () => {
            router.reload();
            showSuccessMessage('Sikeresen frissítette adatait');
        },
        onError: () => {
            showErrorMessage('Hiba történt a számlázási cím mentésekor');
        }
    });
};

onMounted(() => {
    if (props.shippingAddress) {
        shippingForm.value = {
            ...shippingForm.value,
            ...props.shippingAddress,
            same_address: props.shippingAddress.same_address ?? false,
        };
    }

    if (props.billingAddress) {
        billingForm.value = {
            ...billingForm.value,
            ...props.billingAddress,
        };
    }
});
</script>
