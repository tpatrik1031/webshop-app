<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3'
import Footer from '@/Components/Footer.vue';

const cartQuantity = usePage().props.cartQuantity;
const user = usePage().props.auth.user;
const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen flex flex-col bg-gray-100">
            <nav
                class="bg-gray-100"
            >
                <div class="px-4 sm:px-6 lg:px-12">
                    <div class="flex h-16 justify-between">
                        <div class="flex shrink-0 items-center">
                            <Link :href="route('home.index')">
                                <img
                                    src="/dog-paw-logo.png"
                                    alt=""
                                    class="h-16 w-16 object-cover rounded"
                                >
                                <h1 class="text-cyan-500 text-xl md:text-3xl font-extrabold mt-1 md:mt-0">
                                    TAPPANCS-SHOP
                                </h1>
                            </Link>
                        </div>

                        <div class="hidden sm:flex justify-center flex-1">
                            <div class="flex space-x-8">
                                <NavLink
                                    :href="route('home.index')"
                                    :active="route().current('home.index')"
                                >
                                    Kezdőlap
                                </NavLink>
                                <NavLink
                                    :href="route('shop.food')"
                                    :active="route().current('shop.food')"
                                >
                                    Étel
                                </NavLink>
                                <NavLink
                                    :href="route('shop.toy')"
                                    :active="route().current('shop.toy')"
                                >
                                    Játékok
                                </NavLink>
                                <NavLink
                                    :href="route('shop.accessories')"
                                    :active="route().current('shop.accessories')"
                                >
                                    Kiegészítők
                                </NavLink>
                                <NavLink
                                    :href="route('products.index')"
                                    :active="route().current('products.index')"
                                    v-if="user && user.is_admin === 1"
                                >
                                    Termékek
                                </NavLink>
                                <NavLink
                                    :href="route('orders.index')"
                                    :active="route().current('orders.index')"
                                    v-if="user && user.is_admin === 1"
                                >
                                    Rendelések
                                </NavLink>
                                <NavLink
                                    :href="route('users.index')"
                                    :active="route().current('users.index')"
                                    v-if="user && user.is_admin === 1"
                                >
                                    Felhasználók
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center">
                            <div class="relative cursor-pointer pr-6">
                                <Link :href="route('cart.index')">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-6 h-6 text-gray-700 hover:text-cyan-600 transition-colors duration-200">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                    </svg>

                                    <span v-if="cartQuantity > 0"
                                        class="absolute -bottom-2 left-4 bg-cyan-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full shadow-md">
                                        {{ cartQuantity }}
                                    </span>
                                </Link>
                            </div>

                            <div class="relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-full border border-transparent bg-cyan-500 px-4 py-2 text-sm font-medium leading-4 text-white transition duration-150 ease-in-out hover:bg-cyan-600 focus:outline-none"
                                            >
                                                {{ user.user_name }}

                                                <svg
                                                    class="-me-0.5 ms-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('account.addresses.index')"
                                        >
                                            Általános beállítások
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Biztonsági beállítások
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Kijelentkezés
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <div class="flex items-center sm:hidden">
                            <div class="relative cursor-pointer pr-6">
                                <Link :href="route('cart.index')">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-6 h-6 text-gray-700 hover:text-cyan-600 transition-colors duration-200">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                    </svg>

                                    <span v-if="cartQuantity > 0"
                                        class="absolute -bottom-2 left-4 bg-cyan-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full shadow-md">
                                        {{ cartQuantity }}
                                    </span>
                                </Link>
                            </div>
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none dark:text-gray-500 dark:hover:bg-gray-900 dark:hover:text-gray-400 dark:focus:bg-gray-900 dark:focus:text-gray-400"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink
                            :href="route('home.index')"
                            :active="route().current('home.index')"
                        >
                            Kezdőlap
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('shop.food')"
                            :active="route().current('shop.food')"
                        >
                            Étel
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('shop.toy')"
                            :active="route().current('shop.toy')"
                        >
                            Játékok
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('shop.accessories')"
                            :active="route().current('shop.accessories')"
                        >
                            Kiegészítők
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('users.index')"
                            :active="route().current('users.index')"
                            v-if="user && user.is_admin === 1"
                        >
                            Felhasználók
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('products.index')"
                            :active="route().current('products.index')"
                            v-if="user && user.is_admin === 1"
                        >
                            Termékek
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('orders.index')"
                            :active="route().current('orders.index')"
                            v-if="user && user.is_admin === 1"
                        >
                            Rendelések
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('account.addresses.index')"
                            :active="route().current('account.addresses.index')"
                        >
                            Általános beállítások
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('profile.edit')"
                            :active="route().current('profile.edit')"
                        >
                            Biztonsági beállítások
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('logout')"
                            method="post"
                            as="button"
                        >
                            Kijelentkezés
                        </ResponsiveNavLink>
                    </div>
                </div>
            </nav>

            <main class="flex-grow">
                <slot />
            </main>

            <Footer />
        </div>
    </div>
</template>
