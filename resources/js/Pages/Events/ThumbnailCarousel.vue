<script setup>

    import { defineComponent } from 'vue'
    import { Carousel, Slide, Navigation } from 'vue3-carousel'
    import eventcard from './EventCard.vue'

    defineComponent({
        eventcard: {
            required:true
        }
    })
    defineProps({
        events: Object
    })

    // Thumbnail Carousel settings
    // carousel settings
    const settings = { itemsToShow: 3.9, snapAlign: 'center' }

    // breakpoints are mobile first
    // any settings not specified will fallback to the carousel settings
    const breakpoints = {
        // 375px and up
        375: {
            itemsToShow: 1,
            snapAlign: 'center',
        },
        // 700px and up
        700: {
            itemsToShow: 2.7,
            snapAlign: 'center',
        },
        // 1024 and up
        1024: {
            itemsToShow: 4,
            snapAlign: 'center',
        },
    }

</script>

<template>
    <Carousel :settings="settings" :breakpoints="breakpoints">
        <Slide v-for="(event,index) in events" :key="index">
            <div class="carousel__item">
                <eventcard :event="event" />
            </div>
        </Slide>

        <template #addons>
            <Navigation>
                <template #next>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-teal-600">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z" clip-rule="evenodd" />
                    </svg>
                </template>
                <template #prev>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-teal-600">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-4.28 9.22a.75.75 0 000 1.06l3 3a.75.75 0 101.06-1.06l-1.72-1.72h5.69a.75.75 0 000-1.5h-5.69l1.72-1.72a.75.75 0 00-1.06-1.06l-3 3z" clip-rule="evenodd" />
                    </svg>
                </template>
            </Navigation>
        </template>
    </Carousel>
</template>

<style scoped>
    .carousel__slide {
        padding: 5px;
    }

    .carousel__viewport {
        /* perspective: 5000px; */
        margin-inline: 25px !important;
    }

    .carousel__track {
        transform-style: flat;
    }

    /* .carousel__slide--sliding {
        transition: 0.5s;
    }

    .carousel__slide {
        transform: rotateY(-10deg) scale(0.95);
    }

    .carousel__slide--active {
        transform: rotateY(-20deg) scale(1);
    } */

</style>
