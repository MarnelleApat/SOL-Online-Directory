<script setup>
    import { ref } from 'vue';
    import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
    import BreezeDropdown from '@/Components/Dropdown.vue';
    import BreezeDropdownLink from '@/Components/DropdownLink.vue';
    import BreezeNavLink from '@/Components/NavLink.vue';
    import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
    import Cart from '@/Utilities/Cart.vue'
    import { Link } from '@inertiajs/inertia-vue3';

    const showingNavigationDropdown = ref(false);


    const toggleSlideover = () => {
        document.getElementById('slideover-container').classList.toggle('invisible');
        document.getElementById('slideover-bg').classList.toggle('opacity-0');
        document.getElementById('slideover-bg').classList.toggle('opacity-50');
        document.getElementById('slideover').classList.toggle('translate-x-full');
    }

</script>

<template>
    <nav class="bg-white border-b border-gray-100 shadow-lg">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto py-4 sm:py-4 md:py-4 lg:py-0 xl:py-0 px-4 sm:px-4 md:px-4 lg:px-0 xl:px-0">
            <div class="flex justify-between">
                <div class="flex">
                    <!-- Logo -->
                    <Link :href="route('Homepage')" class="shrink-0 flex items-center">
                        <BreezeApplicationLogo class="block h-10 w-auto" />

                        <h1 class="text-3xl font-bold text-gray-800 flex flex-col leading-none">
                            Streams Of Life
                            <small class="text-[12px] font-light text-gray-500">This is a test subtitle. this is sample only</small>
                        </h1>
                    </Link>
                </div>

                <div class="hidden sm:hidden md:hidden lg:flex xl:flex items-center">
                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:flex border-r-2">
                        <ul class="inline-flex">
                            <li class="py-6 px-5 hover:bg-gray-200/50 transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300" :class="{ 'bg-gray-100': route().current('user.dashboard')}">
                                <BreezeNavLink :href="route('user.dashboard')" :active="route().current('user.dashboard')" class="flex flex-col text-gray-700">
                                    <svg class="svg-icon w-8 h-8" viewBox="0 0 20 20">
                                        <path d="M18.121,9.88l-7.832-7.836c-0.155-0.158-0.428-0.155-0.584,0L1.842,9.913c-0.262,0.263-0.073,0.705,0.292,0.705h2.069v7.042c0,0.227,0.187,0.414,0.414,0.414h3.725c0.228,0,0.414-0.188,0.414-0.414v-3.313h2.483v3.313c0,0.227,0.187,0.414,0.413,0.414h3.726c0.229,0,0.414-0.188,0.414-0.414v-7.042h2.068h0.004C18.331,10.617,18.389,10.146,18.121,9.88 M14.963,17.245h-2.896v-3.313c0-0.229-0.186-0.415-0.414-0.415H8.342c-0.228,0-0.414,0.187-0.414,0.415v3.313H5.032v-6.628h9.931V17.245z M3.133,9.79l6.864-6.868l6.867,6.868H3.133z"></path>
                                    </svg>
                                    Home
                                </BreezeNavLink>
                            </li>
                            <li class="py-6 px-5 hover:bg-gray-200/50 transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300" :class="{ 'bg-gray-100': route().current('partners.index') || route().current('partners.create') || route().current('partners.view') || route().current('partners.search')}">
                                <BreezeNavLink class="flex flex-col text-gray-700" :href="route('partners.index')" :active="route().current('partners.index') || route().current('partners.create') || route().current('partners.view') || route().current('partners.search')">
                                    <svg class="svg-icon w-8 h-8" viewBox="0 0 20 20">
                                        <path d="M17.237,3.056H2.93c-0.694,0-1.263,0.568-1.263,1.263v8.837c0,0.694,0.568,1.263,1.263,1.263h4.629v0.879c-0.015,0.086-0.183,0.306-0.273,0.423c-0.223,0.293-0.455,0.592-0.293,0.92c0.07,0.139,0.226,0.303,0.577,0.303h4.819c0.208,0,0.696,0,0.862-0.379c0.162-0.37-0.124-0.682-0.374-0.955c-0.089-0.097-0.231-0.252-0.268-0.328v-0.862h4.629c0.694,0,1.263-0.568,1.263-1.263V4.319C18.5,3.625,17.932,3.056,17.237,3.056 M8.053,16.102C8.232,15.862,8.4,15.597,8.4,15.309v-0.89h3.366v0.89c0,0.303,0.211,0.562,0.419,0.793H8.053z M17.658,13.156c0,0.228-0.193,0.421-0.421,0.421H2.93c-0.228,0-0.421-0.193-0.421-0.421v-1.263h15.149V13.156z M17.658,11.052H2.509V4.319c0-0.228,0.193-0.421,0.421-0.421h14.308c0.228,0,0.421,0.193,0.421,0.421V11.052z"></path>
                                    </svg>
                                    Courses
                                </BreezeNavLink>
                            </li>
                            <li class="py-6 px-5 hover:bg-gray-200/50 transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300" :class="{ 'bg-gray-100': route().current('events.*') || route().current('event.*') || route().current('singleEvent.public') || route().current('register.guest')}">
                                <BreezeNavLink class="flex flex-col text-gray-700" :href="route('events.list')" :active="route().current('events.*') || route().current('event.*') || route().current('singleEvent.public') || route().current('register.guest')">
                                    <svg class="svg-icon w-8 h-8" viewBox="0 0 20 20">
                                        <path d="M16.557,4.467h-1.64v-0.82c0-0.225-0.183-0.41-0.409-0.41c-0.226,0-0.41,0.185-0.41,0.41v0.82H5.901v-0.82c0-0.225-0.185-0.41-0.41-0.41c-0.226,0-0.41,0.185-0.41,0.41v0.82H3.442c-0.904,0-1.64,0.735-1.64,1.639v9.017c0,0.904,0.736,1.64,1.64,1.64h13.114c0.904,0,1.64-0.735,1.64-1.64V6.106C18.196,5.203,17.461,4.467,16.557,4.467 M17.377,15.123c0,0.453-0.366,0.819-0.82,0.819H3.442c-0.453,0-0.82-0.366-0.82-0.819V8.976h14.754V15.123z M17.377,8.156H2.623V6.106c0-0.453,0.367-0.82,0.82-0.82h1.639v1.23c0,0.225,0.184,0.41,0.41,0.41c0.225,0,0.41-0.185,0.41-0.41v-1.23h8.196v1.23c0,0.225,0.185,0.41,0.41,0.41c0.227,0,0.409-0.185,0.409-0.41v-1.23h1.64c0.454,0,0.82,0.367,0.82,0.82V8.156z"></path>
                                    </svg>
                                    Events
                                </BreezeNavLink>
                            </li>
                            <li class="py-6 px-5 hover:bg-gray-200/50 transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300">
                                <BreezeNavLink class="flex flex-col text-gray-700" :href="route('registration.index')" :active="route().current('registration.*')">
                                    <svg class="svg-icon w-8 h-8" viewBox="0 0 20 20">
                                        <path d="M17.638,6.181h-3.844C13.581,4.273,11.963,2.786,10,2.786c-1.962,0-3.581,1.487-3.793,3.395H2.362c-0.233,0-0.424,0.191-0.424,0.424v10.184c0,0.232,0.191,0.424,0.424,0.424h15.276c0.234,0,0.425-0.191,0.425-0.424V6.605C18.062,6.372,17.872,6.181,17.638,6.181 M13.395,9.151c0.234,0,0.425,0.191,0.425,0.424S13.629,10,13.395,10c-0.232,0-0.424-0.191-0.424-0.424S13.162,9.151,13.395,9.151 M10,3.635c1.493,0,2.729,1.109,2.936,2.546H7.064C7.271,4.744,8.506,3.635,10,3.635 M6.605,9.151c0.233,0,0.424,0.191,0.424,0.424S6.838,10,6.605,10c-0.233,0-0.424-0.191-0.424-0.424S6.372,9.151,6.605,9.151 M17.214,16.365H2.786V7.029h3.395v1.347C5.687,8.552,5.332,9.021,5.332,9.575c0,0.703,0.571,1.273,1.273,1.273c0.702,0,1.273-0.57,1.273-1.273c0-0.554-0.354-1.023-0.849-1.199V7.029h5.941v1.347c-0.495,0.176-0.849,0.645-0.849,1.199c0,0.703,0.57,1.273,1.272,1.273s1.273-0.57,1.273-1.273c0-0.554-0.354-1.023-0.849-1.199V7.029h3.395V16.365z"></path>
                                    </svg>
                                    Our Partners
                                </BreezeNavLink>
                            </li>
                            <li class="py-6 px-5 hover:bg-gray-200/50 transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300">
                                <BreezeNavLink class="flex flex-col text-gray-700" :href="route('registration.index')" :active="route().current('registration.*')">
                                    <svg class="svg-icon w-8 h-8" viewBox="0 0 20 20">
                                        <path d="M8.627,7.885C8.499,8.388,7.873,8.101,8.13,8.177L4.12,7.143c-0.218-0.057-0.351-0.28-0.293-0.498c0.057-0.218,0.279-0.351,0.497-0.294l4.011,1.037C8.552,7.444,8.685,7.667,8.627,7.885 M8.334,10.123L4.323,9.086C4.105,9.031,3.883,9.162,3.826,9.38C3.769,9.598,3.901,9.82,4.12,9.877l4.01,1.037c-0.262-0.062,0.373,0.192,0.497-0.294C8.685,10.401,8.552,10.18,8.334,10.123 M7.131,12.507L4.323,11.78c-0.218-0.057-0.44,0.076-0.497,0.295c-0.057,0.218,0.075,0.439,0.293,0.495l2.809,0.726c-0.265-0.062,0.37,0.193,0.495-0.293C7.48,12.784,7.35,12.562,7.131,12.507M18.159,3.677v10.701c0,0.186-0.126,0.348-0.306,0.393l-7.755,1.948c-0.07,0.016-0.134,0.016-0.204,0l-7.748-1.948c-0.179-0.045-0.306-0.207-0.306-0.393V3.677c0-0.267,0.249-0.461,0.509-0.396l7.646,1.921l7.654-1.921C17.91,3.216,18.159,3.41,18.159,3.677 M9.589,5.939L2.656,4.203v9.857l6.933,1.737V5.939z M17.344,4.203l-6.939,1.736v9.859l6.939-1.737V4.203z M16.168,6.645c-0.058-0.218-0.279-0.351-0.498-0.294l-4.011,1.037c-0.218,0.057-0.351,0.28-0.293,0.498c0.128,0.503,0.755,0.216,0.498,0.292l4.009-1.034C16.092,7.085,16.225,6.863,16.168,6.645 M16.168,9.38c-0.058-0.218-0.279-0.349-0.498-0.294l-4.011,1.036c-0.218,0.057-0.351,0.279-0.293,0.498c0.124,0.486,0.759,0.232,0.498,0.294l4.009-1.037C16.092,9.82,16.225,9.598,16.168,9.38 M14.963,12.385c-0.055-0.219-0.276-0.35-0.495-0.294l-2.809,0.726c-0.218,0.056-0.351,0.279-0.293,0.496c0.127,0.506,0.755,0.218,0.498,0.293l2.807-0.723C14.89,12.825,15.021,12.603,14.963,12.385"></path>
                                    </svg>
                                    About Us
                                </BreezeNavLink>
                            </li>
                            <li class="py-6 px-5 hover:bg-gray-200/50 transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300">
                                <BreezeNavLink class="flex flex-col text-gray-700" :href="route('registration.index')" :active="route().current('registration.*')">
                                    <svg class="svg-icon w-8 h-8" viewBox="0 0 20 20">
                                        <path d="M17.283,5.549h-5.26V4.335c0-0.222-0.183-0.404-0.404-0.404H8.381c-0.222,0-0.404,0.182-0.404,0.404v1.214h-5.26c-0.223,0-0.405,0.182-0.405,0.405v9.71c0,0.223,0.182,0.405,0.405,0.405h14.566c0.223,0,0.404-0.183,0.404-0.405v-9.71C17.688,5.731,17.506,5.549,17.283,5.549 M8.786,4.74h2.428v0.809H8.786V4.74z M16.879,15.26H3.122v-4.046h5.665v1.201c0,0.223,0.182,0.404,0.405,0.404h1.618c0.222,0,0.405-0.182,0.405-0.404v-1.201h5.665V15.26z M9.595,9.583h0.81v2.428h-0.81V9.583zM16.879,10.405h-5.665V9.19c0-0.222-0.183-0.405-0.405-0.405H9.191c-0.223,0-0.405,0.183-0.405,0.405v1.215H3.122V6.358h13.757V10.405z"></path>
                                    </svg>
                                    Our Services
                                </BreezeNavLink>
                            </li>
                            <li class="py-6 px-5">
                                <div class="flex pt-3">
                                    <BreezeDropdown align="right" width="48" contentClasses="bg-white bg-opacity-80">
                                        <template #trigger>

                                            <div v-if="$page.props.auth.user" class="flex items-center gap-1">
                                                <div>
                                                    <img class="rounded-full w-7 h-7 object-cover" src="https://img.freepik.com/free-photo/no-problem-concept-bearded-man-makes-okay-gesture-has-everything-control-all-fine-gesture-wears-spectacles-jumper-poses-against-pink-wall-says-i-got-this-guarantees-something_273609-42817.jpg?w=1800&t=st=1669749937~exp=1669750537~hmac=4c5ab249387d44d91df18065e1e33956daab805bee4638c7fdbf83c73d62f125" alt="">
                                                </div>
                                                <div class="flex items-center cursor-pointer">
                                                    <!-- <p class="text-slate-400 text-sm mb-1 italic">Welcome back,</p> -->
                                                    <!-- <p class="font-medium leading-none">{{ $page.props.auth.user.niceName }}</p> -->
                                                    <!-- <span class="text-xs text-slate-400 leading-none">{{ $page.props.auth.user.email }}</span> -->
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>

                                            <div v-else class="flex items-center gap-1">
                                                <button class="border border-gray-500 transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300 shadow bg-transparent hover:bg-gray-100 py-2 px-2 rounded-none text-gray-700 text-md flex justify-between">
                                                    <span>Register Now</span>
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </template>

                                        <template #content>
                                            <template v-if="$page.props.auth.user">
                                                <BreezeDropdownLink :href="route('logout')" as="button" class="hover:bg-gray-100 bg-white">My Profile</BreezeDropdownLink>
                                                <BreezeDropdownLink :href="route('logout')" method="post" as="button" class="border-t hover:bg-gray-100 border-gray-200 bg-white">Log Out</BreezeDropdownLink>
                                            </template>
                                            <BreezeDropdownLink v-else :href="route('login')" as="button" class="hover:bg-gray-100 bg-white mt-1">Log In</BreezeDropdownLink>

                                        </template>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                            <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
                                        </svg>
                                    </BreezeDropdown>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="hidden space-x-8 sm:-my-px sm:flex">
                        <Cart />
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="flex sm:flex md:flex lg:hidden xl:hidden items-center">
                    <!-- <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300 inline-flex items-center justify-center p-4 rounded-none text-gray-600 hover:text-gray-500 focus:text-gray-500"> -->
                    <button @click="toggleSlideover" class="transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300 inline-flex items-center justify-center p-4 rounded-none text-gray-600 hover:text-gray-500 focus:text-gray-500">
                        <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- responsive menu - slide sidebar on mobile/tab view -->
        <div id="slideover-container" class="w-full h-full fixed inset-0 invisible">
            <div @click="toggleSlideover()" id="slideover-bg" class="w-full h-full duration-500 ease-out transition-all absolute bg-gray-900 opacity-0"></div>
            <div @click="toggleSlideover()" id="slideover" class="w-96 bg-white h-full absolute right-0 duration-300 ease-out transition-all translate-x-full">
                <div class="absolute cursor-pointer text-gray-600 top-0 w-8 h-8 flex items-center justify-center right-0 mt-5 mr-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>

                <ul class="mt-16">
                    <li class="py-6 px-5 hover:bg-gray-200/50 transition ease-in-out hover:-translate-y-1 hover:scale-100 duration-300 text-right"
                        :class="{ 'bg-gray-100': route().current('user.dashboard')}">
                        <BreezeNavLink
                            class="flex flex-col text-gray-700"
                            :href="!$page.props.auth.user ? route('Homepage') : route('checkout.index')">
                            <span class="text-xl uppercase hover:text-teal-700">{{ !$page.props.auth.user ? 'Home' : 'My Profile' }}</span>
                        </BreezeNavLink>
                    </li>
                    <li class="py-6 px-5 hover:bg-gray-200/50 transition ease-in-out hover:-translate-y-1 hover:scale-100 duration-300 text-right"
                        :class="{ 'bg-gray-100': route().current('partners.index') || route().current('partners.create') || route().current('partners.view') || route().current('partners.search')}">
                        <BreezeNavLink
                            class="flex flex-col text-gray-700"
                            :href="route('partners.index')"
                            :active="route().current('partners.index') || route().current('partners.create') || route().current('partners.view') || route().current('partners.search')">
                            <span class="text-xl uppercase hover:text-teal-700">Courses</span>
                        </BreezeNavLink>
                    </li>
                    <li class="py-6 px-5 hover:bg-gray-200/50 transition ease-in-out hover:-translate-y-1 hover:scale-100 duration-300 text-right"
                        :class="{ 'bg-gray-100': route().current('events.*') || route().current('event.*') || route().current('singleEvent.public') || route().current('register.guest')}">
                        <BreezeNavLink
                            class="flex flex-col text-gray-700"
                            :href="route('events.list')" :active="route().current('events.*') || route().current('event.*') || route().current('singleEvent.public') || route().current('register.guest')">
                            <span class="text-xl uppercase hover:text-teal-700">Events</span>
                        </BreezeNavLink>
                    </li>
                    <li class="py-6 px-5 hover:bg-gray-200/50 transition ease-in-out hover:-translate-y-1 hover:scale-100 duration-300 text-right">
                        <BreezeNavLink
                            class="flex flex-col text-gray-700"
                            :href="route('registration.index')" :active="route().current('registration.*')">
                            <span class="text-xl uppercase hover:text-teal-700">Our Partners</span>
                        </BreezeNavLink>
                    </li>
                    <li class="py-6 px-5 hover:bg-gray-200/50 transition ease-in-out hover:-translate-y-1 hover:scale-100 duration-300 text-right">
                        <BreezeNavLink
                            class="flex flex-col text-gray-700"
                            :href="route('registration.index')" :active="route().current('registration.*')">
                            <span class="text-xl uppercase hover:text-teal-700">About Us</span>
                        </BreezeNavLink>
                    </li>
                    <li class="py-6 px-5 hover:bg-gray-200/50 transition ease-in-out hover:-translate-y-1 hover:scale-100 duration-300 text-right">
                        <BreezeNavLink
                            class="flex flex-col text-gray-700"
                            :href="route('registration.index')" :active="route().current('registration.*')">
                            <span class="text-xl uppercase hover:text-teal-700">Our Services</span>
                        </BreezeNavLink>
                    </li>
                    <li class="py-6 px-5 hover:bg-gray-200/50 transition ease-in-out hover:-translate-y-1 hover:scale-100 duration-300 text-right">
                        <BreezeNavLink
                            class="flex flex-col text-gray-700"
                            :href="!$page.props.auth.user ? route('login') : route('logout')">
                            <span class="text-xl uppercase hover:text-teal-700">{{ !$page.props.auth.user ? 'Login' : 'Logout' }}</span>
                        </BreezeNavLink>

                    </li>
                    <li class="py-6 px-5 hover:bg-gray-200/50 transition ease-in-out hover:-translate-y-1 hover:scale-100 duration-300 text-right">
                        <BreezeNavLink
                            class="flex text-gray-700"
                            :href="route('checkout')">
                            <Cart />
                            <span class="text-xl uppercase hover:text-teal-700">Cart</span>
                        </BreezeNavLink>

                    </li>
                </ul>
            </div>
        </div>
    </nav>


</template>
