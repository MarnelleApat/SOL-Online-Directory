<script setup>
    import Header from '@/Pages/Homepage/Header.vue';
    import Menu from '@/Pages/Homepage/Menu.vue';
    import Footer from '@/Pages/Homepage/Footer.vue';

    import moment from 'moment'

    defineProps({
        article: Object,
        navigationMenu: Array
    })

    const dateTime = (value) => {
        return moment(value).format('MMMM DD, YYYY');
    }

    const capitalizeFirstLetter = (string) => {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

</script>

<template>
    <div class="container mx-auto">
        <Header></Header>
        <Menu :navLinks="navigationMenu"></Menu>
    </div>

    <!-- article title -->
    <div class="container w-full px-3 lg:w-3/4 mx-auto py-4 mt-5 lg:mt-10 mb-10 border-b border-gray-300">
        <h1 class="text-4xl font-bold text-gray-700 leading-none">{{article.title}}</h1>
        <div class="meta mt-3">
            <p class="text-sm leading-0">Posted on <span class="text-red-800">{{ dateTime(article.date) }}</span></p>
            <p class="text-sm leading-0">By <span class="text-red-800">{{ article.author[0].name }}</span></p>
        </div>
    </div>

    <!-- article content -->
    <div class="container w-full px-3 lg:w-3/4 mx-auto mb-5 md:px-2 lg:px-0 min-h-[400px]">
        <div v-html="article.content"></div>
    </div>

    <!-- article footer -->
    <div class="container w-full px-3 lg:w-3/4 mx-auto py-4 mt-10 border-t border-gray-300">
        <p class="italic text-gray-900 leading-10">Categories:</p>
        <a v-for="category in article.categories" class="text-sm bg-gray-900 text-white m-1 px-2 py-1">{{ capitalizeFirstLetter(category.name) }}</a>
    </div>

    <br />
    <br />
    <Footer></Footer>

</template>
