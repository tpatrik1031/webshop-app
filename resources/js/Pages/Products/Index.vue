<template>
    <AuthenticatedLayout>
        <DialogModal :show="productCategoryToCreate !== false" @close="productCategoryToCreate = false" class="p-4">
            <template #title>
                <div class="pb-2 lg:py-3 border-b border-[#3A36DB]">
                    Termék Kategória kezelése
                </div>
            </template>
            <template #content>
                <div>
                    <select
                        v-model="selectedCategoryId"
                        @change="loadCategoryDetails(selectedCategoryId)"
                        class="w-full pb-4 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="" disabled selected>Válassz kategóriát...</option>
                        <option v-for="category in productCategories" key:category.id :value="category.id">{{ category.name }}</option>
                    </select>
                </div>
                <div class="pt-4 px-4 flex flex-col gap-3 max-h-[50vh] overflow-y-auto">
                    <InputLabel>Típus</InputLabel>
                    <select
                        v-model="formCategory.type"
                        class="w-full pb-4 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': errors.type }"
                    >
                        <option value="" disabled selected>Válassz típust...</option>
                        <option value="food">Étel</option>
                        <option value="toy">Játék</option>
                        <option value="accessories">Kiegészítő</option>
                    </select>
                    <InputLabel>Név</InputLabel>
                    <TextInput
                        v-model="formCategory.name"
                        class="w-full pb-4"
                        placeholder="Név..."
                        :errors="errors.name"
                    />
                </div>
            </template>
            <template #footer>
                <div class="flex flex-grow flex-row justify-between front">
                    <Button @click="productCategoryToCreate = false" variant="secondary">Mégse</Button>
                    <Button v-if="formCategory.id" @click="deleteCategory()" variant="error">Törlés</Button>
                    <Button @click="saveCategory()" variant="primary">Mentés</Button>
                </div>
            </template>
        </DialogModal>
        <DialogModal :show="productToCreate !== false" @close="productToCreate = false" class="p-4">
            <template #title>
                <div class="pb-2 lg:py-3 border-b border-[#3A36DB]">
                    {{form.id ? 'Termék szerkesztése' : 'Termék létrehozása'}}
                </div>
            </template>
            <template #content>
                <div class="pt-4 px-4 flex flex-col gap-3 max-h-[50vh] overflow-y-auto">
                    <InputLabel>Név</InputLabel>
                    <TextInput
                        v-model="form.title"
                        class="w-full pb-4"
                        placeholder="Név..."
                        :errors="errors.title"
                    />
                    <InputLabel>Ár</InputLabel>
                    <FormNumberInput
                        v-model="form.price"
                        class="w-full pb-4"
                        placeholder="Ár..."
                        :errors="errors.price"
                    />
                    <InputLabel>Típus</InputLabel>
                    <select
                        v-model="form.type"
                        class="w-full pb-4 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': errors.type }"
                    >
                        <option value="" disabled selected>Válassz típust...</option>
                        <option value="food">Étel</option>
                        <option value="toy">Játék</option>
                        <option value="accessories">Kiegészítő</option>
                    </select>
                    <div v-if="errors.type" class="text-red-500 text-sm">{{ errors.status }}</div>
                    <div class="pb-4">
                        <InputLabel>Leírás</InputLabel>
                        <FormTextArea
                            v-model="form.description"
                            placeholder="Leírás..."
                            :classes="{
                                        'rounded-b-lg h-32 mt-3': true,
                                        'border-red-500': errors.description
                                    }"
                        />
                        <FormError
                            v-if="errors.description"
                            :error="errors.description"
                        />
                    </div>
                    <InputLabel>Kép</InputLabel>
                    <input
                        type="file"
                        @change="handleFileChange"
                        class="pb-4"
                    />
                </div>
            </template>
            <template #footer>
                <div class="flex flex-grow flex-row justify-between front">
                    <Button @click="productToCreate = false" variant="secondary">Mégse</Button>
                    <Button @click="saveProduct()" variant="primary">Mentés</Button>
                </div>
            </template>
        </DialogModal>

        <DialogModal :show="productToDelete !== false">
            <template #title>Eltávolítás</template>
            <template #content>
                <div class="flex flex-col gap-4">
                    Biztos vagy benne, hogy törölni szeretnéd?
                </div>
            </template>
            <template #footer>
                <div class="flex flex-grow flex-row justify-between front">
                    <Button @click="toggleDeleteModal()" variant="secondary">Mégse</Button>
                    <Button @click="deleteProduct()" variant="error">Törlés</Button>
                </div>
            </template>
        </DialogModal>

        <div class="flex flex-col md:flex-row items-center justify-center w-full">
            <div class="flex flex-col md:flex-row p-8 pb-0 justify-between w-full">
                <div class="flex flex-col pb-6 md:pb-0">
                    <h1 class="text-2xl font-bold">Termékek kezelése</h1>
                    <h2 class="text-gray-500">Itt kezelheted a termékeidet</h2>
                </div>
                <div class="flex flex-col md:flex-row justify-between gap-6">
                    <div>
                        <Button
                            @click="toggleCreateModalCategory()"
                            class="w-full justify-center text-center gap-2 !px-6"
                        >
                            <span>Kategória</span>
                            <AddItemIcon :height="16" color="white"/>
                        </Button>
                    </div>
                    <div>
                        <Button
                            @click="toggleCreateModal()"
                            class="w-full justify-center text-center gap-2 !px-6"
                        >
                            <span>Új hozzáadása</span>
                            <AddItemIcon :height="16" color="white"/>
                        </Button>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full flex flex-col items-center justify-center p-8">
            <Table
                :resource="products"
                :has-expanded-row="true"
                name="products"
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
                            <h1 class="font-bold text-base pb-2">{{ trans('quickActions') }}</h1>
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
                        <div class="my-2 md:ml-8 md:my-0 max-w-md">
                            <h1 class="font-bold text-base pb-2">Rögzítette</h1>
                            <p class="text-gray-700">{{ item.created_by.user_name }}</p>
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
import {ref,onMounted,watch  } from "vue";
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
import FormNumberInput from '@/Components/Custom/FormNumberInput.vue';
import FormError from '@/Components/Custom/FormError.vue';
import axios from 'axios'

