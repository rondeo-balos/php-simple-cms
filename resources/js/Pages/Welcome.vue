<script setup>
import { Head, usePage, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { BookOpenIcon, ClockIcon, ArrowTopRightOnSquareIcon, ArrowLongDownIcon } from '@heroicons/vue/16/solid';
import Header from '@/Pages/Partials/Header.vue';
import Footer from '@/Pages/Partials/Footer.vue';
import Button from '@/Pages/Partials/Button.vue';
import CTA from '@/Pages/Partials/CTA.vue';
import Video from '@/Pages/Partials/Video.vue';
import PrimaryText from '@/Pages/Partials/PrimaryText.vue';
import axios from 'axios';
import Service from '@/Pages/Partials/Service.vue';
import { dragScroll } from './Partials/DragScroll';
import { useLayeredEffect } from '@/Pages/Partials/Layered';

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
        project: 'Cool Rate',
        description: 'Financial and operational management system tailored for a service or installation-based company. The system focuses on tracking labor costs, expenses, and calculating the company’s financial "burden" or cost of operations.',
        link: 'https://cool-rate.com',
        image: `${cdn.value}cool-rate.mockup-dark.webp`,
        framework: 'Laravel, Vue',
        status: 'On-going'
    },
    {
        project: 'Simpl.CMS',
        description: 'A simple CMS that provides features such as database models, file management, a dashboard, block components, authentication, translations, caching and many more.',
        link: 'https://cms.rondeobalos.com/',
        image: `${cdn.value}simpl.cms.mockup-dark.webp`,
        framework: 'Laravel, Vue',
        status: 'On-going'
    }
]);

// Fetch all projects
/*axios.get( route('api.collection', { collection: 'project', 's': 'sticky'}) )
    .then( response => {
        projects.value = response.data.data;
    })
    .catch( error => {
        console.log(error);
    });*/

// Scroll drag
const scrollContainer = ref(null);
const _dragScroll = dragScroll(scrollContainer);

// Layered transform
const containerRef = ref(null);
const imgRef = ref(null);
const txtRef = ref(null);
const { handleMouseMove, resetTransform } = useLayeredEffect(containerRef, imgRef, txtRef);


const scrollTo = ( id ) => {
    document.getElementById( id ).scrollIntoView({ behavior: 'smooth' });
};
</script>

