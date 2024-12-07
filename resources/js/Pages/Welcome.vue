<script setup>
import { Head, usePage, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { BookOpenIcon, ClockIcon, ArrowTopRightOnSquareIcon, ArrowLongDownIcon, UserIcon } from '@heroicons/vue/16/solid';
import Header from '@/Pages/Partials/Header.vue';
import Footer from '@/Pages/Partials/Footer.vue';
import Button from '@/Pages/Partials/Button.vue';
import CTA from '@/Pages/Partials/CTA.vue';
import PrimaryText from '@/Pages/Partials/PrimaryText.vue';
import Service from '@/Pages/Partials/Service.vue';
import { dragScroll } from '@/Pages/Partials/DragScroll';
import { useLayeredEffect } from '@/Pages/Partials/Layered';
import Testimonials from '@/Pages/Partials/Testimonials.vue';
import { useAutoAnimate } from '@formkit/auto-animate/vue'
import VideoAlt from '@/Pages/Partials/VideoAlt.vue';

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
        link_label: 'Visit Site',
        image: `${cdn.value}cool-rate.mockup.webp`,
        framework: [
            'Laravel',
            'Vue',
            'TailwindCSS'
        ],
        status: 'Post-deployment',
        role: 'Back-end'
    },
    {
        project: 'Simpl.CMS',
        description: 'A simple CMS that provides features such as database models, file management, a dashboard, block components, authentication, translations, caching and many more.',
        link: 'https://github.com/rondeo-balos/php-simple-cms',
        link_label: 'Github',
        image: `${cdn.value}simpl.cms.mockup.webp`,
        framework: [
            'Laravel',
            'Vue',
            'TailwindCSS',
            'Twig'
        ],
        status: 'On-going',
        role: 'Full-stack'
    }
]);

const testimonials = ref([
    [
        {
            testimonial: 'I had the privilege of collaborating with an extraordinary web developer who blew me away. His exceptional skills and meticulousness left me thoroughly impressed. From concept to completion, their work showcased an unparalleled level of professionalism and attention to detail. I wholeheartedly recommend this web developer for anyone seeking an extraordinary online presence.',
            name: 'Dan Erwin Magno',
            image: 'https://lh3.googleusercontent.com/a-/ALV-UjVG_oUuI1zfJQc9rpEunqhH5sukkulBscz0afRsL6gY-giArh8=s36-c-rp-mo-br100'
        },
    ],
    [
        {
            testimonial: 'I highly recommend Rondeo for any web development projects. His technical skills are exceptional, and his consistently deliver high-quality work on time. If you\'re looking for a reliable and talented web developer, Rondeo is the perfect choice!',
            name: 'Rosenie Talibo',
            image: 'https://lh3.googleusercontent.com/a-/ALV-UjX42y0xzd5ivtdxA_WfDeZYpLKj_6xCe6SSurRVtBjF-YonXLAW=s36-c-rp-mo-br100'
        }
    ],
    [
        {
            testimonial: 'I highly recommend Rondeo for any web development project you have in mind. His skills, professionalism, and dedication are unmatched, making him a true asset to anyone looking to create an outstanding online presence. Thank you, Rondeo, for an exceptional job well done!',
            name: 'Vincent Oric',
            image: 'https://lh3.googleusercontent.com/a-/AD_cMMTrMp9OYCUjC42OPxvN2MFf298-rcGwRVfUSE3GvNnDXC4=w60-h60-p-rp-mo-br100'
        },
    ],
    [
        {
            testimonial: 'You can say this guy is always doing a job well done projects that he handled. I can recommend, you can hire this guy to do web development related stuffs.',
            name: 'jhunel geronimo',
            image: 'https://lh3.googleusercontent.com/a/ACg8ocKVh2bY6V0p-KU-7gB1f5imzDNylvCTclLRfjYQzQP0fO4HSA=s36-c-rp-mo-br100'
        }
    ],
    [
        {
            testimonial: 'He is incredibly knowledgeable and easy to work with, making the entire website creation process smooth and stress-free. They took the time to understand my business needs and provided creative, personalized solutions that truly captured my brand’s essence. The end result was a beautifully designed, user-friendly website that exceeded my expectations! Highly recommend Rondeo Balos for anyone looking for professional, innovative web solutions!',
            name: 'Ric Ian Abing',
            image: 'https://lh3.googleusercontent.com/a-/ALV-UjUD_0nWaLEcOp-Ffo2KEDDvOmTMqiuWGPDohu8SvWoFo2Qw9jY=s36-c-rp-mo-br100'
        }
    ]
]);

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

