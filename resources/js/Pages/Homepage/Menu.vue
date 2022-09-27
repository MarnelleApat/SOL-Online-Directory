<script setup>
    import { onMounted, ref } from 'vue';

    import BreezeDropdown from '@/Components/Dropdown.vue';
    import BreezeInput from '@/Components/Input.vue';
    import BreezeNavLink from '@/Components/NavLink.vue';
    import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
    import BreezeDropdownLink from '@/Components/DropdownLink.vue';

    import { useForm } from '@inertiajs/inertia-vue3';

    defineProps({
        navLinks: {
            type: Array,
        },
    })

    const form = useForm({
        search: '',
    });

    const submit = () => {
        form.post(route('dashboard'));
    };

    const showingNavigationDropdown = ref(false);

</script>

<template>
    <div class="border-y border-gray-400">
        <!-- Primary Navigation Menu -->
        <div class="px-3 md:mx-auto lg:py-2 lg:px-0">
            <div class="flex justify-between">
                <!-- Search Dropdown -->
                <div v-if="!showingNavigationDropdown" class="hidden md:hidden lg:block md:mt-[9px] lg:mt-[3px]">
                    <BreezeDropdown align="left" width="64" :isSearchForm=true>
                        <template #trigger>
                            <button class="flex items-center focus:outline-none transition duration-150 ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </template>

                        <template #content>
                            <div class="w-64">
                                <form @submit.prevent="submit">
                                    <BreezeInput id="search" type="text" placeholder="Search anything..." class="block w-full rounded-none" v-model="form.search" required autofocus autocomplete="search" />
                                </form>
                            </div>
                        </template>

                    </BreezeDropdown>
                </div>

                    <!-- Navigation Links -->
                <div class="flex justify-evenly">
                    <div class="hidden space-x-8 sm:-my-px sm:flex md:-my-px md:hidden lg:block">
                        <template v-for="(menu, index) in navLinks" :key="menu.id">
                            <!-- <pre>{{navLinks}}</pre> -->
                            <BreezeNavLink v-if="menu.name==='Mission Stories'" class="uppercase text-gray-700 font-bold hover:text-orange-700" :href="route('PostByCategory', menu.slug)" :active="route().current('PostByCategory', menu.slug)">Mission</BreezeNavLink>
                            <BreezeNavLink v-if="menu.name==='Humanitarian'" class="uppercase text-gray-700 font-bold hover:text-orange-700" :href="route('PostByCategory', menu.slug)" :active="route().current('PostByCategory', menu.slug)">Humanitarian</BreezeNavLink>
                            <BreezeNavLink v-if="menu.name==='Theology'" class="uppercase text-gray-700 font-bold hover:text-orange-700" :href="route('PostByCategory', menu.slug)" :active="route().current('PostByCategory', menu.slug)">Theology</BreezeNavLink>
                            <BreezeNavLink v-if="menu.name==='Opinions'" class="uppercase text-gray-700 font-bold hover:text-orange-700" :href="route('PostByCategory', menu.slug)" :active="route().current('PostByCategory', menu.slug)">Opinions</BreezeNavLink>
                            <BreezeNavLink v-if="menu.name==='Announcements'" class="uppercase text-gray-700 font-bold hover:text-orange-700" :href="route('PostByCategory', menu.slug)" :active="route().current('PostByCategory', menu.slug)">Announcements</BreezeNavLink>
                            <BreezeNavLink v-if="menu.name==='Events'" class="uppercase text-gray-700 font-bold hover:text-orange-700" :href="route('PostByCategory', menu.slug)" :active="route().current('PostByCategory', menu.slug)">Events</BreezeNavLink>
                            <BreezeNavLink v-if="menu.name==='News'" class="uppercase text-gray-700 font-bold hover:text-orange-700" :href="route('PostByCategory', menu.slug)" :active="route().current('PostByCategory', menu.slug)">News</BreezeNavLink>
                        </template>
                        <template v-if="!$page.props.auth.user">
                            <BreezeNavLink class="uppercase text-gray-700 font-bold hover:text-orange-700" :href="route('login')"> Login</BreezeNavLink>
                            <!-- <BreezeNavLink class="uppercase text-gray-700 font-bold hover:text-orange-700" :href="route('register')"> Register</BreezeNavLink> -->
                        </template>
                    </div>

                    <!-- MORE BUTTON -> Settings Dropdown -->
                    <div class="hidden space-x-8 sm:flex sm:items-center md:hidden lg:block ml-8 lg:mt-[2px]">
                        <BreezeDropdown align="right" width="64">
                            <template #trigger>
                                <button class="flex items-center text-sm text-gray-700 font-bold hover:text-orange-700 focus:outline-none focus:text-orange-700 focus:border-orange-300 transition duration-150 ease-in-out">
                                    <div class="uppercase">More</div>
                                    <div class="">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </template>
                            <template #content>
                                <div class="flex flex-col p-3" style="background-color: rgba(255, 255, 255, 0.95)">
                                    <template v-for="(menu, index) in navLinks" :key="menu.id">
                                        <BreezeDropdownLink v-if="menu.name==='Videos'" class="uppercase leading-normal text-gray-700 font-bold hover:text-orange-700" :href="route('PostByCategory', menu.slug)">Videos</BreezeDropdownLink>
                                        <BreezeDropdownLink v-if="menu.name==='Culture'" class="uppercase leading-normal text-gray-700 font-bold hover:text-orange-700" :href="route('PostByCategory', menu.slug)">Culture</BreezeDropdownLink>
                                        <BreezeDropdownLink v-if="menu.name==='Arts'" class="uppercase leading-normal text-gray-700 font-bold hover:text-orange-700" :href="route('PostByCategory', menu.slug)">Arts</BreezeDropdownLink>
                                        <BreezeDropdownLink v-if="menu.name==='Generations'" class="uppercase leading-normal text-gray-700 font-bold hover:text-orange-700" :href="route('PostByCategory', menu.slug)">Generations</BreezeDropdownLink>
                                        <BreezeDropdownLink v-if="menu.name==='Lifestyle'" class="uppercase leading-normal text-gray-700 font-bold hover:text-orange-700" :href="route('PostByCategory', menu.slug)">Lifestyle</BreezeDropdownLink>
                                        <BreezeDropdownLink v-if="menu.name==='Analysis'" class="uppercase leading-normal text-gray-700 font-bold hover:text-orange-700" :href="route('PostByCategory', menu.slug)">Analysis</BreezeDropdownLink>
                                        <BreezeDropdownLink v-if="menu.name==='Contributions'" class="uppercase leading-normal text-gray-700 font-bold hover:text-orange-700" :href="route('PostByCategory', menu.slug)">Contributions</BreezeDropdownLink>
                                    </template>
                                    <BreezeDropdownLink class="uppercase leading-normal text-gray-700 font-bold hover:text-orange-700" href="https://traineeship.sreamsoflife.sg">Traineeship Programmes</BreezeDropdownLink>
                                    <BreezeDropdownLink v-if="$page.props.auth.user" class="uppercase leading-normal text-gray-700 font-bold hover:text-orange-700" :href="route('logout')" method="post" as="button">Log Out</BreezeDropdownLink>
                                </div>
                            </template>
                        </BreezeDropdown>
                    </div>
                </div>

                <!-- Social Media Icons -->
                <div class="hidden space-x-1 md:ml-2 md:-my-px md:hidden lg:block" style="margin-top: 2px;">
                    <button class="transition duration-150 ease-in-out" type="button" href="#">
                        <img src="/images/icons/fb.png" class="w-5">
                    </button>
                    <button class="transition duration-150 ease-in-out" type="button" href="#">
                        <img src="/images/icons/ig.png" class="w-5">
                    </button>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center md:items-end md:flex lg:hidden">
                    <button @click="showingNavigationDropdown = ! showingNavigationDropdown"
                    class="inline-flex items-center justify-center p-2 text-gray-400 hover:text-orange-700 focus:outline-none focus:text-gray-500 transition duration-300 ease-in-out">
                        <svg
                            class="h-6 w-6"
                            stroke="currentColor"
                            fill="none"
                            viewBox="0 0 24 24">
                            <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <transition name="slide-fade" style="background-color: rgba(0, 0, 0, 0.75)" class="h-full overflow-scroll md:overflow-hidden px-6">
            <div v-if="showingNavigationDropdown"
                class="fixed top-0 md:left-0 z-50 w-[290px] p-3 flex flex-col">
                <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-end justify-end p-2 text-white hover:text-orange-700 focus:outline-none focus:text-orange-700">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <form @submit.prevent="submit">
                    <BreezeInput id="search" type="text" placeholder="Search anything..." class="block w-full rounded-none text-gray-900 mb-3 mx-2" v-model="form.search" required autofocus autocomplete="search" />
                </form>
                <BreezeResponsiveNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase hover:text-orange-700" :href="route('PostByCategory', 'news')">News</BreezeResponsiveNavLink>
                <BreezeResponsiveNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase hover:text-orange-700" :href="route('PostByCategory', 'mission-stories')">Mission </BreezeResponsiveNavLink>
                <BreezeResponsiveNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase hover:text-orange-700" :href="route('PostByCategory', 'humanitarian')">Humanitarian </BreezeResponsiveNavLink>
                <BreezeResponsiveNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase hover:text-orange-700" :href="route('PostByCategory', 'theology')">Theology</BreezeResponsiveNavLink>
                <BreezeResponsiveNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase hover:text-orange-700" :href="route('PostByCategory', 'opinions')">Opinions</BreezeResponsiveNavLink>
                <BreezeResponsiveNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase hover:text-orange-700" :href="route('PostByCategory', 'announcements')">Announcements</BreezeResponsiveNavLink>
                <BreezeResponsiveNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase hover:text-orange-700" :href="route('PostByCategory', 'events')">Events</BreezeResponsiveNavLink>
                <BreezeResponsiveNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase hover:text-orange-700" :href="route('PostByCategory', 'videos')">Videos</BreezeResponsiveNavLink>
                <BreezeResponsiveNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase hover:text-orange-700" :href="route('PostByCategory', 'culture')">Culture</BreezeResponsiveNavLink>
                <BreezeResponsiveNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase hover:text-orange-700" :href="route('PostByCategory', 'arts')">Arts</BreezeResponsiveNavLink>
                <BreezeResponsiveNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase hover:text-orange-700" :href="route('PostByCategory', 'generations')">Generations</BreezeResponsiveNavLink>
                <BreezeResponsiveNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase hover:text-orange-700" :href="route('PostByCategory', 'lifestyle')">Lifestyle</BreezeResponsiveNavLink>
                <BreezeResponsiveNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase hover:text-orange-700" :href="route('PostByCategory', 'analysis')">Analysis</BreezeResponsiveNavLink>
                <BreezeResponsiveNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase hover:text-orange-700" :href="route('PostByCategory', 'contributions')">Contributions</BreezeResponsiveNavLink>
                <BreezeResponsiveNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase hover:text-orange-700" href="https://traineeship.sreamsoflife.sg">Traineeship Programmes</BreezeResponsiveNavLink>
                <BreezeResponsiveNavLink v-if="!$page.props.auth.user" class="text-white text-xs md:text-sm lg:text-sm uppercase hover:text-orange-700" :href="route('login')"> Login </BreezeResponsiveNavLink>
                <BreezeResponsiveNavLink v-else class="text-white text-xs md:text-sm lg:text-sm uppercase hover:text-orange-700" :href="route('logout')" method="post">Logout </BreezeResponsiveNavLink>
                <BreezeResponsiveNavLink>
                    <div class="space-x-1 flex justify-start">
                        <a href="#" class="transition duration-150 ease-in-out">
                            <img src="/images/icons/fb.png" class="w-5" style="filter: brightness(0) invert(1);">
                        </a>
                        <a href="#" class="transition duration-150 ease-in-out text-white">
                            <img src="/images/icons/ig.png" class="w-5" style="filter: brightness(0) invert(1);">
                        </a>
                    </div>
                </BreezeResponsiveNavLink>
            </div>
        </transition>

    </div>
</template>

<style>
    /* Enter and leave animations can use different */
    /* durations and timing functions.              */
    .slide-fade-enter-active {
        transition: all .3s ease;
    }
    .slide-fade-leave-active {
        transition: all .3s cubic-bezier(1.0, 1.0, 1.0, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
    /* .slide-fade-leave-active below version 2.1.8 */
    {
        transform: translateX(-20px);
        opacity: 0;
    }
</style>
