<script setup>
    import Header from '@/Pages/Homepage/Header.vue'
    import Menu from '@/Pages/Homepage/Menu.vue';
    import Footer from '@/Pages/Homepage/Footer.vue';

    import FullDisplay from '@/Pages/Homepage/Sections/FullDisplay.vue';
    import HalfFullDisplay from '@/Pages/Homepage/Sections/HalfFullDisplay.vue';
    import FlexContentDisplay from '@/Pages/Homepage/Sections/FlexContentDisplay.vue';
    import VideoSection from '@/Pages/Homepage/Sections/VideosCategory.vue';

    import ContactUs from '@/Pages/Homepage/Sections/ContactUs.vue';
    import Traineeship from '@/Pages/Homepage/Sections/Traineeship.vue';

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

    <VideoSection categoryName="Videos"></VideoSection>

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

    <Divider></Divider>

    <div class="container mx-auto mb-5 h-110 md:h-100" style=" background-size:top; background-repeat:none; background-size:cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-image: linear-gradient( rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7) ), url(https://beta.streamsoflife.sg/wp-content/uploads/2022/03/chris-karidis-7lSA8da0Qs8-unsplash-scaled.jpg);">
        <div class="text-white w-full text-center px-3 pt-5 md:text-left md:pl-20 md:w-4/5">
            <h1 class="font-bold text-4xl leading-tight md:leading-none my-2 md:my-8 md:mb-4 ">The Voice of Tradition</h1>
            <p class="leading-6 text-lg">
                Hope Initiative Alliance collaborated with Lutheran Community Care Services,
                Care Corner Counselling Centre, and Trauma Healing Institute, to organise
                he Invisibles exhibition at Far East Plaza. Held from 12 – 21 July 2019,
                the exhibition aimed to promote the importance of mental wellness through
                various installations and activities such as a mime...
            </p>
            <button class="transition duration-150 ease-out hover:ease-in mt-5 md:mt-10 outline outline-offset-2 outline-1 hover:bg-gray-700 text-white font-bold py-2 px-4">Read More</button>
        </div>
    </div>

    <Divider></Divider>

    <ContactUs></ContactUs>

    <Divider></Divider>

    <Traineeship></Traineeship>

    <br />
    <br />

    <Footer></Footer>

</template>
