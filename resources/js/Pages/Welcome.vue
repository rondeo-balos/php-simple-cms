<script setup>
import Close from '@/Icons/Close.vue';
import Hamburger from '@/Icons/Hamburger.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { BookOpenIcon, ClockIcon } from '@heroicons/vue/16/solid';

defineProps({});

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
fetch('https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/optimized/tech-tools.json')
    .then(response => response.json())
    .then(data => techs.value = data);

const show = ref(false);

const active = ref( 'home' );
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
        route: '#',
        label: 'Projects',
        kicker: '// my best works',
        active: setActive( '' )
    },
    {
        route: '#',
        label: 'Blog',
        kicker: '// latest updates',
        active: setActive( '' )
    }
];

const socials = ref({
    github: {
        link: 'https://github.com/rondeo-balos',
        icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3 .3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5 .3-6.2 2.3zm44.2-1.7c-2.9 .7-4.9 2.6-4.6 4.9 .3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3 .7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3 .3 2.9 2.3 3.9 1.6 1 3.6 .7 4.3-.7 .7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3 .7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3 .7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"/></svg>'
    },
    twitterX: {
        link: 'https://x.com/rondeobalos',
        icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>'
    },
    instagram: {
        link: 'https://www.instagram.com/rondeo_balos/',
        icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>'
    }
});

const projects = ref([
    {
        title: 'Simpl.CMS',
        desc: 'A simple CMS that provides features such as database models, file management, a dashboard, block components, authentication, translations, caching and many more.',
        link: 'https://cms.rondeobalos.com/',
        image: 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/optimized/simpl.cms.mockup.webp'
    },
    {
        title: 'Cool Rate',
        desc: 'Financial and operational management system tailored for a service or installation-based company. The system likely focuses on tracking labor costs, expenses, and calculating the company’s financial "burden" or cost of operations.',
        link: false,
        image: 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/optimized/cool-rate.mockup-new.webp'
    }
]);

// Form submission
const status = ref('');
const contactForm = ref(null);
const email = ref('');
const message = ref('');
async function handleSubmit(e) {
  try {
    const data = new FormData(e.target);
    const res = await fetch('https://formspree.io/f/mleqykgp', {
      method: 'POST',
      body: data,
      headers: { Accept: 'application/json' },
    });
    if (res.ok) {
      status.value = "Thanks! I'll get back to you soon.";
      //contactForm.value.reset();
      email.value = '';
      message.value = '';
      setTimeout(() => {
        status.value = '';
      }, 5000);
    } else {
      const json = await res.json();
      if (Object.hasOwn(json, 'errors')) {
        const errors = json.errors.map((error) => error.message).join(', ');
        throw new Error(errors);
      } else {
        throw new Error('Uh-oh! There was a problem submitting your form.');
      }
    }
  } catch (err) {
    console.error(err);
    status.value = err.message;
  }
};
</script>

