<script setup>
    import Header from '@/Pages/Homepage/Header.vue';
    import Menu from '@/Pages/Homepage/Menu.vue';
    import Footer from '@/Pages/Homepage/Footer.vue';

    defineProps({
        article: Object,
    })

</script>

<template>
    <div class="container mx-auto">
        <Header></Header>
        <Menu></Menu>
    </div>

    <!-- article title -->
    <div class="container w-3/4 mx-auto py-4 mt-10 mb-3 border-b border-gray-300">
        <h1 class="text-4xl font-bold text-gray-700 leading-none">{{article.title}}</h1>
        <div class="meta mt-3">
            <p class="text-sm leading-0">Posted on <span class="text-red-800">{{ article.date}}</span></p>
            <p class="text-sm leading-0">By <span class="text-red-800">{{ article.author}}</span></p>
        </div>
    </div>

    <!-- article content -->
    <div class="container w-3/4 mx-auto mb-5 px-3 md:px-2 lg:px-0 min-h-[400px]">
        <div v-html="article.content"></div>
    </div>

    <!-- article footer -->
    <div class="container w-3/4 mx-auto py-4 mt-10 border-t border-gray-300">
        <p class="italic text-gray-900">Categories:</p>
        <button class="text-sm bg-gray-900 text-white italic m-1 px-2 py-1">Humanitarian</button>
        <button class="text-sm bg-gray-900 text-white italic m-1 px-2 py-1">News</button>
    </div>

    <Footer></Footer>

</template>