<template>
    <Head title="Web Developer Portfolio - Rondeo Balos">
        <link rel="canonical" href="https://rondeobalos.com/">
        <meta name="description" content="Hello, I'm Rondeo Balos, a Web Developer. Each website project is unique with its own set of challenges. I treat each one with respect and dedication.">
        <meta name="robots" content="index">
        <meta property="og:image" :content="`${cdn}backend-dev.png`">
        <meta property="twitter:image" :content="`${cdn}backend-dev.png`">
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
    <div class="text-gray-200 main-content relative bg-[#151924]">
        <div class="fixed top-0 left-0 w-full h-screen body-bg"></div>

        <Header />

        <!-- Main content -->
        <div class="relative backdrop-blur-lg overflow-x-hidden">
            <!-- Max Screen -->
            <div class="max-w-screen-xl px-4 py-10 mx-auto">

                <div class="flex flex-col md:flex-row justify-between my-5 md:my-20">
                    <h2 class="text-4xl sm:text-7xl font-bold text-gray-200 mb-6">
                        <PrimaryText>Welcome!</PrimaryText> <br>
                        I'm Rondeo Balos
                    </h2>
                    <div class="md:w-5/12">
                        <p class="text-slate-400 text-lg mb-3">I’m a web developer passionate about creating visually appealing, high-performance websites. I combine modern design with solid development to build digital experiences that help businesses grow. Let’s bring your project to life!</p>
                        <CTA @click="scrollTo('contactEl')" is="button">Let's Talk</CTA>
                    </div>
                </div>

                <!--<h1 class="kanit uppercase text-4xl sm:text-6xl lg:text-8xl lg:-mb-3 xl:-me-5 font-black flex flex-col lg:flex-row justify-between items-center text-[#293448]">
                    <span class="text-lg text-[#2f8af3] normal-case">// Hi! <i class="not-italic text-white">my name is</i></span>
                    Rondeo Balos
                </h1>-->
                <Video :cdn="cdn" />

                <ArrowLongDownIcon class="w-10 h-10 p-2 border rounded-full animate-bounce mx-auto mb-10 -mt-10" />
            </div>
            
            <div class="mx-auto max-w-5xl px-2 mb-20">
                <div class="mx-auto max-w-2xl mb-10 text-center">
                    <h2 class="text-2xl sm:text-5xl font-bold text-gray-200 mb-3"><PrimaryText>Featured</PrimaryText> Projects</h2>
                    <p class="text-slate-400 mb-10 text-lg">Each website project is unique with its own set of challenges. I treat each one with the same approach, respect and dedication. I believe in transparency and honesty. This underlines everything I do.</p>
                </div>

                <div v-for="project in projects" class="bg-[#232c3d] relative rounded-xl shadow-xl mb-3 mt-16 flex even:md:flex-row-reverse odd:md:flex-row flex-col-reverse items-center group">
                    <div class="p-10 md:p-16 z-10 flex flex-col justify-center items-start">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-200 mb-3">{{ project.project }}</h3>
                        <p class="text-slate-400 mb-10">{{ project.description }}</p>
                        
                        <Button v-if="project.link" :href="project.link" target="_blank" class="bg-[#333f5b] inline ms-0 me-auto mb-3">Visit Site <ArrowTopRightOnSquareIcon class="h-5 inline -mt-1" /></Button>

                        <div>
                            <span class="text-sm font-bold text-blue-300 inline me-3"><BookOpenIcon class="size-5 -mt-1 inline" /> {{ project.framework }}</span>
                            <span class="text-sm font-bold text-blue-300 inline"><ClockIcon class="size-5 -mt-1 inline" /> {{ project.status }}</span>
                        </div>
                    </div>

                    <img :src="project.image" :alt="project.project" width="auto" height="auto" class="max-h-[400px] relative max-md:max-h-full -top-10 max-md:-mb-16 group-even:md:-left-10 group-odd:md:-right-10 group-even:md:-mr-10 group-odd:md:-ml-10 md:opacity-100 z-0 group-hover:scale-105 transition-transform duration-1000">
                </div>

                <div class="flex">
                    <CTA class="mt-10 px-8 mx-auto relative flex items-center" :href="route('projects')" is="a">View all my projects</CTA>
                </div>
            </div>

            <div class="mb-10">
                <div class="max-w-screen-xl px-2 mx-auto flex flex-col md:flex-row justify-between items-center text-center md:text-start">
                    <h2 class="text-4xl sm:text-7xl font-bold text-gray-200 mb-6">
                        <PrimaryText>What</PrimaryText> <span class="inline-block md:block"></span>
                        I excel at
                    </h2>
                    <p class="text-slate-400 mb-5 text-lg">I create custom websites that are visually appealing and easy to use, <span class="inline-block md:block"></span> helping businesses connect with their audience and grow online.</p>
                </div>

                <div class="grid grid-flow-col auto-cols-max items-center gap-5 lg:gap-10 pb-20 overflow-x-scroll lg:overflow-x-hidden cursor-grab p-2 px-2 xl:px-32" 
                    @mousedown="_dragScroll.startDrag" @mousemove="_dragScroll.onDrag" @mouseup="_dragScroll.endDrag" @mouseleave="_dragScroll.endDrag"
                    ref="scrollContainer">
                    <Service :srcBase="`${cdn}web-design-bg.png`" :srcText="`${cdn}web-design-txt.png`" :srcObj="`${cdn}web-design-obj2.png`" class="row-span-2" alt="Web Design" />
                    <Service :srcBase="`${cdn}backend-dev-bg.png`" :srcText="`${cdn}backend-dev-txt.png`" :srcObj="`${cdn}backend-dev-obj.png`" class="w-[380px]" alt="Backend Development" />
                    <Service :srcBase="`${cdn}branding-bg.png`" :srcText="`${cdn}branding-txt.png`" :srcObj="`${cdn}branding-obj.png`" class="w-[380px]" alt="Branding" />
                    <Service :srcBase="`${cdn}landing-page-b.png`" :srcText="`${cdn}landing-page-txt.png`" :srcObj="`${cdn}landing-page-obj.png`" class="row-span-2" alt="Landing Page" />
                    <Service :srcBase="`${cdn}e-commerce-bg.png`" :srcText="`${cdn}e-commerce-txt.png`" :srcObj="`${cdn}e-commerce-obj.png`" class="w-[380px] overflow-hidden" alt="E-commerce" />
                    <Service :srcBase="`${cdn}system-dev-bg.png`" :srcText="`${cdn}system-dev-txt.png`" :srcObj="`${cdn}system-dev-obj.png`" class="w-[380px]" alt="System Development" />

                    <div class="row-span-2 relative rounded-lg overflow-hidden bg-black p-5 md:p-20 text-center h-full flex flex-col justify-center" @mousemove="handleMouseMove" @mouseleave="resetTransform" ref="containerRef">
                        <img :src="`${cdn}logo-bordered-transparent-fade.webp`" class="opacity-35 w-72 absolute left-1/2 -ml-36" ref="imgRef" alt="Logo Bordered">
                        <div ref="txtRef">
                            <h3 class="text-3xl sm:text-5xl text-gray-200 mb-1">And even more...</h3>
                            <p class="text-slate-400 mb-5">Services tailored to your specific needs</p>
                            <CTA @click.prevent="scrollTo('contactEl')" is="button" class="mx-auto">Get Started</CTA>
                        </div>
                    </div>

                </div>
            </div>
            
            <div class="max-w-screen-xl px-2 py-10 mx-auto">
                
                <div class="mx-auto max-w-2xl">
                    <h2 class="text-2xl sm:text-5xl font-bold text-gray-200 text-center mb-3"><PrimaryText>Technologies</PrimaryText> and Tools I use</h2>
                    <p class="text-center text-slate-400 mb-10 text-lg">I take pride in showcasing my comprehensive knowledge and expertise in web development, utilizing a wide range of modern tools and technologies to deliver high-quality solutions.</p>
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

                <div class="flex flex-wrap mx-auto max-w-7xl justify-center transition-all relative">
                    <TransitionGroup name="list">
                        <template v-for="tech in techs" :key="tech.name">
                            <div v-if="currentType == tech.type || currentType == false" class="md:min-w-52 p-2">
                                <div class="bg-[#232c3d] p-4 font-bold rounded-xl flex flex-row items-center gap-3">
                                    <img :src="tech.image" class="w-8 h-8 sm:w-12 sm:h-12 object-contain object-center" :alt="tech.name" width="auto" height="auto">
                                    {{ tech.name }}
                                </div>
                            </div>
                        </template>
                    </TransitionGroup>

                </div>

            </div>
            <!--/ Max Screen /-->

            <Footer />

        </div>
    </div>

</template>

<style scoped>
.list-move, /* apply transition to moving elements */
.list-enter-active,
.list-leave-active {
    transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
}

.list-leave-active {
    position: absolute;
}

.body-bg {
    z-index: 0;
    background: url(https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/optimized/neon-bg.webp);
    background-position: center;
    background-size: contain;
    animation: spinner 500s linear infinite;
    opacity: 0.3;
}
@keyframes spinner {
  to { transform: rotate(360deg); }
}

.dragging {
    cursor: grabbing;
    user-select: none; /* Prevent text selection while dragging */
}
</style>