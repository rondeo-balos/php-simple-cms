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
import Service from '@/Pages/Partials/Service.vue';
import { dragScroll } from '@/Pages/Partials/DragScroll';
import { useLayeredEffect } from '@/Pages/Partials/Layered';
import Testimonials from '@/Pages/Partials/Testimonials.vue';

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

const testimonials = ref([
    [
        {
            testimonial: 'I had the privilege of collaborating with an extraordinary web developer who blew me away. His exceptional skills and meticulousness left me thoroughly impressed. From concept to completion, their work showcased an unparalleled level of professionalism and attention to detail. I wholeheartedly recommend this web developer for anyone seeking an extraordinary online presence.',
            name: 'Dan Erwin Magno',
            image: 'https://lh3.googleusercontent.com/a-/ALV-UjVG_oUuI1zfJQc9rpEunqhH5sukkulBscz0afRsL6gY-giArh8=s36-c-rp-mo-br100'
        },
        {
            testimonial: 'Working with this developer has been an absolute delight. They exceeded my expectations by delivering top-notch solutions in record time. The attention to detail and ability to anticipate needs was impressive. A true professional who goes above and beyond.',
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
        {
            testimonial: 'Their work was simply outstanding! The developer delivered beyond what was asked for and always kept communication clear and professional. I couldn’t be more pleased with the end result. Will definitely work with them again in the future!',
            name: 'Olivia Turner',
            image: 'https://lh3.googleusercontent.com/-cXXaVVq8nMM/AAAAAAAAAAI/AAAAAAAAAKI/_Y1WfBiSnRI/photo.jpg?sz=50'
        }
    ],
    [
        {
            testimonial: 'Fantastic experience from start to finish! The developer was extremely responsive and adapted quickly to changes in the project. Their work ethic and quality of the final product were top-tier. I would highly recommend them to anyone seeking web development expertise.',
            name: 'Michael Lee',
            image: 'https://lh3.googleusercontent.com/-cXXaVVq8nMM/AAAAAAAAAAI/AAAAAAAAAKI/_Y1WfBiSnRI/photo.jpg?sz=50'
        },
        {
            testimonial: 'The developer demonstrated an unparalleled level of professionalism and care throughout our collaboration. They handled everything from the design to the smallest details with finesse. I am thrilled with the final product.',
            name: 'Sarah Johnson',
            image: 'https://lh3.googleusercontent.com/-cXXaVVq8nMM/AAAAAAAAAAI/AAAAAAAAAKI/_Y1WfBiSnRI/photo.jpg?sz=50'
        }
    ],
    [
        {
            testimonial: 'I can’t say enough about the quality of this developer’s work. Not only did they deliver everything on time, but the project exceeded my expectations in every way. Their attention to detail and commitment to excellence are truly remarkable.',
            name: 'James Mitchell',
            image: 'https://lh3.googleusercontent.com/-cXXaVVq8nMM/AAAAAAAAAAI/AAAAAAAAAKI/_Y1WfBiSnRI/photo.jpg?sz=50'
        },
        {
            testimonial: 'This developer is a true gem! Their technical expertise and creative solutions were invaluable to my project. The finished product is absolutely flawless, and I couldn’t have asked for a better partner on this journey.',
            name: 'Amelia Carter',
            image: 'https://lh3.googleusercontent.com/-cXXaVVq8nMM/AAAAAAAAAAI/AAAAAAAAAKI/_Y1WfBiSnRI/photo.jpg?sz=50'
        }
    ],
    [
        {
            testimonial: 'I was blown away by the level of service and the results this developer provided. They delivered a high-quality solution that perfectly met my needs, and they were always quick to respond to feedback. I would recommend them to anyone.',
            name: 'Lucas Bennett',
            image: 'https://lh3.googleusercontent.com/-cXXaVVq8nMM/AAAAAAAAAAI/AAAAAAAAAKI/_Y1WfBiSnRI/photo.jpg?sz=50'
        },
        {
            testimonial: 'This developer took my vague ideas and turned them into a beautiful and functional website. Their communication and understanding of my needs were excellent, and they made sure every aspect was perfect.',
            name: 'Sophia Harris',
            image: 'https://lh3.googleusercontent.com/-cXXaVVq8nMM/AAAAAAAAAAI/AAAAAAAAAKI/_Y1WfBiSnRI/photo.jpg?sz=50'
        }
    ],
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
                    <h1 class="text-4xl sm:text-7xl font-bold text-gray-200 mb-6">
                        <PrimaryText>Welcome!</PrimaryText> <br>
                        I'm Rondeo Balos
                    </h1>
                    <div class="md:w-5/12">
                        <p class="text-slate-400 text-lg mb-3">I’m a web developer passionate about creating visually appealing, high-performance websites. I combine modern design with solid development to build digital experiences that help businesses grow. Let’s bring your project to life!</p>
                        <CTA @click="scrollTo('contactEl')" is="button">Let's Talk</CTA>
                    </div>
                </div>
                <Video :cdn="cdn" />

                <ArrowLongDownIcon class="w-10 h-10 p-2 border rounded-full animate-bounce mx-auto mb-10 -mt-10" />
            </div>

            <div class="mb-20">
                <h2 class="text-2xl sm:text-4xl font-bold text-gray-200 mb-6 text-center">You're not the first to discover...</h2>
                <Testimonials>
                    <template v-for="testimonal in testimonials">
                        <div class="flex flex-col gap-5">
                            <div v-for="testimonal in testimonal" class="bg-[#1e2430] rounded-xl p-6 max-w-52 sm:max-w-sm text-wrap hover:scale-105 transition-transform duration-500">
                                <p>{{ testimonal.testimonial }}</p>
                                <div class="flex flex-row justify-between items-center mt-5">
                                    <span class="uppercase font-semibold text-[#86a7c0]">{{ testimonal.name }}</span>
                                    <img class="bg-white rounded-full overflow-hidden max-w-7" :alt="testimonal.name" :src="testimonal.image">
                                </div>
                            </div>
                        </div>
                    </template>
                </Testimonials>
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
                    <h2 class="text-2xl sm:text-5xl font-bold text-gray-200 text-center mb-3"><PrimaryText>Technologies</PrimaryText> and Tools I use</h2>
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

                <div class="flex flex-wrap mx-auto max-w-7xl justify-center transition-all relative gap-0">
                    <TransitionGroup name="list">
                        <template v-for="tech in techs" :key="tech.name">
                            <div v-if="currentType == tech.type || currentType == false" class="md:min-w-52 p-1 sm:p-2 hover:scale-105 transition-transform duration-500">
                                <div class="bg-[#232c3d] p-3 sm:p-4 font-bold rounded-xl flex flex-row items-center gap-3 text-xs sm:text-base">
                                    <img :src="tech.image" class="w-6 h-6 sm:w-12 sm:h-12 object-contain object-center" :alt="tech.name" width="auto" height="auto">
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
.move-item, .list-enter-active, .list-leave-active {
    transition: all 0.6s ease-in-out;
    transform-style: preserve-3d;
}

.list-enter-from {
    transform: rotateY(90deg);  /* Start from a 90-degree rotation */
    opacity: 0;
}

.list-leave-to {
    transform: rotateY(90deg);  /* End with the same rotation */
    opacity: 0;
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