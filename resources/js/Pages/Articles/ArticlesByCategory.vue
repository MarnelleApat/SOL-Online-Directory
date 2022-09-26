<script>
    import { defineComponent } from 'vue'
    import Header from '@/Pages/Homepage/Header.vue';
    import Menu from '@/Pages/Homepage/Menu.vue';
    import Footer from '@/Pages/Homepage/Footer.vue';

    import moment from 'moment'

    export default defineComponent ({
        props: {
            category_name: {
                type: String
            },
            articles: {
                type: Object
            },
            navigationMenu: {
                type: Array
            }
        },
        components: {
            Header,
            Menu,
            Footer
        },
        methods: {

            getFeaturedImage(wp_post)
            {
                return 'https://via.placeholder.com/350x200?text=Streams+of+Life';

                if(! wp_post._embedded['wp:featuredmedia']) {
                    return 'https://via.placeholder.com/350x200?text=Streams+of+Life'
                }

                    return wp_post._embedded['wp:featuredmedia'][0].source_url;

            },
            dateTime(value) {
                return moment(value).format('MMMM DD, YYYY');
            },
        },
        mounted() {
            console.log(this.articles);
        }
    })


</script>

<template>
    <div class="container mx-auto">
        <Header></Header>
        <Menu :navLinks="navigationMenu"></Menu>
    </div>


    <div class="container mx-auto py-6">
        <h1 class="text-4xl font-bold text-gray-700 uppercase">{{ category_name }}</h1>
    </div>

    <div class="container mx-auto mb-5 px-3 md:px-2 lg:px-0">
        <!-- <div class="flex flex-clo-flow gap-5 md:flex-row md:gap-4"> -->
        <div class="grid gap-5 grid-flow-col grid-cols-2">


            <div v-for="article in articles">
                <!-- {{ article }} -->
                <div class="h-48">
                    <img class="w-full h-full" :src='getFeaturedImage(article)' alt="featured post in News category"/>
                </div>
                <h1 class="font-bold text-2xl md:text-xl my-2 md:mb-3 leading-tight focus:text-orange-700 hover:text-orange-500">
                    {{ article.title.rendered}}
                </h1>
                <div class="meta mb-3">
                    <!-- <p class="text-sm leading-0">Posted on <span class="text-red-800">{{ dateTime(article.date)}}</span></p> -->
                    <!-- <p class="text-sm leading-0">By <span class="text-red-800">{{ article._embedded.author[0].name}}</span></p> -->
                </div>
                <p class="leading-5 text-lg md:text-md">
                    {{ article.excerpt.rendered }}
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
