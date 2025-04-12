<template>
    <AuthenticatedLayout>
        <DialogModal :show="userToCreate !== false" @close="userToCreate = false" class="p-4">
            <template #title>
                <div class="pb-2 lg:py-3 border-b border-[#3A36DB]">
                    {{form.id ? 'Felhasználó szerkesztése' : ''}}
                </div>
            </template>
            <template #content>
                <div class="pt-4 px-4 flex flex-col gap-3 max-h-[50vh] overflow-y-auto">
                    <label class="inline-flex items-center justify-center space-x-2">
                        <input
                        type="checkbox"
                        v-model="form.is_admin"
                        class="form-checkbox h-5 w-5 text-cyan-500 m-2"
                        />
                        <span class="text-gray-700">Admin jogosultság</span>
                    </label>

                    <div v-if="errors.is_admin" class="text-red-500 text-sm">
                        {{ errors.is_admin }}
                    </div>
                </div>
            </template>
            <template #footer>
                <div class="flex flex-grow flex-row justify-between front">
                    <Button @click="userToCreate = false" variant="secondary">Mégse</Button>
                    <Button @click="saveUser()" variant="primary">Mentés</Button>
                </div>
            </template>
        </DialogModal>

        <DialogModal :show="userToDelete !== false">
            <template #title>Eltávolítás</template>
            <template #content>
                <div class="flex flex-col gap-4">
                    Biztos vagy benne, hogy törölni szeretnéd?
                </div>
            </template>
            <template #footer>
                <div class="flex flex-grow flex-row justify-between front">
                    <Button @click="toggleDeleteModal()" variant="secondary">Mégse</Button>
                    <Button @click="deleteUser()" variant="error">Törlés</Button>
                </div>
            </template>
        </DialogModal>

        <div class="flex flex-col md:flex-row items-center justify-center w-full">
            <div class="flex flex-col md:flex-row p-8 pb-0 justify-between w-full">
                <div class="flex flex-col pb-6 md:pb-0">
                    <h1 class="text-2xl font-bold">Felhasználók kezelése</h1>
                    <h2 class="text-gray-500">Itt kezelheted a felhasználókat</h2>
                </div>
                <div class="flex flex-col md:flex-row justify-between gap-6">
                    <div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full flex flex-col items-center justify-center p-8">
            <Table
                :resource="users"
                :has-expanded-row="true"
                name="users"
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
                            <h1 class="font-bold text-base pb-2">Múveletek</h1>
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
                            <h1 class="font-bold text-base pb-2">Teljes név</h1>
                            <p class="text-gray-700">{{ item.first_name }} {{ item.last_name }}</p>
                        </div>
                        <div class="my-2 md:ml-8 md:my-0 max-w-md">
                            <h1 class="font-bold text-base pb-2">Telefonszám</h1>
                            <p class="text-gray-700">{{ item.phone }}</p>
                        </div>
                        <div class="my-2 md:ml-8 md:my-0 max-w-md">
                            <h1 class="font-bold text-base pb-2">Létrehozva</h1>
                            <p class="text-gray-700">{{ item.created_at }}</p>
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
                    <div class="hidden md:flex justify-end w-full mr-[23px] text-[#3A36DB]">
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
    users: Object,
    errors: Object
})

const expandedRow = ref(null);
const expandedRowId = ref(null);

function handleRowClick(value, itemId) {
    expandedRow.value = value;
    expandedRowId.value = itemId;
}

const userToCreate = ref(false)
const form = ref({
    is_admin: '',
});

const toggleCreateModal = (user = false) => {
    if (user) {
        form.value = { ...user };
    }
    userToCreate.value = true;
};

const saveUser = () => {
    if (form.value.id) {
        router.put(route('users.update', { user: form.value.id }), form.value, {
            onSuccess: () => {
                userToCreate.value = false;
            }
        });
    }
};


const userToDelete = ref(false)
const toggleDeleteModal = (id = false) => {
    userToDelete.value = id;
}

const deleteUser = () => {
    router.delete(route('users.delete', { user: userToDelete.value }), {
        onSuccess: () => {
            userToDelete.value = false;
        }
    });
};
</script>
