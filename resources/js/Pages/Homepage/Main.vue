<script setup>
    import Header from '@/Pages/Homepage/Header.vue'
    import Menu from '@/Pages/Homepage/Menu.vue';
    import Footer from '@/Pages/Homepage/Footer.vue';

    import FullDisplay from '@/Pages/Homepage/Sections/FullDisplay.vue';
    import HalfFullDisplay from '@/Pages/Homepage/Sections/HalfFullDisplay.vue';
    import FlexContentDisplay from '@/Pages/Homepage/Sections/FlexContentDisplay.vue';

    import Divider from '@/Pages/Homepage/Divider.vue';


    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
    })
</script>

<template>
    <div class="container mx-auto">
        <Header></Header>
        <Menu></Menu>
    </div>

    <FullDisplay categoryName="News" :hasFooter=true></FullDisplay>

    <Divider></Divider>

    <FlexContentDisplay categoryName="Mission Stories"></FlexContentDisplay>

    <Divider></Divider>

    <FlexContentDisplay categoryName="Humanitarian"></FlexContentDisplay>

    <Divider></Divider>

    <FullDisplay categoryName="Theology" :hasFooter=false></FullDisplay>

    <Divider></Divider>

    <FlexContentDisplay categoryName="Opinions"></FlexContentDisplay>

    <Divider></Divider>

    <HalfFullDisplay catNameLeft="Announcements" catNameRight="Events"></HalfFullDisplay>

    <Divider></Divider>

    <FullDisplay categoryName="Videos" :hasFooter=true></FullDisplay>

    <Divider></Divider>

    <FullDisplay categoryName="Culture" :hasFooter=false></FullDisplay>

    <Divider></Divider>

    <FlexContentDisplay categoryName="Arts"></FlexContentDisplay>

    <Divider></Divider>

    <FullDisplay categoryName="Generations" :hasFooter=false></FullDisplay>

    <Divider></Divider>

    <FlexContentDisplay categoryName="Lifestyles"></FlexContentDisplay>

    <Divider></Divider>

    <FlexContentDisplay categoryName="Analysis"></FlexContentDisplay>

    <Footer></Footer>

</template>
