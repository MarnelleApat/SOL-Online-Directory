<script setup>
    import SectionHeader from '@/Pages/Homepage/Sections/SectionHeader.vue';
import { ref } from 'vue';

    defineProps({
        asFooter: {
            type: Boolean,
            default: false
        },
        categoryName: {
            type: String,
        },
        categorySlug: {
            type: String,
        },
        articles: {
            type: Array,
            default: []
        }
    })

</script>

<template>
    <div class="container mx-auto">
        <SectionHeader v-if="!asFooter" :categoryName=this.categoryName :categorySlug=this.categorySlug />
        <div class="container mx-auto mb-5 px-3 md:px-2 lg:px-0">
            <div class="flex flex-col gap-5 md:flex-row md:gap-4">
                <template v-for="(article, idx) in articles">
                    <div class="basis-1/4" v-if="idx<=3">
                        <div class="h-48">
                            <img class="w-full h-full" :src='article.thumbnail' :alt='article.thumbnail' />
                        </div>
                        <h1 class="font-bold text-2xl md:text-xl my-2 md:mb-3 leading-tight focus:text-orange-700 hover:text-orange-500 lg:overflow-y-hidden lg:h-[70px]">
                            <a :href='`/article/${article.slug}`'>{{article.title}}</a>
                        </h1>
                        <p class="leading-5 text-lg md:text-md">{{article.excerpt}}</p>
                    </div>
                </template>
                <!-- temporary only -->
                <div v-if="articles.length<=3" class="basis-1/4">
                    <div class="h-48">
                        <img class="w-full h-full" src="https://beta.streamsoflife.sg/wp-content/uploads/2022/03/e37dcf_6aa8d6d644c94e289da003802bdfb07b_mv2-300x225.jpeg" alt="featured post in News category"/>
                    </div>
                    <h1 class="font-bold text-2xl md:text-xl my-2 md:mb-3 leading-tight focus:text-orange-700 hover:text-orange-500 lg:overflow-y-hidden lg:h-[70px]">
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
