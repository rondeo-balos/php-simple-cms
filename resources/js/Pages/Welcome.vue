<script setup>
import Close from '@/Icons/Close.vue';
import Hamburger from '@/Icons/Hamburger.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

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
const techs = ref({
    laravel: {
        name: 'Laravel',
        image: 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/logo/laravel.svg',
        type: 'framework'
    },
    vue: {
        name: 'Vue',
        image: 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/logo/vue.svg',
        type: 'framework'
    },
    tailwind: {
        name: 'Tailwind',
        image: 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/logo/tailwind.svg',
        type: 'framework'
    },
    css: {
        name: 'CSS',
        image: 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/logo/css.svg',
        type: 'language'
    },
    js: {
        name: 'Javascript',
        image: 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/logo/javascript.svg',
        type: 'language'
    },
    php: {
        name: 'PHP',
        image: 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/logo/new-php.svg',
        type: 'language'
    },
    java: {
        name: 'Java',
        image: 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/logo/java.svg',
        type: 'language'
    },
    html: {
        name: 'HTML',
        image: 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/logo/html.svg',
        type: 'language'
    },
    git: {
        name: 'Git',
        image: 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/logo/git.svg',
        type: 'tool'
    },
    mysql: {
        name: 'MySQL',
        image: 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/logo/mysql.svg',
        type: 'tool'
    },
    vscode: {
        name: 'VS Code',
        image: 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/logo/vscode.svg',
        type: 'tool'
    },
    wordpress: {
        name: 'Wordpress',
        image: 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/logo/wordpress-white.svg',
        type: 'others'
    },
    clickfunnels: {
        name: 'Clickfunnels',
        image: 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/logo/clickfunnels.svg',
        type: 'others'
    },
    shopify: {
        name: 'Shopify',
        image: 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/logo/shopify.svg',
        type: 'others'
    }
});

const show = ref(false);

const active = ref( 'home' );
const setActive = function( route ) {
    console.log( route );
    return active.value === route;
};
const routes = [
    {
        route: route( 'home' ),
        label: 'Welcome',
        kicker: '// to my home',
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

<template>
    <Head title="Web Developer Portfolio - Rondeo Balos">
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
        <link rel="icon" href="//rondeobalos.com/src/media/f80e13a2660d5c11.webp">

        <link rel="canonical" href="https://rondeobalos.com/">
    </Head>
    <div class="bg-[#151924] text-gray-200">
        <!-- Header -->
        <div class="border-b border-gray-600 border-opacity-25">
            <div class="max-w-screen-xl px-2 py-4 mx-auto flex flex-row justify-between items-center gap-10">
                <img src="/storage/media/6uUcM3XEI3h2BsYfOHqviXadoMt5v1jVQUdYgqee.png" class=" max-h-12" alt="Logo">
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
                    <div class="bg-[#232c3d] rounded-xl shadow-xl mb-10 flex flex-row overflow-hidden">
                        <div class="p-10 md:p-20 z-10 flex flex-col justify-center items-start">
                            <h3 class="text-2xl sm:text-4xl font-bold text-gray-200 mb-3">Simpl.CMS</h3>
                            <p class="text-slate-400 mb-10">A simple CMS that provides features such as database models, file management, a dashboard, block components, authentication, translations, caching and many more.</p>
                            
                            <a href="https://cms.rondeobalos.com" class="bg-[#333f5b] hover:bg-[#22c4f5] transition-colors px-4 py-3 font-bold text-white rounded-lg">Visit Site</a>
                        </div>
                        <img src="/storage/media/AcPmVrkwjIbPjUHRTxqvyewIJPHtKO9ImYqcSWgS.webp" alt="Simpl.CMS" class="max-h-[400px] max-md:-ml-96 opacity-20 md:opacity-80 z-0">
                    </div>
                    <a href="#" class="bg-[#3289f0] hover:bg-[#22c4f5] transition-colors px-4 py-3 font-bold text-white rounded-lg table mx-auto shadow">View all my projects</a>
                </div>
                
                <div class="mx-auto max-w-2xl">
                    <h2 class="text-2xl sm:text-4xl font-bold text-gray-200 text-center mb-3">Technologies and Tools I use</h2>
                    <p class="text-center text-slate-400 mb-10">I take pride in showcasing my comprehensive knowledge and expertise in web development, utilizing a wide range of modern tools and technologies to deliver high-quality solutions.</p>
                    <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-800 mb-5">
                        <ul class="flex flex-wrap -mb-px justify-center">
                            <li v-for="(type, index) in types" class="mx-2">
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
                                <img :src="tech.image" class="w-12 h-12 object-contain object-center" :alt="tech.name">
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
                <div class="bg-[#232c3d] rounded-3xl px-8 pb-0 sm:px-12 py-20 sm:mb-5">
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
                            <h3 class="text-3xl font-black uppercase text-white mb-3">Rondeo Balos</h3>
                            <p class="text-slate-500 font-semibold mb-20">My passion for web development extends beyond technical skills; it is driven by the desire to understand each client’s unique requirements and exceed their expectations.</p>

                            // TODO: icons
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
                                </ul>
                            </nav>

                            <a href="#contact" @click="show = false" type="submit" role="submit" class="bg-[#3289f0] hover:bg-[#22c4f5] transition-colors px-4 py-2 font-bold text-white rounded-lg self-center">Contact</a>
                        </div>
                    </Transition>
                </div>
            </Transition>
        </Teleport>
    </template>
</template>
