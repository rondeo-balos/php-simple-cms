<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ArrowPathIcon } from '@heroicons/vue/16/solid';
import PrimaryText from '@/Pages/Partials/PrimaryText.vue';

const cdn = ref(usePage().props.cdn);

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

// Form submission
const status = ref('');
const email = ref('');
const message = ref('');
const submitted = ref(false);
async function handleSubmit(e) {
    submitted.value = true;
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
            submitted.value = false;
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
        submitted.value = false;
    }
};
</script>

<template>
    <!-- Footer -->
    <footer>
        <div class="max-w-screen-xl px-2 py-4 mx-auto">
            <div class="bg-[#232c3d] rounded-3xl px-8 pb-0 sm:px-12 py-20 sm:mb-5 relative overflow-hidden">
                <img :src="`${cdn}rondeo-footer-lg.webp`" class="absolute left-0 top-0 w-full h-full object-cover object-bottom opacity-50 z-0 max-md:hidden" alt="Rondeo Balos" width="auto" height="auto">
                
                <div class="relative">
                    <img :src="`${cdn}logo-bordered-transparent-fade.webp`" class="opacity-5 w-72 absolute left-1/2 -ml-36">
                    
                    <div class="mb-32 pt-10 relative" id="contactEl">

                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-200 text-center mb-1">Need help with a project?</h2>
                        <h3 class="text-center"><PrimaryText>Let's Talk!</PrimaryText></h3>
                        <p class="mb-8 text-center"><a href="tel:+639615936086" class="text-blue-300">+63 (961) 593-6086</a></p>
                        <form name="contactme" @submit.prevent="handleSubmit">
                            <div class="bg-[#32405a] p-1 rounded-lg flex flex-row mx-auto max-w-md mb-3">
                                <textarea placeholder="Enter your message" id="message" name="message" v-model="message" class="grow rounded-lg border-0 bg-transparent text-white ring-0 focus:ring-0 h-32"></textarea>
                            </div>
                            <div class="bg-[#32405a] p-1 rounded-lg flex flex-row mx-auto max-w-md">
                                <input type="text" placeholder="Enter email address" id="email" name="email" v-model="email" class="bg-transparent ring-0 focus:ring-0 text-white border-0 min-w-0 rounded-lg me-2 grow">
                                <button type="submit" role="button" class="bg-[#3289f0] hover:bg-[#1770db] transition-colors px-4 py-2 font-bold text-white rounded-lg text-nowrap">
                                    Send Inquiry <ArrowPathIcon class="h-5 inline animate-spin" v-if="submitted" />
                                </button>
                            </div>
                        </form>
                        <p v-if="status" class="text-center">{{ status }}</p>
                    </div>
                    
                    <div class="flex sm:flex-row flex-col mb-4 max-sm:text-center">
                        <div class="grow sm:w-2/5">
                            
                            <img :src="`${cdn}logo-transparent.webp`" class="max-h-16 max-sm:mx-auto" width="auto" height="auto" alt="Logo">
                            <h3 class="kanit text-2xl font-extrabold uppercase text-white mb-3">Rondeo Balos</h3>
                            <p class="text-slate-500 font-semibold mb-10">My passion for web development extends beyond technical skills; it is driven by the desire to understand each client’s unique requirements and exceed their expectations.</p>

                            <template v-for="(social, index) in socials">
                                <a :href="social.link" :title="index" v-html="social.icon" target="_blank" rel="noopener" class="inline-block bg-[#32405b] hover:bg-[#475c87] hover:scale-110 transition-all p-2 rounded-lg fill-blue-200 w-10 me-2 h-10"></a>
                            </template>
                        </div>
                        <div class="grow sm:w-3/5 sm:text-right">
                            <div class="inline-block text-left">
                                <!--<h4 class="kanit font-bold uppercase mb-4 mt-4 max-sm:text-center">What I excel at</h4>-->
                                <ul class="text-blue-300 flex sm:flex-col flex-wrap gap-1 justify-center max-sm:text-sm">
                                    <li>Design Systems</li>
                                    <li class="sm:hidden" aria-hidden="true" role="presentation">&bull;</li>
                                    <li>Mobile App & Web Design</li>
                                    <li class="sm:hidden" aria-hidden="true" role="presentation">&bull;</li>
                                    <li>App Development</li>
                                    <li class="sm:hidden" aria-hidden="true" role="presentation">&bull;</li>
                                    <li>Website Development</li>
                                    <li class="sm:hidden" aria-hidden="true" role="presentation">&bull;</li>
                                    <li>System Development</li>
                                    <li class="sm:hidden" aria-hidden="true" role="presentation">&bull;</li>
                                    <li>Backend Development</li>
                                    <li class="sm:hidden" aria-hidden="true" role="presentation">&bull;</li>
                                    <li>E-commerce & Shopify</li>
                                    <li class="sm:hidden" aria-hidden="true" role="presentation">&bull;</li>
                                    <li>CRM, CMS, Web Apps</li>
                                    <li class="sm:hidden" aria-hidden="true" role="presentation">&bull;</li>
                                    <li>Accessibility</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-600 border-opacity-50 py-4">
                        <p class="text-xs text-center text-slate-500 font-semibold">&copy; 2024 All rights reserved. </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>