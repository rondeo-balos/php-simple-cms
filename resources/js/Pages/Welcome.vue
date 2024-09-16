<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { BookOpenIcon, ClockIcon, ArrowTopRightOnSquareIcon } from '@heroicons/vue/16/solid';
import Header from '@/Pages/Partials/Header.vue';
import Footer from '@/Pages/Partials/Footer.vue';
import Button from '@/Pages/Partials/Button.vue';

const cdn = ref(usePage().props.cdn);

// Frameworks: Laravel, Vue, Tailwind CSS, React JS, Slim, Twig, LibGDX
// Languages: CSS, Javascript, PHP, Java, HTML
// Tooling: Git, MySQL, VS Code
const currentType = ref(false);
const types = ref({
    all: false,
    framework: 'framework',
    language: 'language',
    tool: 'tool',
    others: 'others'
});
const techs = ref({});
fetch(`${cdn.value}tech-tools.json`)
    .then(response => response.json())
    .then(data => techs.value = data);

const projects = ref([
    {
        title: 'Simpl.CMS',
        desc: 'A simple CMS that provides features such as database models, file management, a dashboard, block components, authentication, translations, caching and many more.',
        link: 'https://cms.rondeobalos.com/',
        image: `${cdn.value}simpl.cms.mockup-new.webp`
    },
    {
        title: 'Cool Rate',
        desc: 'Financial and operational management system tailored for a service or installation-based company. The system likely focuses on tracking labor costs, expenses, and calculating the company’s financial "burden" or cost of operations.',
        link: false,
        image: `${cdn.value}cool-rate.mockup-new.webp`
    }
]);
</script>