const [autoAnimate] = useAutoAnimate()
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

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    </Head>
    <div class="text-gray-200 main-content relative bg-[#151924]">
        <div class="fixed top-0 left-0 w-full h-screen body-bg"></div>

        <Header />

        <!-- Main content -->
        <div class="relative backdrop-blur-lg overflow-x-hidden">
            <!-- Max Screen -->
            <div class="max-w-screen-xl px-4 py-10 mx-auto" id="home">

                <div class="mb-36 flex flex-col-reverse lg:flex-row gap-10">
                    <div class="grow shrink flex flex-col gap-10 basis-1/2 justify-center">
                        <div>
                            <h1 class="text-4xl sm:text-5xl font-bold text-gray-200 mb-4 merienda">
                                <PrimaryText>Welcome!</PrimaryText> <br>
                                I'm Rondeo Balos
                            </h1>
                            <p class="text-slate-400 text-lg mb-4">I’m a web developer passionate about creating visually appealing, high-performance websites. I combine modern design with solid development to build digital experiences that help businesses grow. Let’s bring your project to life!</p>
                            <div class="flex flex-col lg:flex-row gap-5">
                                <CTA @click="scrollTo('contactEl')" is="button">Let's Talk</CTA>
                                <VideoAlt :cdn="cdn" />
                            </div>
                        </div>
                    </div>
                    <div class="grow shrink flex flex-col gap-10 basis-1/2">
                        <img :src="`https://imgcdn.stablediffusionweb.com/2024/10/3/1567c0fe-396c-49e8-8da8-5ffb87414d3f.jpg`" class="rounded-3xl">  
                    </div>
                </div>

                <ArrowLongDownIcon class="w-10 h-10 p-2 border rounded-full animate-bounce mx-auto mb-10 -mt-10" />
            </div>

            <div class="mb-20" id="testimonials">
                <h2 class="text-2xl sm:text-4xl font-bold text-gray-200 mb-6 text-center px-3 merienda">You're not the first to discover...</h2>
                <Testimonials>
                    <template v-for="testimonal in testimonials">
                        <div class="flex flex-col gap-5">
                            <div v-for="testimonial in testimonal" class="bg-[#1e2430] rounded-xl p-6 max-w-xs sm:max-w-sm text-wrap hover:scale-105 transition-transform duration-500">
                                <p>{{ testimonial.testimonial.substring(0, 280) + ( testimonial.testimonial.length > 300 ? '...' : '' ) }}</p>
                                <div class="flex flex-row justify-between items-center mt-5">
                                    <span class="uppercase font-semibold text-[#86a7c0]">{{ testimonial.name }}</span>
                                    <img class="bg-white rounded-full overflow-hidden max-w-7" :alt="testimonial.name" :src="testimonial.image">
                                </div>
                            </div>
                        </div>
                    </template>
                </Testimonials>
            </div>
            
            <div class="mx-auto max-w-5xl px-2 mb-36" id="projects">
                <div class="mx-auto max-w-2xl mb-10 text-center">
                    <h2 class="text-2xl sm:text-5xl font-bold text-gray-200 mb-3 merienda"><PrimaryText>Featured</PrimaryText> Projects</h2>
                    <p class="text-slate-400 mb-10 text-lg">Each website project is unique with its own set of challenges. I treat each one with the same approach, respect and dedication. I believe in transparency and honesty. This underlines everything I do.</p>
                </div>

                <div v-for="project in projects" class="bg-[#232c3d] relative rounded-xl shadow-xl mb-3 mt-16 flex even:md:flex-row-reverse odd:md:flex-row flex-col-reverse items-center group">
                    <div class="p-10 md:p-16 z-10 flex flex-col justify-center items-start">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-200 mb-3 merienda">{{ project.project }}</h3>
                        <p class="text-slate-400">{{ project.description }}</p>
                        
                        <div class="text-sm font-bold text-blue-300 my-5">
                            <div class="flex flex-row mb-3 gap-1">
                                <span v-for="framework in project.framework" class="bg-[#151926] p-1 px-2 rounded-lg text-white text-sm">{{ framework }}</span>
                            </div>
                            <span class="inline me-3"><ClockIcon class="size-5 -mt-1 inline" /> {{ project.status }}</span>
                            <span class="inline"><UserIcon class="size-5 -mt-1 inline" /> {{ project.role }}</span>
                        </div>

                        <Button v-if="project.link" :href="project.link" target="_blank" class="bg-[#333f5b] inline ms-0 me-auto mb-3">{{ project.link_label }} <ArrowTopRightOnSquareIcon class="h-5 inline -mt-1" /></Button>
                    </div>

                    <img :src="project.image" :alt="project.project" width="auto" height="auto" class="max-h-[400px] relative max-md:max-h-full max-md:-mb-16 group-even:md:-left-16 group-odd:md:-right-16 group-even:md:-mr-24 group-odd:md:-ml-24 md:opacity-100 z-0 group-hover:scale-110 transition-transform duration-300">
                </div>

                <!--<div class="flex">
                    <CTA class="mt-10 px-8 mx-auto relative flex items-center justify-center" :href="route('projects')" is="a">View More</CTA>
                </div>-->
            </div>

            <div class="mb-10" id="services">
                <div class="max-w-screen-xl px-2 mx-auto flex flex-col md:flex-row justify-between items-center text-center md:text-start">
                    <h2 class="text-4xl sm:text-7xl font-bold text-gray-200 mb-6 merienda">
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
                        <div ref="txtRef" class="relative">
                            <h3 class="text-3xl sm:text-5xl text-gray-200 mb-1">And even more...</h3>
                            <p class="text-slate-400 mb-5">Services tailored to your specific needs</p>
                            <CTA @click.prevent="scrollTo('contactEl')" is="button" class="mx-auto z-50">Get Started</CTA>
                        </div>
                    </div>

                </div>
            </div>
            
            <div class="max-w-screen-xl px-2 py-10 mx-auto">
                
                <div class="mx-auto max-w-2xl">
                    <h2 class="text-2xl sm:text-5xl font-bold text-gray-200 text-center mb-3 merienda"><PrimaryText>Technologies</PrimaryText> and Tools I use</h2>
                    <p class="text-center text-slate-400 mb-10 text-lg">I take pride in showcasing my comprehensive knowledge and expertise in web development, utilizing a wide range of modern tools and technologies to deliver high-quality solutions.</p>
                    <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-800 mb-5">
                        <ul class="flex flex-row -mb-px justify-center overflow-x-auto">
                            <li v-for="(type, index) in types" class="sm:mx-2">
                                <a href="#" @click.prevent="currentType = type" :class="[(currentType === type ? 'text-blue-600 border-b-2 border-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300') ,'inline-block p-4 border-b-2 rounded-t-lg capitalize']">
                                    {{ index }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="flex flex-wrap mx-auto max-w-7xl justify-center transition-all relative gap-0" ref="autoAnimate">
                    <template v-for="tech in techs" :key="tech.name">
                        <div v-if="currentType == tech.type || currentType == false" class="md:min-w-52 p-1 sm:p-2 hover:scale-105 transition-transform duration-500">
                            <div class="bg-[#232c3d] p-3 sm:p-4 font-bold rounded-xl flex flex-row items-center gap-3 text-xs sm:text-base">
                                <img :src="tech.image" class="w-6 h-6 sm:w-12 sm:h-12 object-contain object-center" :alt="tech.name" width="auto" height="auto">
                                {{ tech.name }}
                            </div>
                        </div>
                    </template>
                </div>

            </div>
            <!--/ Max Screen /-->

            <!-- Blog section -->
            <div class="max-w-screen-xl px-2 py-4 mx-auto">
                <div class="bg-[#232c3d] rounded-3xl px-8 sm:px-12 py-20 sm:mb-5 relative overflow-hidden flex flex-col sm:flex-row gap-10 items-center justify-center">
                    <img src="https://placehold.co/400x400" />
                    <div class=" max-w-[500px]">
                        <h2 class="text-2xl sm:text-4xl font-bold text-gray-200 text-start mb-3 merienda">Dive Into My Creative Journey</h2>
                        <p class="text-slate-400 text-lg">Explore insights, tips, and stories that inspire and ignite your passion. Join me as we navigate the world of creativity together!</p>
                        
                        <div class="flex">
                            <CTA class="mt-10 px-8 relative flex items-center" :href="route('blog')" is="a">Check It Out!</CTA>
                        </div>
                    </div>
                </div>
            </div>

            <Footer />

        </div>
    </div>

</template>

<style scoped>

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

.merienda {
  font-family: "Merienda", cursive;
  font-optical-sizing: auto;
  font-style: normal;
}

p {
    font-family: "Roboto Condensed", sans-serif;
    font-optical-sizing: auto;
    font-weight: 300;
    font-style: normal;
}
</style>