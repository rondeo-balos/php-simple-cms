<script setup>
import Close from '@/Icons/Close.vue';
import Hamburger from '@/Icons/Hamburger.vue';
import { usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import CTA from '@/Pages/Partials/CTA.vue';

const cdn = ref(usePage().props.cdn);

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

const scrollTo = ( id ) => {
    document.getElementById( id ).scrollIntoView({ behavior: 'smooth' });
};
</script>

<template>
    <!-- Header -->
    <div class="border-b border-gray-600 border-opacity-25 nav backdrop-blur-lg sticky top-0 z-[55]">
        <div class="max-w-screen-xl px-2 py-4 mx-auto flex flex-row justify-between items-center gap-10">
            <img :src="`${cdn}logo-transparent.webp`" class=" max-h-12" width="auto" height="auto" alt="Logo">
            <nav class="flex-grow">
                <ul class="max-sm:hidden flex flex-row gap-10 uppercase font-black lg:justify-center">
                    <li v-for="item in routes" class="relative group">
                        <Link :href="item.route" :class="[(item.active ? 'text-white':''), 'block h-full text-slate-400 group-hover:text-white transition-all']">{{ item.label }}</Link>
                        <div :class="[(item.active ? 'bg-blue-500' : 'bg-gray-300 opacity-0 group-hover:opacity-100'), 'h-1 w-full rounded-lg absolute -bottom-[31px] transition-all']"></div>
                    </li>
                </ul>
            </nav>
            
            <CTA is="button" @click.prevent="scrollTo('contactEl')" class="max-sm:hidden min-h-12">Contact</CTA>
            <button type="button" role="button" title="Show Nav Menu" @click="show = !show" :class="[{'show' : show}, 'hamburger fixed right-0 shadow-xl sm:hidden rounded-full border bg-[#232d3d] text-white p-2 mx-2 w-10 h-10']">
                <span class="w-[20px] h-[3px] bg-white block absolute top-[35%] left-[25%]"></span>
                <span class="w-[20px] h-[3px] bg-white block absolute top-[55%]"></span>
            </button>
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
                            <!--<button type="button" role="button" title="close Nav Menu" @click="show = false" class="rounded-2xl bg-[#232d3d] text-white p-2 self-end"><Close class="min-w-6 min-h-6"/></button>-->

                            <nav class="self-center">
                                <ul class="flex flex-col gap-10 font-black text-center pt-36">
                                    <li v-for="item in routes" class="relative group">
                                        <Link :href="item.route" :class="[(item.active ? 'text-blue-600':'text-white'), 'font-black text-3xl transition-all']">{{ item.label }}</Link>
                                        <span class="text-sm text-slate-600 block">{{ item.kicker }}</span>
                                    </li>
                                    <li class="relative group">
                                        <a href="#contact" @click.prevent="show = false; scrollTo('contactEl');" class="text-white font-black text-3xl transition-all">Contact</a>
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

<style>
.kanit {
    font-family: 'Kanit', sans-serif;
}
.main-content {
    background-repeat: no-repeat;
    background-position: center top;
    background-size: 30%;
}
.nav:before {
    content: "";
    background-image: repeating-linear-gradient(45deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.1) 10px, transparent 10px, transparent 20px);
    width: 100%;
    height: 19px;
    margin: 0;
    padding: 0;
    display: block;
    position: absolute;
    top: 38%;
    left: 0;
    opacity: 25%;
}
.hamburger span {
    transition: 0.2s linear;
}
.hamburger.show span {
    left: 23%;
    top: 45%
}
.hamburger.show span:nth-of-type(1) {
    transform: rotate(-45deg);
}
.hamburger.show span:nth-of-type(2) {
    transform: rotate(45deg);
}
</style>