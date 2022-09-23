<script setup>
    import Header from '@/Pages/Homepage/Header.vue';
    import Menu from '@/Pages/Homepage/Menu.vue';
    import Footer from '@/Pages/Homepage/Footer.vue';

    defineProps({
        catData: Object,
    })

</script>

<template>
    <div class="container mx-auto">
        <Header></Header>
        <Menu></Menu>
    </div>


    <div class="container mx-auto py-6">
        <h1 class="text-4xl font-bold text-gray-700 uppercase">{{ catData.category_name }}</h1>
    </div>

    <div class="container mx-auto mb-5 px-3 md:px-2 lg:px-0">
        <div class="flex flex-col gap-5 md:flex-row md:gap-4">
            <div v-for="article in catData.articles" class="basis-1/4">
                <!-- {{ article }} -->
                <div class="h-48">
                    <img class="w-full h-full" :src='article.url' alt="featured post in News category"/>
                </div>
                <h1 class="font-bold text-2xl md:text-xl my-2 md:mb-3 leading-tight focus:text-orange-700 hover:text-orange-500">
                    {{ article.title}}
                </h1>
                <div class="meta mb-3">
                    <p class="text-sm leading-0">Posted on <span class="text-red-800">{{ article.date}}</span></p>
                    <p class="text-sm leading-0">By <span class="text-red-800">{{ article.author}}</span></p>
                </div>
                <p class="leading-5 text-lg md:text-md">
                    {{ article.content }}
                </p>
                <br />
                <a :href='`/article/${article.slug}`' class="text-sm text-red-500 border border-red-500 py-1 px-3 hover:bg-red-400 hover:text-white items-center">
                    Read More
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 inline-block" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>


    <Footer></Footer>

</template>
