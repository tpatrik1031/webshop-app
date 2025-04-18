<template>
    <AuthenticatedLayout>
        <DialogModal :show="orderToCreate !== false" @close="orderToCreate = false" class="p-4">
            <template #title>
                <div class="pb-2 lg:py-3 border-b border-[#3A36DB]">
                    {{form.id ? 'Rendelés szerkesztése' : ''}}
                </div>
            </template>
            <template #content>
                <div class="pt-4 px-4 flex flex-col gap-3 max-h-[50vh] overflow-y-auto">
                    <InputLabel>Státusz</InputLabel>
                    <select
                        v-model="form.status"
                        class="w-full pb-4 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': errors.status }"
                    >
                        <option value="" disabled selected>Válassz státuszt...</option>
                        <option value="pending">Függőben</option>
                        <option value="processing">Küldés</option>
                        <option value="completed">Megérkezett</option>
                        <option value="cancelled">Elutasítva</option>
                    </select>
                    <div v-if="errors.status" class="text-red-500 text-sm">{{ errors.status }}</div>
                </div>
            </template>
            <template #footer>
                <div class="flex flex-grow flex-row justify-between front">
                    <Button @click="orderToCreate = false" variant="secondary">Mégse</Button>
                    <Button @click="saveOrder()" variant="primary">Mentés</Button>
                </div>
            </template>
        </DialogModal>

        <DialogModal :show="orderToDelete !== false">
            <template #title>Eltávolítás</template>
            <template #content>
                <div class="flex flex-col gap-4">
                    Biztos vagy benne, hogy törölni szeretnéd?
                </div>
            </template>
            <template #footer>
                <div class="flex flex-grow flex-row justify-between front">
                    <Button @click="toggleDeleteModal()" variant="secondary">Mégse</Button>
                    <Button @click="deleteOrder()" variant="error">Törlés</Button>
                </div>
            </template>
        </DialogModal>

        <div class="flex flex-col md:flex-row items-center justify-center w-full">
            <div class="flex flex-col md:flex-row p-8 pb-0 justify-between w-full">
                <div class="flex flex-col pb-6 md:pb-0">
                    <h1 class="text-2xl font-bold">Rendelések kezelése</h1>
                    <h2 class="text-gray-500">Itt kezelheted a rendelések</h2>
                </div>
                <div class="flex flex-col md:flex-row justify-between gap-6">
                </div>
            </div>
        </div>

        <div class="w-full h-full flex flex-col items-center justify-center p-8">
            <Table
                :resource="orders"
                :has-expanded-row="true"
                name="orders"
                preserve-scroll="table-top"
                @rowClicked="handleRowClick"
                class="w-full"
            >
            <template #cell(id)="{ item }">
                    <div class="flex justify-start pl-3">
                        {{ item.id }}
                    </div>
                </template>

                <template #expandedRow="{ item }">
                    <div class="flex flex-col md:flex-row justify-between px-8">
                        <div class="md:hidden">
                            <h1 class="font-bold text-base pb-2 text-cyan-500">Múveletek</h1>
                            <div class="flex gap-4 my-4">
                                <div @click="toggleDeleteModal(item.id)" class="cursor-pointer">
                                    <TrashIcon :width="22" :height="22"/>
                                </div>
                                <div @click="toggleCreateModal(item)" class="cursor-pointer">
                                    <EditIcon :width="22" :height="22" />
                                </div>
                                <div>
                                    <InfoIcon :width="22" :height="22"/>
                                </div>
                            </div>
                        </div>
                        <div class="my-2 md:ml-8 md:my-0 max-w-md">
                            <h1 class="font-bold text-base pb-2">Leírás</h1>
                            <p class="text-gray-700">{{ item.description }}</p>
                        </div>
                        <div class="hidden md:flex flex-row justify-center items-center gap-6">
                            <div class="mr-8">
                                <Button
                                    @click="toggleCreateModal(item)"
                                    class="w-full justify-center text-center gap-2 !px-6"
                                >
                                    <EditIcon :height="16" color="white" class="font-thin"/>
                                    <span>Szerkesztés</span>
                                </Button>
                            </div>
                        </div>
                    </div>
                </template>

                <template #header(actions)>
                    <div class="hidden md:flex justify-end w-full mr-[23px] text-cyan-500">
                        Múveletek
                    </div>
                </template>

                <template #cell(actions)="{ item }">
                    <div class="hidden md:flex justify-end gap-5 md:ml-12">
                        <div @click="toggleDeleteModal(item.id)" class="cursor-pointer">
                            <TrashIcon :width="22" :height="22"/>
                        </div>
                        <div @click="toggleCreateModal(item)" class="cursor-pointer">
                            <EditIcon :width="22" :height="22" />
                        </div>
                        <div>
                            <InfoIcon :width="22" :height="22"/>
                        </div>
                    </div>
                </template>

                <template #header(arrow)>
                    <div class="flex justify-end">
                    </div>
                </template>

                <template #cell(arrow)="{ item }">
                    <div class="flex justify-end pr-4">
                        <ArrowUpIconVue :width="22" :height="22" v-if="expandedRowId === item.id && expandedRow != null"/>
                        <ArrowDownIcon :width="22" :height="22" v-else/>
                    </div>
                </template>
            </Table>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {ref} from "vue";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {trans} from "laravel-vue-i18n";
import Button from "@/Components/Button.vue";
import {Table} from "@/Components/CustomTable/main.js";
import AddItemIcon from "@/Components/Assets/AddItemIcon.vue";
import {router} from "@inertiajs/vue3";
import DialogModal from "@/Components/DialogModal.vue";
import TrashIcon from '@/Components/Assets/TrashIcon.vue';
import EditIcon from '@/Components/Assets/EditIcon.vue';
import InfoIcon from '@/Components/Assets/InfoIcon.vue';
import ArrowDownIcon from '@/Components/Assets/ArrowDownIcon.vue';
import ArrowUpIconVue from '@/Components/Assets/ArrowUpIcon.vue';
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import FormTextArea from '@/Components/Custom/FormTextArea.vue';
import FormError from '@/Components/Custom/FormError.vue';

const props = defineProps({
    orders: Object,
    errors: Object
})

const expandedRow = ref(null);
const expandedRowId = ref(null);

function handleRowClick(value, itemId) {
    expandedRow.value = value;
    expandedRowId.value = itemId;
}

const orderToCreate = ref(false)
const form = ref({
    status: '',
});

const toggleCreateModal = (order = false) => {
    if (order) {
        form.value = { ...order };
    }
    orderToCreate.value = true;
};

const saveOrder = () => {
    if (form.value.id) {
        router.put(route('orders.update', { order: form.value.id }), form.value, {
            onSuccess: () => {
                orderToCreate.value = false;
            }
        });
    }
};


const orderToDelete = ref(false)
const toggleDeleteModal = (id = false) => {
    orderToDelete.value = id;
}

const deleteOrder = () => {
    router.delete(route('orders.delete', { order: orderToDelete.value }), {
        onSuccess: () => {
            orderToDelete.value = false;
        }
    });
};
</script>
