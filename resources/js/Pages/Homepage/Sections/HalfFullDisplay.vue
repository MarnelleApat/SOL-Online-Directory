<script setup>
    import SectionHeader from '@/Pages/Homepage/Sections/SectionHeader.vue';
    import BreezeNavLink from '@/Components/NavLink.vue';
import { ref } from 'vue';

    defineProps({
        catNameLeft: {
            type: String,
        },

        catNameRight: {
            type: String
        },
    })

    const dummies1 = [
            {id: 1, title: 'Announcement1', url: '#'},
            {id: 2, title: 'Announcement2', url: '#' },
            {id: 3, title: 'Announcement3', url: '#'}
        ];
    const dummies2 = [
            {id: 1, title: 'Events22221', url: '#'},
            {id: 2, title: 'Events22222', url: '#' },
            {id: 3, title: 'Events22223', url: '#'}
        ];
</script>

<template>
    <div class="container mx-auto mb-5 px-3 md:px-2 lg:px-0">
        <div class="flex flex-col gap-1 md:flex-row md:gap-4">
            <div class="basis-full md:basis-1/2 md:border-r-2 md:border-gray-300 md:pr-4">
                <SectionHeader :categoryName=this.catNameLeft :showViewAll=false></SectionHeader>

                <template v-for="dummy in dummies1">
                    <div class="flex flex-col gap-2 md:flex-row md:gap-4 mb-4">
                        <div class="basis-1/2">
                            <div class="h-48">
                                <img class="w-full h-full" src="https://beta.streamsoflife.sg/wp-content/uploads/2022/06/HIA-SowCare-Giving_03_edit-e1655277305517-267x200.jpg" alt="featured post in News category"/>
                            </div>
                        </div>
                        <div class="basis-1/2">
                            <h1 class="font-bold text-2xl md:text-xl mb-2 md:mb-3 leading-none focus:text-orange-700 hover:text-orange-500">
                                <a href="#">{{ dummy.title }}</a>
                            </h1>
                            <p class="leading-5 text-lg md:text-md">
                                While the pandemic has impacted many,
                                it has magnified the inequalities within society,
                                where the most vulnerable groups
                                in society have been heavily affected.
                            </p>
                        </div>
                    </div>
                </template>

                <div class="text-center md:text-right mb-3">
                    <BreezeNavLink class="text-gray-700 my-2 hover:text-orange-700 leading-3 text-lg md:text-md" href="#">
                        View All {{ catNameLeft }} <span class="ml-1 text-xl">▸</span>
                    </BreezeNavLink>
                </div>
            </div>

            <div class="container mx-auto border-b-2 border-gray-300 mb-4 md:hidden"></div>

            <div class="basis-full md:basis-1/2">
                <SectionHeader :categoryName=this.catNameRight :showViewAll=false></SectionHeader>

                <template v-for="dummy in this.dummies2">
                    <div class="flex flex-col gap-2 md:flex-row md:gap-4 mb-4">
                        <div class="basis-1/2">
                            <div class="h-48">
                                <img class="w-full h-full" src="https://beta.streamsoflife.sg/wp-content/uploads/2022/06/WhatsApp-Image-2022-06-06-at-4.44.17-PM-300x168.jpeg" alt="featured post in News category"/>
                            </div>
                        </div>
                        <div class="basis-1/2">
                            <h1 class="font-bold text-2xl md:text-xl mb-2 md:mb-3 leading-none focus:text-orange-700 hover:text-orange-500">
                                <a href="#">{{ dummy.title }}</a>
                            </h1>
                            <p class="leading-5 text-lg md:text-md">
                                While the pandemic has impacted many,
                                it has magnified the inequalities within society,
                                where the most vulnerable groups
                                in society have been heavily affected.
                            </p>
                        </div>
                    </div>
                </template>

                <div class="text-center md:text-right mb-3">
                    <BreezeNavLink class="text-gray-700 my-2 hover:text-orange-700 leading-3 text-lg md:text-md" href="#">
                        View All {{ catNameRight }} <span class="ml-1 text-xl">▸</span>
                    </BreezeNavLink>
                </div>

            </div>
        </div>
    </div>

</template>
