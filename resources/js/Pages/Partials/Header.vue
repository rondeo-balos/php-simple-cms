<script setup>
import Close from '@/Icons/Close.vue';
import Hamburger from '@/Icons/Hamburger.vue';
import { usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const show = ref(false);

const active = ref(usePage().props.active);
const setActive = function( route ) {
    return active.value === route;
};
const routes = [
    {
        route: route( 'home' ),
        label: 'Welcome',
        kicker: '// there\'s no place like 127.0.0.1',
        active: setActive( 'home' )
    },
    {
        route: route( 'projects' ),
        label: 'Projects',
        kicker: '// my best works',
        active: setActive( 'projects' )
    },
    {
        route: route( 'blog' ),
        label: 'Blog',
        kicker: '// latest updates',
        active: setActive( 'blog' )
    }
];
</script>

<style>
.kanit {
    font-family: 'Kanit', sans-serif;
}
.main-content {
    background-repeat: no-repeat;
    background-position: center top;
    background-size: 30%;
}
</style>

<template>
    <!-- Header -->
    <div class="border-b border-gray-600 border-opacity-25">
        <div class="max-w-screen-xl px-2 py-4 mx-auto flex flex-row justify-between items-center gap-10">
            <img src="https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/optimized/logo-transparent.webp" class=" max-h-12" width="auto" height="auto" alt="Logo">
            <nav class="flex-grow">
                <ul class="max-sm:hidden flex flex-row gap-10 uppercase font-black lg:justify-center">
                    <li v-for="item in routes" class="relative group">
                        <Link :href="item.route" :class="[(item.active ? 'text-white':''), 'h-full text-slate-400 group-hover:text-white transition-all']">{{ item.label }}</Link>
                        <div :class="[(item.active ? 'bg-blue-500' : 'bg-gray-300 opacity-0 group-hover:opacity-100'), 'h-1 w-full rounded-lg absolute -bottom-[31px] transition-all']"></div>
                    </li>
                </ul>
            </nav>
            <Link href="#contact" class="max-sm:hidden bg-[#3289f0] hover:bg-[#22c4f5] transition-colors px-4 py-2 font-bold text-white rounded-lg">Contact</Link>
            <button type="button" role="button" title="Show Nav Menu" @click="show = true" class="sm:hidden rounded-2xl bg-[#232d3d] text-white p-2 mx-2"><Hamburger class="min-w-6 min-h-6"/></button>
        </div>
    </div>

    <template>
        <Teleport to="body">
            <Transition leave-active-class="duration-200">
                <div v-show="show" class="fixed inset-0 overflow-y-auto z-50" scroll-region>
                    <Transition enter-active-class="ease-out duration-300"
                        enter-from-class="translate-x-[100vw]"
                        enter-to-class="translate-x-0"
                        leave-active-class="ease-in duration-200"
                        leave-from-class="translate-x-0"
                        leave-to-class="translate-x-[100vw]">
                        <div v-show="show" class="overflow-hidden transform transition-all w-full fixed top-0 h-full bg-black p-5 flex flex-col justify-between">
                            <button type="button" role="button" title="close Nav Menu" @click="show = false" class="rounded-2xl bg-[#232d3d] text-white p-2 self-end"><Close class="min-w-6 min-h-6"/></button>

                            <nav class="self-center">
                                <ul class="flex flex-col gap-10 font-black text-center">
                                    <li v-for="item in routes" class="relative group">
                                        <Link :href="item.route" :class="[(item.active ? 'text-blue-600':'text-white'), 'font-black text-3xl transition-all']">{{ item.label }}</Link>
                                        <span class="text-sm text-slate-600 block">{{ item.kicker }}</span>
                                    </li>
                                    <li class="relative group">
                                        <a href="#contact" @click="show = false" class="text-white font-black text-3xl transition-all">Contact</a>
                                        <span class="text-sm text-slate-600 block">// Call me maybe?</span>
                                    </li>
                                </ul>
                            </nav>

                            <div></div>
                        </div>
                    </Transition>
                </div>
            </Transition>
        </Teleport>
    </template>
</template>