<template>
    <nav
        v-if="hasPagination"
        class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
    >
        <p v-if="!hasData || pagination.total < 1">
            Nincs megjeleníthető adat.
        </p>

        <!-- simple and mobile -->
        <div
            v-if="hasData"
            class="flex-1 flex justify-between"
            :class="{'sm:hidden': hasLinks}"
        >
            <component
                :is="previousPageUrl ? 'a' : 'div'"
                :class="{'cursor-not-allowed opacity-60': !previousPageUrl}"
                :href="previousPageUrl"
                :dusk="previousPageUrl ? 'pagination-previous' : null"
                class="relative inline-flex items-center px-2 py-2 text-sm font-medium gap-2"
                @click.prevent="onClick(previousPageUrl)"
            >
                <PaginationLeftArrowIcon :width="24"/>
            </component>
            <!--      <PerPageSelector-->
            <!--        dusk="per-page-mobile"-->
            <!--        :value="perPage"-->
            <!--        :options="perPageOptions"-->
            <!--        :on-change="onPerPageChange"-->
            <!--        :color="color"-->
            <!--      />-->
            <component
                :is="nextPageUrl ? 'a' : 'div'"
                :class="{'cursor-not-allowed opacity-60': !nextPageUrl}"
                :href="nextPageUrl"
                :dusk="nextPageUrl ? 'pagination-next' : null"
                class="relative inline-flex items-center px-2 py-2 text-sm font-medium gap-2"
                @click.prevent="onClick(nextPageUrl)"
            >
                <PaginationRightArrowIcon :width="24"/>
            </component>
        </div>

        <!-- full pagination -->
        <div
            v-if="hasData && hasLinks"
            class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"
        >
            <div class="flex flex-row space-x-4 items-center">
                <!--        <PerPageSelector-->
                <!--          dusk="per-page-full"-->
                <!--          :value="perPage"-->
                <!--          :options="perPageOptions"-->
                <!--          :on-change="onPerPageChange"-->
                <!--          :color="color"-->
                <!--        />-->


            </div>
            <div class="flex flex-grow flex-row">
                <nav
                    class="flex flex-row justify-between w-full px-12"
                    aria-label="Pagination"
                >
                    <component
                        :is="previousPageUrl ? 'a' : 'div'"
                        :class="{'cursor-not-allowed text-gray-400': !previousPageUrl}"
                        :href="previousPageUrl"
                        :dusk="previousPageUrl ? 'pagination-previous' : null"
                        class="relative inline-flex items-center px-2 py-2 text-sm font-medium gap-2"
                        @click.prevent="onClick(previousPageUrl)"
                    >
                        <PaginationLeftArrowIcon :width="20"/>
                        <span>Elöző</span>
                    </component>

                    <div class="flex flex-row gap-8">
                        <div
                            v-for="(link, key) in pagination.links"
                            :key="key"
                        >
                            <slot name="link">
                                <component
                                    :is="link.url ? 'a' : 'div'"
                                    v-if="!isNaN(link.label) || link.label === '...'"
                                    :href="link.url"
                                    :dusk="link.url ? `pagination-${link.label}` : null"
                                    class="relative inline-flex items-center px-4 py-2 text font-bold text-gray-400"
                                    :class="{
                                        'cursor-not-allowed': !link.url,
                                        '!text-blue-500': link.active,
                                    }"
                                    @click.prevent="onClick(link.url)"
                                >
                                    {{ link.label }}
                                </component>
                            </slot>
                        </div>
                    </div>

                    <component
                        :is="nextPageUrl ? 'a' : 'div'"
                        :class="{'cursor-not-allowed text-gray-400': !nextPageUrl}"
                        :href="nextPageUrl"
                        :dusk="nextPageUrl ? 'pagination-next' : null"
                        class="relative inline-flex items-center px-2 py-2 text-sm font-medium gap-2"
                        @click.prevent="onClick(nextPageUrl)"
                    >
                        <span>Következő</span>
                        <PaginationRightArrowIcon :width="20"/>
                    </component>
                </nav>
            </div>
        </div>
    </nav>
</template>

<script setup>
import {computed} from "vue";
import {getTranslations} from "../translations.js";
import PaginationLeftArrowIcon from "@/Components/Assets/PaginationLeftArrowIcon.vue";
import PaginationRightArrowIcon from "@/Components/Assets/PaginationRightArrowIcon.vue";
import {trans} from "laravel-vue-i18n";

const translations = getTranslations();

const props = defineProps({
    onClick: {
        type: Function,
        required: false,
    },
    perPageOptions: {
        type: Array,
        default() {
            return () => [15, 30, 50, 100];
        },
        required: false
    },
    onPerPageChange: {
        type: Function,
        default() {
            return () => {
            };
        },
        required: false,
    },
    hasData: {
        type: Boolean,
        required: true,
    },
    meta: {
        type: Object,
        required: false,
    },
    color: {
        type: String,
        default: 'primary',
        required: false,
    },
});

const hasLinks = computed(() => {
    if (!("links" in pagination.value)) {
        return false;
    }

    return pagination.value.links.length > 0;
});

const hasPagination = computed(() => {
    return Object.keys(pagination.value).length > 0;
});

const pagination = computed(() => {
    return props.meta;
});

const previousPageUrl = computed(() => {
    if ("prev_page_url" in pagination.value) {
        return pagination.value.prev_page_url;
    }

    return null;
});

const nextPageUrl = computed(() => {
    if ("next_page_url" in pagination.value) {
        return pagination.value.next_page_url;
    }

    return null;
});

const perPage = computed(() => {
    return parseInt(pagination.value.per_page);
});
</script>
