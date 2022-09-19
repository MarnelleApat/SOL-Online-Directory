<script setup>
    import SectionHeader from '@/Pages/Homepage/Sections/SectionHeader.vue';
    import FlexFooterContent from '@/Pages/Homepage/Sections/FlexContentDisplay.vue';

    defineProps({
        hasFooter: {
            type: Boolean,
            default: false
        },
        footerContent: {
            type: Object
        },
        categoryName: {
            type: String,
        }
    })

</script>

<template>
    <div class="container mx-auto">

        <SectionHeader :categoryName=this.categoryName />

        <div class="container mx-auto mb-5 px-3 md:px-2 lg:px-0">
            <div class="flex flex-col gap-1 md:flex-row md:gap-2">
                <div class="basis-full md:basis-3/4 h-110">
                    <img class="w-full h-full" src="https://beta.streamsoflife.sg/wp-content/uploads/2022/06/Untitled-27-768x507.jpg" alt="featured post in News category"/>
                </div>
                <div class="md:basis-1/4 md:pl-2">
                    <h1 class="font-bold text-2xl my-2 md:mb-4 leading-tight">Lorem ipsum dolor sit amet, consectetur</h1>
                    <p class="leading-6 text-lg mb-5">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex
                    </p>
                    <a href="#" class="w-full md:w-fit transition duration-150 ease-out hover:ease-in rounded-none bg-gray-900 hover:bg-gray-700 text-white font-bold py-2 px-4">
                        Read More
                    </a>
                </div>
            </div>
        </div>

        <!-- If has footer == TRUE => display the content -->
        <FlexFooterContent v-if="hasFooter" :asFooter=this.hasFooter></FlexFooterContent>

    </div>
</template>
