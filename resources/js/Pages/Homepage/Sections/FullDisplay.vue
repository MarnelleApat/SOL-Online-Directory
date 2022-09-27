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
        },
        categorySlug: {
            type: String,
        },
        articles: {
            type: Array
        }
    })

</script>

<template>
    <div class="container mx-auto">

        <SectionHeader :categoryName=this.categoryName :categorySlug=this.categorySlug />
        <div class="container mx-auto mb-5 px-3 md:px-2 lg:px-0">
            <div class="flex flex-col gap-1 md:flex-row md:gap-2">
                <div class="basis-full md:basis-3/4 h-110">
                    <img class="w-full h-full" :src='articles[0].thumbnail' :alt='articles[0].thumbnail' />
                </div>
                <div class="md:basis-1/4 md:pl-2">
                    <h1 class="font-bold text-2xl my-2 md:mb-4 leading-tight">{{ articles[0].title }}</h1>
                    <p class="leading-6 text-lg mb-5">{{ articles[0].excerpt }}</p>
                    <a :href='`/article/${articles[0].slug}`' class="w-full md:w-fit transition duration-150 ease-out hover:ease-in rounded-none bg-gray-900 hover:bg-gray-700 text-white font-bold py-2 px-4">
                        Read More
                    </a>
                </div>
            </div>
        </div>

        <!-- If has footer == TRUE => display the content -->
        <FlexFooterContent v-if="hasFooter" :asFooter=this.hasFooter :articles="articles"></FlexFooterContent>

    </div>
</template>
