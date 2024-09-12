<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ThemeToggler from '@/Components/CustomComponents/ThemeToggler.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Speedometer from '@/Icons/Speedometer.vue';
import Document from '@/Icons/Document.vue';
import { Link } from '@inertiajs/vue3';
import Image from '@/Icons/Image.vue';
import People from '@/Icons/People.vue';
import Search from '@/Icons/Search.vue';
import Cog from '@/Icons/Cog.vue';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 backdrop-blur backdrop-opacity-10">
                <!-- Primary Navigation Menu -->
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"
                                    />
                                </Link>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <div class="ms-3 relative">
                                <ThemeToggler />
                            </div>
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ms-2 -me-0.5 h-4 w-4"
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
                                        <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 ms-auto flex items-center sm:hidden">
                            <ThemeToggler class=""/>
                        </div>
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
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

                <!-- Responsive Navigation Menu -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden" >

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="flex">
                <div class="sm:min-w-[300px]">
                    

                    <!-- Sidebar -->
                    <ul class="dark:text-white sm:px-7 sm:py-5 p-1 h-full max-sm:dark:bg-slate-950 max-sm:bg-slate-200">
                        <li>
                            <Link :href="route('dashboard')" class="flex flex-row gap-4 items-center rounded px-4 py-3 hover:dark:bg-slate-700 hover:bg-white transition-colors">
                                <Speedometer class="w-6" />
                                <span class="hidden sm:inline">Dashboard</span>
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('page')" class="flex flex-row gap-4 items-center rounded px-4 py-3 hover:dark:bg-slate-700 hover:bg-white transition-colors">
                                <Document class="w-6" />
                                <span class="hidden sm:inline">Pages</span>
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('media')" class="flex flex-row gap-4 items-center rounded px-4 py-3 hover:dark:bg-slate-700 hover:bg-white transition-colors">
                                <Image class="w-6" />
                                <span class="hidden sm:inline">Media</span>
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('user')" class="flex flex-row gap-4 items-center rounded px-4 py-3 hover:dark:bg-slate-700 hover:bg-white transition-colors">
                                <People class="w-6" />
                                <span class="hidden sm:inline">Users</span>
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('dashboard')" class="flex flex-row gap-4 items-center rounded px-4 py-3 hover:dark:bg-slate-700 hover:bg-white transition-colors">
                                <Search class="w-6" />
                                <span class="hidden sm:inline">SEO</span>
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('dashboard')" class="flex flex-row gap-4 items-center rounded px-4 py-3 hover:dark:bg-slate-700 hover:bg-white transition-colors">
                                <Cog class="w-6" />
                                <span class="hidden sm:inline">Settings</span>
                            </Link>
                        </li>
                    </ul>

                </div>
                <div class="flex-grow h-[calc(100vh-70px)] overflow-y-auto p-2">
                    <!-- Page Heading -->
                    <header v-if="$slots.header">
                        <div class="max-w-screen-2xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            <slot name="header" />
                        </div>
                    </header>

                    <!-- Page Content -->
                    <main class="max-w-screen-2xl mx-auto">
                        <slot />
                    </main>
                </div>
            </div>

            
        </div>
    </div>
</template>