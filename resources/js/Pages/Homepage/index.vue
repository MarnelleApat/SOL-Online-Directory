<script setup>
    import AuthenticatedUserLayout from '@/Layouts/User/AuthenticatedUser.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import { onMounted, reactive, defineComponent } from 'vue';
    import ThumbnailSlider from '@/Pages/Events/ThumbnailCarousel.vue';
    import PartnerSection from './PartnersSection.vue'
    import AboutUsSection from './AboutUsSection.vue'
    import { Carousel, Slide, Navigation, Pagination } from 'vue3-carousel'

    import 'vue3-carousel/dist/carousel.css';

    const props = defineProps({
        events: Object,
        categories: Object
    })
    // const event = props.events
    const headerTitle = 'Events - SOL Online Registration'

    const randomPhoto = reactive([
        {'imagePath': 'http://sorgalla.com/jcarousel/examples/_shared/img/img1.jpg'},
        {'imagePath': 'https://www.rappler.com/tachyon/2021/10/manila-baywalk-dolomite-beach-covid-19-october-19-2021-003.jpg'},
        {'imagePath': 'http://sorgalla.com/jcarousel/examples/_shared/img/img3.jpg'},
        {'imagePath': 'http://sorgalla.com/jcarousel/examples/_shared/img/img4.jpg'},
        {'imagePath': 'http://sorgalla.com/jcarousel/examples/_shared/img/img5.jpg'},
        {'imagePath': 'http://sorgalla.com/jcarousel/examples/_shared/img/img6.jpg'}
    ])

    onMounted(() => {
        props.events.data.forEach(event => {
            const randomIndex = Math.floor(Math.random() * randomPhoto.length);
            event.carouselBanner =randomPhoto[randomIndex].imagePath;
        });
    })

</script>

<template>
    <Head :title="headerTitle"></Head>

    <AuthenticatedUserLayout>
        <div class="min-h-[500px]">
            <Carousel :autoplay="100000" :wrap-around="true">
                <Slide v-for="(event,index) in events.data" :key="index">
                    <div class="flex items-center justify-center min-h-[500px] w-screen relative bg-cover bg-center">
                        <img :src="event.carouselBanner" class="w-screen h-[600px] absolute top-0 left-0 object-cover bg-gray-400" />
                        <div class="w-full h-[600px] flex flex-col gap-4 justify-center items-center bg-gray-700/40 backdrop-brightness-75">
                            <h1 class="text-white px-4 text-4xl sm:text-6xl md:text-6xl lg:text-6xl xl:text-6xl w-full sm:w-3/4 md:w-3/4 lg:w-3/4 xl:w-3/4 text-center font-black leading-none">{{ event.title }}</h1>
                            <p class="text-white text-xl leading-tight px-4">{{ event.description }}</p>
                            <div class="flex flex-col sm:flex-row md:flex-row lg:flex-row xl:flex-row gap-4 mt-10">
                                <a  href="#" class="bg-gray-800 hover:bg-gray-600 border text-white transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300 rounded-full text-md shadow-lg py-3 sm:px-7 md:px-7 lg:px-7 xl:px-7 px-14">Register Now</a>
                                <a  :href="route('singleEvent.public', event.slug)" class="bg-teal-600 hover:bg-teal-500 hover:text-gray-100 border transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300 border-teal-500 text-white rounded-full text-md shadow-lg py-3 sm:px-7 md:px-7 lg:px-7 xl:px-7 px-14 flex items-center">View Details</a>
                            </div>
                        </div>
                    </div>
                </Slide>
                <template #addons>
                    <!-- <Navigation /> -->
                </template>
            </Carousel>
        </div>

        <div class="flex pt-8 pb-5 bg-white px-2 shadow-md">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-center block sm:block md:block lg:hidden xl:hidden text-2xl mb-4 font-bold text-gray-700">Categories</h2>
                <div class="flex flex-wrap justify-evenly gap-1 sm:gap-1 md:gap-1 lg:gap-4 xl:gap-4 items-center">
                    <a href="#" class="text-gray-500 cursor-pointer text-sm group py-1 px-2 uppercase whitespace-nowrap font-extrabold hover:text-teal-700 leading-0">
                        <div class="group-hover:border-b-[3px] group-hover:border-teal-600 border-b-[3px] border-transparent tracking-tight">
                           General
                        </div>
                    </a>
                    <a href="#" v-for="category in categories" class="text-gray-500 cursor-pointer text-sm group py-1 px-2 uppercase whitespace-nowrap font-extrabold hover:text-teal-700 leading-0">
                        <div class="group-hover:border-b-[3px] group-hover:border-teal-600 border-b-[3px] border-transparent tracking-tight">
                            {{ category.name }}
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="min-h-xl p-10 bg-gradient-to-r from-gray-100/70 via-slate-300/40 to-gray-100/70">
            <div class="py-8">
                <div class="max-w-6xl mx-auto">
                    <div class="flex flex-col gap-5 px-5">
                        <div class="flex justify-center sm:justify-center md:justify-center lg:justify-between xl:justify-between flex-col sm:flex-col md:flex-col lg:flex-row xl:flex-row items-center">
                            <h1 class="text-[30px] sm:text-[28px] md:text-[28px] lg:text-[25px] xl:text-[25px] font-bold text-teal-600">SIBD Programmes</h1>
                            <a href="#" class="text-teal-700 hover:text-teal-600 font-semibold flex items-center text-xl sm:text-xl md:text-xl lg:text-sm xl:text-sm">
                                See more SIBD Programmes
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                                </svg>
                            </a>
                        </div>
                        <ThumbnailSlider :events="events.data" />
                    </div>
                </div>
            </div>

            <div class="py-10">
                <div class="max-w-6xl mx-auto">
                    <div class="flex flex-col gap-5 px-5">
                        <div class="flex justify-center sm:justify-center md:justify-center lg:justify-between xl:justify-between flex-col sm:flex-col md:flex-col lg:flex-row xl:flex-row items-center">
                            <h1 class="text-[30px] sm:text-[28px] md:text-[28px] lg:text-[25px] xl:text-[25px] font-bold text-teal-600">D6 Family Events</h1>
                            <a href="#" class="text-teal-700 hover:text-teal-600 font-semibold flex items-center text-xl sm:text-xl md:text-xl lg:text-sm xl:text-sm">
                                See more D6 Family events
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                                </svg>
                            </a>
                        </div>
                        <ThumbnailSlider :events="events.data" />
                    </div>
                </div>
            </div>
        </div>


        <!-- Partners Section -->
        <PartnerSection />

        <!-- About Us Section -->
        <AboutUsSection />

    </AuthenticatedUserLayout>
</template>