<template>
    <Head title="Web Developer Portfolio - Rondeo Balos">
        <link rel="canonical" href="https://rondeobalos.com/">
        <meta name="description" content="Hello, I'm Rondeo Balos, a Web Developer. Each website project is unique with its own set of challenges. I treat each one with respect and dedication.">
        <meta name="robots" content="index">
        <meta property="og:image" content="//rondeobalos.com/src/media/f80e13a2660d5c11.webp">
        <meta property="twitter:image" content="//rondeobalos.com/src/media/f80e13a2660d5c11.webp">
        <meta property="og:site_name" content="Rondeo Balos">
        <meta property="og:locale" content="en">
        <meta property="og:title" content="Web Developer Portfolio - Rondeo Balos">
        <meta property="og:description" content="Hello, I'm Rondeo Balos, a Web Developer. Each website project is unique with its own set of challenges. I treat each one with respect and dedication.">
        <meta property="og:url" content="/">
        <meta property="twitter:title" content="Web Developer Portfolio - Rondeo Balos">
        <meta property="twitter:description" content="Hello, I'm Rondeo Balos, a Web Developer. Each website project is unique with its own set of challenges. I treat each one with respect and dedication.">
        <meta property="og:type" content="website">
        <meta property="twitter:card" content="summary_large_image">
        <link rel="icon" :href="`${cdn}logo-transparent.webp`">
    </Head>
    <div class="bg-[#151924] text-gray-200 main-content">
        <Header />

        <!-- Main content -->
        <div>
            <div class="max-w-screen-xl px-2 py-20 mx-auto">

                <h1 class="kanit uppercase text-4xl sm:text-6xl lg:text-8xl lg:-mb-3 xl:-me-5 font-black flex flex-col lg:flex-row justify-between items-center text-[#293448]">
                    <span class="text-lg text-[#2f8af3] normal-case">// Hi! <i class="not-italic text-white">my name is</i></span>
                    Rondeo Balos
                </h1>
                <div class="w-full mb-20 relative shadow-2xl rounded-3xl overflow-hidden">
                    <video class="w-full h-auto" :poster="`${cdn}poster.gif`" autoplay muted loop>
                        <source src="https://dl.dropboxusercontent.com/scl/fi/sug74uaxpbkznc34s3hjh/showreelv4.mp4?rlkey=e897a5evp3ec2ih9reu6m0q92&st=pshuxy90&dl=0" type="video/mp4">
                    </video>
                    <!--<div class="absolute w-full h-full top-0 backdrop-grayscale backdrop-blur-sm z-10 flex flex-col justify-center items-center">
                        <h1 class="text-white drop-shadow text-9xl text-center font-black uppercase">Rondeo Balos' Web Dev Portfolio</h1>
                    </div>-->
                </div>

                <div class="mx-auto max-w-2xl mb-10 text-center">
                    <h2 class="text-2xl sm:text-4xl font-bold text-gray-200 mb-3">Featured Project</h2>
                    <p class="text-slate-400 mb-10">Each website project is unique with its own set of challenges. I treat each one with the same approach, respect and dedication. I believe in transparency and honesty. This underlines everything I do.</p>
                </div>

                
                <div class="mx-auto max-w-5xl mb-20">

                    <div v-for="project in projects" class="bg-[#232c3d] relative rounded-xl shadow-xl mb-2 flex even:flex-row-reverse odd:flex-row items-center overflow-hidden group">
                        <div class="p-10 md:p-16 z-10 flex flex-col justify-center items-start">
                            <h3 class="text-2xl sm:text-4xl font-bold text-gray-200 mb-3">{{ project.title }}</h3>
                            <p class="text-slate-400 mb-10">{{ project.desc }}</p>
                            
                            <a v-if="project.link" :href="project.link" class="bg-[#333f5b] hover:bg-[#475c87] transition-colors px-4 py-3 font-bold text-white rounded-lg mb-5">Visit Site <ArrowTopRightOnSquareIcon class="h-5 inline -mt-1" /></a>

                            <div>
                                <span class="text-sm font-bold text-blue-300 inline me-3"><BookOpenIcon class="size-5 -mt-1 inline" /> Laravel, Vue</span>
                                <span class="text-sm font-bold text-blue-300 inline"><ClockIcon class="size-5 -mt-1 inline" /> On-going</span>
                            </div>
                        </div>

                        <!--<img :src="project.image" :alt="project.title" width="auto" height="auto" class="max-h-[400px] grayscale group-hover:grayscale-0 group-even:max-md:-mr-96 group-odd:max-md:-ml-96 opacity-20 md:opacity-80 z-0 group-hover:scale-105 transition-transform duration-1000">-->
                        <img :src="project.image" :alt="project.title" width="auto" height="auto" class="max-h-[400px] max-md:max-h-full top-0 max-md:absolute group-even:left-0 group-odd:right-0 opacity-20 md:opacity-80 z-0 group-hover:scale-105 transition-transform duration-1000">
                    </div>

                    <Button :href="route('projects')" class="mt-10">View all my projects</Button>
                </div>
                
                <div class="mx-auto max-w-2xl">
                    <h2 class="text-2xl sm:text-4xl font-bold text-gray-200 text-center mb-3">Technologies and Tools I use</h2>
                    <p class="text-center text-slate-400 mb-10">I take pride in showcasing my comprehensive knowledge and expertise in web development, utilizing a wide range of modern tools and technologies to deliver high-quality solutions.</p>
                    <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-800 mb-5">
                        <ul class="flex flex-wrap -mb-px justify-center">
                            <li v-for="(type, index) in types" class="sm:mx-2">
                                <a href="#" @click.prevent="currentType = type" :class="[(currentType === type ? 'text-blue-600 border-b-2 border-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300') ,'inline-block p-4 border-b-2 rounded-t-lg capitalize']">
                                    {{ index }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="flex flex-wrap mx-auto max-w-5xl justify-center">
                    <template v-for="tech in techs">
                        <div v-if="currentType == tech.type || currentType == false" class="w-1/2
                         md:w-1/5 p-2">
                            <div class="bg-[#232c3d] p-4 font-bold rounded-xl flex flex-row items-center gap-3">
                                <img :src="tech.image" class="w-8 h-8 sm:w-12 sm:h-12 object-contain object-center" :alt="tech.name" width="auto" height="auto">
                                {{ tech.name }}
                            </div>
                        </div>
                    </template>
                </div>

            </div>
        </div>

        <Footer />
    </div>

</template>
