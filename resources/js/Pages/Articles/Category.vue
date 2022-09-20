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
        <h1 class="text-3xl font-bol text-gray-700">{{ catData.slug }}</h1>
        <p>{{ catData.articles }}</p>
    </div>

    <Footer></Footer>

</template>