const props = defineProps({
    products: Object,
    errors: Object
})

const productCategories = ref([]);
const selectedCategoryId = ref('');

onMounted(async () => {
  const response = await axios.get('/product-categories/list')
  productCategories.value = response.data.productCategories
})

watch(selectedCategoryId, async (newId) => {
  if (newId) {
    try {
      const response = await axios.post(`/product-categories/${newId}`)
      formCategory.value.id = response.data.id
      formCategory.value.name = response.data.name
      formCategory.value.type = response.data.type
    } catch (error) {
      console.error('Hiba a kategória lekérésekor:', error)
    }
  } else {
    formCategory.value.name = ''
    formCategory.value.type = ''
  }
})

const expandedRow = ref(null);
const expandedRowId = ref(null);

function handleRowClick(value, itemId) {
    expandedRow.value = value;
    expandedRowId.value = itemId;
}

const productCategoryToCreate = ref(false)
const formCategory = ref({
    id: null,
    name: '',
    type: '',
});

const productToCreate = ref(false)
const form = ref({
    title: '',
    price: '',
    description: '',
    type: '',
    image: null,
});

const handleFileChange = (event) => {
    form.value.image = event.target.files[0];
};

const toggleCreateModalCategory = (category = false) => {
    if (category) {
        selectedCategoryId.value = category.id;
        formCategory.value = { ...category };
    } else {
        selectedCategoryId.value = '';
        formCategory.value = { name: '', type: '' };
    }
    productCategoryToCreate.value = true;
};

const toggleCreateModal = (product = false) => {
    if (product) {
        form.value = { ...product };
    } else {
        form.value = { title: '', price: '', description: '', };
    }
    productToCreate.value = true;
};

const saveProduct = () => {
    const formData = new FormData();
    formData.append('title', form.value.title);
    formData.append('price', form.value.price);
    formData.append('type', form.value.type);
    formData.append('description', form.value.description);

    if (form.value.image) {
        formData.append('image', form.value.image);
    }

    if (form.value.id) {
        formData.append('_method', 'PUT');
        router.post(route('products.update', { product: form.value.id }), formData, {
            onSuccess: () => {
                productToCreate.value = false;
            },
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

    } else {
        router.post(route('products.store'), formData, {
            onSuccess: () => {
                productToCreate.value = false;
            },
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
    }
};

const saveCategory = () => {
console.log(formCategory.value.id);
    if (formCategory.value.id) {
        router.put(route('product-categories.edit', { id: formCategory.value.id }), formCategory.value, {
            onSuccess: () => {
                productCategoryToCreate.value = false;
            }
        });
    } else {
        router.post(route('product-categories.store'), formCategory.value, {
            onSuccess: () => {
                productCategoryToCreate.value = false;
            }
        });
    }
};

const productToDelete = ref(false)
const toggleDeleteModal = (id = false) => {
    productToDelete.value = id;
}

const deleteProduct = () => {
    router.delete(route('products.delete', { product: productToDelete.value }), {
        onSuccess: () => {
            productToDelete.value = false;
        }
    });
};
const deleteCategory = () => {
   router.delete(route('product-categories.delete', { productCategory: formCategory.value.id }));
};
</script>
