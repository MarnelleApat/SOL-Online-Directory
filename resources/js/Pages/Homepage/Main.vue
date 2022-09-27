<script setup>
    import Header from '@/Pages/Homepage/Header.vue'
    import Menu from '@/Pages/Homepage/Menu.vue';
    import Footer from '@/Pages/Homepage/Footer.vue';

    import FullDisplay from '@/Pages/Homepage/Sections/FullDisplay.vue';
    import HalfFullDisplay from '@/Pages/Homepage/Sections/HalfFullDisplay.vue';
    import FlexContentDisplay from '@/Pages/Homepage/Sections/FlexContentDisplay.vue';
    import VideoSection from '@/Pages/Homepage/Sections/VideosCategory.vue';

    import SectionHeader from './Sections/SectionHeader.vue';
    import ContactUs from '@/Pages/Homepage/Sections/ContactUs.vue';
    import Traineeship from '@/Pages/Homepage/Sections/Traineeship.vue';

    import Divider from '@/Pages/Homepage/Divider.vue';

    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        navigationMenu: Array,
        newsArticles: Array,
        missionArticles: Array,
        humanitarianArticles: Array,
        theologyArticles: Array,
        opinionArticles: Array,
        announcementArticles: Array,
        eventArticles: Array,
        videoArticles: Array,
        cultureArticles: Array,
        artArticles: Array,
        generationArticles: Array,
        lifestyleArticles: Array,
        analysisArticles: Array,
        contributionArticles: Array,
    });
</script>

<template>
    <div class="bg-white w-full">
        <div class="container mx-auto">
            <Header></Header>
            <Menu :navLinks="navigationMenu"></Menu>
        </div>
    </div>

    <FullDisplay :articles="newsArticles" categoryName="News" categorySlug="news" :hasFooter=true></FullDisplay>

    <Divider></Divider>

    <FlexContentDisplay :articles="missionArticles" categoryName="Mission Stories" categorySlug="mission-stories"></FlexContentDisplay>

    <Divider></Divider>

    <FlexContentDisplay :articles="humanitarianArticles" categoryName="Humanitarian" categorySlug="humanitarian"></FlexContentDisplay>

    <Divider></Divider>

    <FullDisplay :articles="theologyArticles" categoryName="Theology" categorySlug="theology" :hasFooter=false></FullDisplay>

    <Divider></Divider>

    <FlexContentDisplay :articles="opinionArticles" categoryName="Opinions" categorySlug="opinions"></FlexContentDisplay>

    <Divider></Divider>

    <HalfFullDisplay :catDetails="{'leftCatName':'Announcements','leftCatSlug':'announcements','leftCatArticles':announcementArticles,'rightCatName':'Events','rightCatSlug':'events','rightCatArticles':eventArticles}">
    </HalfFullDisplay>

    <Divider></Divider>

    <VideoSection :articles="videoArticles" categoryName="Videos" categorySlug="videos"></VideoSection>

    <Divider></Divider>

    <FullDisplay :articles="cultureArticles" categoryName="Culture" categorySlug="culture" :hasFooter=false></FullDisplay>

    <Divider></Divider>

    <FlexContentDisplay :articles="artArticles" categoryName="Arts" categorySlug="arts"></FlexContentDisplay>

    <Divider></Divider>

    <FullDisplay :articles="generationArticles" categoryName="Generations" categorySlug="generations" :hasFooter=false></FullDisplay>

    <Divider></Divider>

    <FlexContentDisplay :articles="lifestyleArticles" categoryName="Lifestyles" categorySlug="lifestyle"></FlexContentDisplay>

    <Divider></Divider>

    <FlexContentDisplay :articles="analysisArticles" categoryName="Analysis" categorySlug="analysis"></FlexContentDisplay>

    <div class="container mx-auto mb-5 h-[600px] lg:h-100" style=" background-size:top; background-repeat:none; background-size:cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-image: linear-gradient( rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7) ), url(https://beta.streamsoflife.sg/wp-content/uploads/2022/03/chris-karidis-7lSA8da0Qs8-unsplash-scaled.jpg);">
        <SectionHeader categoryName="Contribution" categorySlug="ontribution"></SectionHeader>
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
