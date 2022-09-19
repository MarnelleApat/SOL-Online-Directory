<script setup>
    import SectionHeader from '@/Pages/Homepage/Sections/SectionHeader.vue';

    defineProps({
        asFooter: {
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
        <SectionHeader v-if="!asFooter" :categoryName=this.categoryName />

        <div class="container mx-auto mb-5 px-3 md:px-2 lg:px-0">
            <div class="flex flex-col gap-5 md:flex-row md:gap-4">
                <div class="basis-1/4">
                    <div class="h-48">
                        <img class="w-full h-full" src="https://beta.streamsoflife.sg/wp-content/uploads/2022/06/HIA-SowCare-Giving_03_edit-e1655277305517-267x200.jpg" alt="featured post in News category"/>
                    </div>
                    <h1 class="font-bold text-2xl md:text-xl my-2 md:mb-3 leading-tight focus:text-orange-700 hover:text-orange-500">
                        <a href="#">Seeing Our (Unseen) Neighbours Amid Dark Times</a>
                    </h1>
                    <p class="leading-5 text-lg md:text-md">
                        While the pandemic has impacted many,
                        it has magnified the inequalities within society,
                        where the most vulnerable groups
                        in society have been heavily affected.
                    </p>
                </div>
                <div class="basis-1/4">
                    <div class="h-48">
                        <img class="w-full h-full" src="https://beta.streamsoflife.sg/wp-content/uploads/2022/06/WhatsApp-Image-2022-06-06-at-4.44.17-PM-300x168.jpeg" alt="featured post in News category"/>
                    </div>
                    <h1 class="font-bold text-2xl md:text-xl my-2 md:mb-3 leading-tight focus:text-orange-700 hover:text-orange-500">
                        <a href="#">AGWO Reached Out to 7,000 Guest Workers during Hari Raya</a>
                    </h1>
                    <p class="leading-5 text-lg md:text-md">
                        While the pandemic has impacted many,
                        it has magnified the inequalities within society,
                        where the most vulnerable groups
                        in society have been heavily affected.
                    </p>
                </div>
                <div class="basis-1/4">
                    <div class="h-48">
                        <img class="w-full h-full" src="https://beta.streamsoflife.sg/wp-content/uploads/2022/03/WhatsApp-Image-2022-03-10-at-2.01.13-PM-300x300.jpeg" alt="featured post in News category"/>
                    </div>
                    <h1 class="font-bold text-2xl md:text-xl my-2 md:mb-3 leading-tight focus:text-orange-700 hover:text-orange-500">
                        <a href="#">Pray for Ukraine — The Greatest Crisis of this Generation</a>
                    </h1>
                    <p class="leading-5 text-lg md:text-md">
                        While the pandemic has impacted many,
                        it has magnified the inequalities within society,
                        where the most vulnerable groups
                        in society have been heavily affected.
                    </p>
                </div>
                <div class="basis-1/4">
                    <div class="h-48">
                        <img class="w-full h-full" src="https://beta.streamsoflife.sg/wp-content/uploads/2022/03/e37dcf_6aa8d6d644c94e289da003802bdfb07b_mv2-300x225.jpeg" alt="featured post in News category"/>
                    </div>
                    <h1 class="font-bold text-2xl md:text-xl my-2 md:mb-3 leading-tight focus:text-orange-700 hover:text-orange-500">
                        <a href="#">AGWO Brought Christmas Cheer to More than 20,000 Guest Workers in December</a>
                    </h1>
                    <p class="leading-5 text-lg md:text-md">
                        While the pandemic has impacted many,
                        it has magnified the inequalities within society,
                        where the most vulnerable groups
                        in society have been heavily affected.
                    </p>
                </div>
            </div>
        </div>

    </div>
</template>