<style scoped>
.kanit {
    font-family: 'Kanit', sans-serif;
}
</style>

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
        <link rel="icon" href="https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/optimized/logo-transparent.webp">
        
        <link href="https://fonts.bunny.net/css" rel="stylesheet" />
    </Head>
    <div class="bg-[#151924] text-gray-200">
        <!-- Header -->
        <div class="border-b border-gray-600 border-opacity-25">
            <div class="max-w-screen-xl px-2 py-4 mx-auto flex flex-row justify-between items-center gap-10">
                <img src="https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/optimized/logo-transparent.webp" class=" max-h-12" width="auto" height="auto" alt="Logo">
                <nav class="flex-grow">
                    <ul class="max-sm:hidden flex flex-row gap-10 uppercase font-black lg:justify-center">
                        <li v-for="item in routes" class="relative group">
                            <a :href="item.route" :class="[(item.active ? 'text-white':''), 'h-full text-slate-400 group-hover:text-white transition-all']">{{ item.label }}</a>
                            <div :class="[(item.active ? 'bg-blue-500' : 'bg-gray-300 opacity-0 group-hover:opacity-100'), 'h-1 w-full rounded-lg absolute -bottom-[31px] transition-all']"></div>
                        </li>
                    </ul>
                </nav>
                <a href="#contact" class="max-sm:hidden bg-[#3289f0] hover:bg-[#22c4f5] transition-colors px-4 py-2 font-bold text-white rounded-lg">Contact</a>
                <button type="button" role="button" title="Show Nav Menu" @click="show = true" class="sm:hidden rounded-2xl bg-[#232d3d] text-white p-2 mx-2"><Hamburger class="min-w-6 min-h-6"/></button>
            </div>

        </div>

        <!-- Main content -->
        <div>
            <div class="max-w-screen-xl px-2 py-20 mx-auto">

                <h1 class="kanit uppercase text-4xl sm:text-6xl lg:text-7xl lg:-mb-3 xl:-me-5 font-black flex flex-col lg:flex-row justify-between items-center text-[#293448]">
                    <span class="text-lg text-[#2f8af3] normal-case">// Hi! <i class="not-italic text-white">my name is</i></span>
                    Rondeo Balos
                </h1>
                <div class="w-full mb-20 relative shadow-2xl rounded-3xl overflow-hidden">
                    <video class="w-full h-auto" autoplay muted loop>
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

                    <div v-for="project in projects" class="bg-[#232c3d] rounded-xl shadow-xl mb-2 flex even:flex-row-reverse odd:flex-row items-center overflow-hidden group">
                        <div class="p-10 md:p-16 z-10 flex flex-col justify-center items-start">
                            <h3 class="text-2xl sm:text-4xl font-bold text-gray-200 mb-3">{{ project.title }}</h3>
                            <p class="text-slate-400 mb-10">{{ project.desc }}</p>
                            
                            <a v-if="project.link" :href="project.link" class="bg-[#333f5b] hover:bg-[#475c87] transition-colors px-4 py-3 font-bold text-white rounded-lg mb-5">Visit Site</a>

                            <div>
                                <span class="text-sm font-bold text-blue-300 inline me-3"><BookOpenIcon class="size-5 -mt-1 inline" /> Laravel, Vue</span>
                                <span class="text-sm font-bold text-blue-300 inline"><ClockIcon class="size-5 -mt-1 inline" /> On-going</span>
                            </div>
                        </div>

                        <img :src="project.image" :alt="project.title" width="auto" height="auto" class="max-h-[400px] grayscale group-hover:grayscale-0 group-even:max-md:-mr-96 group-odd:max-md:-ml-96 opacity-20 md:opacity-80 z-0 group-hover:scale-105 transition-transform duration-1000">
                    </div>

                    <a href="#" class="bg-[#3289f0] hover:bg-[#22c4f5] transition-colors px-4 py-3 font-bold text-white rounded-lg table mx-auto shadow mt-10">View all my projects</a>
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
                                <img :src="tech.image" class="w-12 h-12 object-contain object-center" :alt="tech.name" width="auto" height="auto">
                                {{ tech.name }}
                            </div>
                        </div>
                    </template>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <footer>
            <div class="max-w-screen-xl px-2 py-4 mx-auto">
                <div class="bg-[#232c3d] rounded-3xl px-8 pb-0 sm:px-12 py-20 sm:mb-5 relative overflow-hidden">
                    <img src="/storage/media/Fafxk1Pa7mREe06HYmfyD2aqmfeBkYaxBDpgc0k8.png" class="absolute left-0 top-0 w-full h-full object-cover object-bottom opacity-50 z-0" alt="Rondeo Balos" width="auto" height="auto">
                    
                    <div class="relative">
                        <div class="mb-32" id="contact">
                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-200 text-center mb-8">Want to work with me?</h2>
                            <form :ref="contactForm" name="contactme" @submit.prevent="handleSubmit">
                                <div class="bg-[#32405a] p-1 rounded-lg flex flex-row mx-auto max-w-md mb-3">
                                    <textarea placeholder="Enter your message" id="message" name="message" v-model="message" class="grow rounded-lg border-0 bg-transparent text-white ring-0 focus:ring-0 h-32"></textarea>
                                </div>
                                <div class="bg-[#32405a] p-1 rounded-lg flex flex-row mx-auto max-w-md">
                                    <input type="text" placeholder="Enter email address" id="email" name="email" v-model="email" class="bg-transparent ring-0 focus:ring-0 text-white border-0 min-w-0 rounded-lg me-2 grow">
                                    <button type="submit" role="submit" class="bg-[#3289f0] hover:bg-[#22c4f5] transition-colors px-4 py-2 font-bold text-white rounded-lg">Send Inquiry</button>
                                </div>
                            </form>
                            <p v-if="status" class="text-center">{{ status }}</p>
                        </div>
                        
                        <div class="flex sm:flex-row flex-col mb-4">
                            <div class="grow sm:w-2/5">
                                
                                <img src="https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/optimized/logo-transparent.webp" class="max-h-16" width="auto" height="auto" alt="Logo">
                                <h3 class="kanit text-2xl font-extrabold uppercase text-white mb-3">Rondeo Balos</h3>
                                <p class="text-slate-500 font-semibold mb-20">My passion for web development extends beyond technical skills; it is driven by the desire to understand each client’s unique requirements and exceed their expectations.</p>

                                <template v-for="(social, index) in socials">
                                    <a :href="social.link" :title="index" v-html="social.icon" target="_blank" rel="noopener" class="inline-block bg-[#32405b] hover:bg-[#475c87] transition-colors p-2 rounded-lg fill-blue-200 w-10 me-2"></a>
                                </template>
                            </div>
                            <div class="grow sm:w-3/5 sm:text-right">
                                // TODO: other links
                            </div>
                        </div>

                        <div class="border-t border-gray-600 border-opacity-50 py-4">
                            <p class="text-xs text-center text-slate-500 font-semibold">&copy; 2024 All rights reserved. </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
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
                                        <a :href="item.route" :class="[(item.active ? 'text-blue-600':'text-white'), 'font-black text-3xl transition-all']">{{ item.label }}</a>
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
