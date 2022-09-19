<script setup>
    import { ref } from 'vue';

    import BreezeDropdown from '@/Components/Dropdown.vue';
    import BreezeInput from '@/Components/Input.vue';
    import BreezeNavLink from '@/Components/NavLink.vue';
    import BreezeDropdownLink from '@/Components/DropdownLink.vue';

    import { useForm } from '@inertiajs/inertia-vue3';

    defineProps({
        title: {
            type: String,
            default: ""
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
        <div class="px-3 md:px-0 md:mx-auto lg:py-2 lg:px-0">
            <div class="flex justify-evenly">
                <!-- Search Dropdown -->
                <div v-if="!showingNavigationDropdown" class="hidden sm:flex md:hidden lg:block w-10">
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
                <div class="hidden space-x-6 sm:-my-px sm:flex md:hidden md:-my-px md:flex lg:block">
                    <BreezeNavLink class="uppercase text-gray-700 font-bold hover:text-orange-700" :href="route('login')" :active="route().current('login')"> News</BreezeNavLink>
                    <BreezeNavLink class="uppercase text-gray-700 font-bold hover:text-orange-700" :href="route('login')" :active="route().current('login')"> Mission</BreezeNavLink>
                    <BreezeNavLink class="uppercase text-gray-700 font-bold hover:text-orange-700" :href="route('login')" :active="route().current('login')"> Humanitarian</BreezeNavLink>
                    <BreezeNavLink class="uppercase text-gray-700 font-bold hover:text-orange-700" :href="route('login')" :active="route().current('login')"> Theology</BreezeNavLink>
                    <BreezeNavLink class="uppercase text-gray-700 font-bold hover:text-orange-700" :href="route('login')" :active="route().current('login')"> Opinions</BreezeNavLink>
                    <BreezeNavLink class="uppercase text-gray-700 font-bold hover:text-orange-700" :href="route('login')" :active="route().current('login')"> Announcements</BreezeNavLink>
                    <BreezeNavLink class="uppercase text-gray-700 font-bold hover:text-orange-700" :href="route('login')" :active="route().current('dashboard')"> Events</BreezeNavLink>
                    <template v-if="!$page.props.auth.user">
                        <BreezeNavLink class="uppercase text-gray-700 font-bold hover:text-orange-700" :href="route('login')"> Login</BreezeNavLink>
                        <BreezeNavLink class="uppercase text-gray-700 font-bold hover:text-orange-700" :href="route('register')"> Register</BreezeNavLink>
                    </template>
                </div>

                <!-- MORE BUTTON -> Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center ml-2 md:ml-4 md:hidden lg:block" style="margin-top: 2px;">
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
                                <BreezeDropdownLink class="uppercase leading-normal text-gray-700 font-bold hover:text-orange-700" href="#">Videos</BreezeDropdownLink>
                                <BreezeDropdownLink class="uppercase leading-normal text-gray-700 font-bold hover:text-orange-700" href="#">Culture</BreezeDropdownLink>
                                <BreezeDropdownLink class="uppercase leading-normal text-gray-700 font-bold hover:text-orange-700" href="#">Arts</BreezeDropdownLink>
                                <BreezeDropdownLink class="uppercase leading-normal text-gray-700 font-bold hover:text-orange-700" href="#">Generations</BreezeDropdownLink>
                                <BreezeDropdownLink class="uppercase leading-normal text-gray-700 font-bold hover:text-orange-700" href="#">Lifestyle</BreezeDropdownLink>
                                <BreezeDropdownLink class="uppercase leading-normal text-gray-700 font-bold hover:text-orange-700" href="#">Analysis</BreezeDropdownLink>
                                <BreezeDropdownLink class="uppercase leading-normal text-gray-700 font-bold hover:text-orange-700" href="#">Contributions</BreezeDropdownLink>
                                <BreezeDropdownLink class="uppercase leading-normal text-gray-700 font-bold hover:text-orange-700" href="#">Traineeship Programmes</BreezeDropdownLink>
                                <BreezeDropdownLink v-if="$page.props.auth.user" class="uppercase leading-normal text-gray-700 font-bold hover:text-orange-700" :href="route('logout')" method="post" as="button">Log Out</BreezeDropdownLink>
                            </div>
                        </template>
                    </BreezeDropdown>
                </div>

                <!-- Social Media Icons -->
                <div class="hidden space-x-1 flex flex-col md:ml-2 md:hidden md:-my-px md:flex md:flex-col lg:block" style="margin-top: 2px;">
                    <button class="transition duration-150 ease-in-out" type="button" href="#">
                        <img src="/images/icons/fb.png" class="w-5">
                    </button>
                    <button class="transition duration-150 ease-in-out" type="button" href="#">
                        <img src="/images/icons/ig.png" class="w-5">
                    </button>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-end md:flex md:items-end sm:hidden lg:hidden">
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
        <div :class="{'block left-0': showingNavigationDropdown, 'hidden -left-80': ! showingNavigationDropdown}"
            style="background-color: rgba(0, 0, 0, 0.9)"
            class="fixed top-0 h-screen z-50 w-[250px] p-3 flex flex-col md:flex md:flex-col space-y-1 text-white transition duration-150 ease-in-out">
            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-end justify-end p-2 text-white hover:text-orange-700 focus:outline-none focus:text-orange-700">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <form @submit.prevent="submit">
                <BreezeInput id="search" type="text" placeholder="Search anything..." class="block w-full rounded-none text-gray-900 mb-3" v-model="form.search" required autofocus autocomplete="search" />
            </form>
            <BreezeNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase focus:text-white hover:text-orange-700" href="#">News</BreezeNavLink>
            <BreezeNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase focus:text-white hover:text-orange-700" href="#">Mission </BreezeNavLink>
            <BreezeNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase focus:text-white hover:text-orange-700" href="#">Humanitarian </BreezeNavLink>
            <BreezeNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase focus:text-white hover:text-orange-700" href="#">Theology</BreezeNavLink>
            <BreezeNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase focus:text-white hover:text-orange-700" href="#">Opinions</BreezeNavLink>
            <BreezeNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase focus:text-white hover:text-orange-700" href="#">Announcements</BreezeNavLink>
            <BreezeNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase focus:text-white hover:text-orange-700" href="#">Events</BreezeNavLink>
            <BreezeNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase focus:text-white hover:text-orange-700" href="#">Videos</BreezeNavLink>
            <BreezeNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase focus:text-white hover:text-orange-700" href="#">Culture</BreezeNavLink>
            <BreezeNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase focus:text-white hover:text-orange-700" href="#">Arts</BreezeNavLink>
            <BreezeNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase focus:text-white hover:text-orange-700" href="#">Generations</BreezeNavLink>
            <BreezeNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase focus:text-white hover:text-orange-700" href="#">Lifestyle</BreezeNavLink>
            <BreezeNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase focus:text-white hover:text-orange-700" href="#">Analysis</BreezeNavLink>
            <BreezeNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase focus:text-white hover:text-orange-700" href="#">Contributions</BreezeNavLink>
            <BreezeNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase focus:text-white hover:text-orange-700" href="#">Traineeship Programmes</BreezeNavLink>
            <BreezeNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase focus:text-white hover:text-orange-700" :href="route('login')"> Login </BreezeNavLink>
            <BreezeNavLink class="text-white text-xs md:text-sm lg:text-sm uppercase focus:text-white hover:text-orange-700" :href="route('register')">Register </BreezeNavLink>
            <BreezeNavLink :href="route('logout')" class="text-white text-xs md:text-sm lg:text-sm uppercase focus:text-white hover:text-orange-700" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</BreezeNavLink>
            <BreezeNavLink>
                <div class="space-x-1 flex justify-start">
                    <a href="#" class="transition duration-150 ease-in-out">
                        <img src="/images/icons/fb.png" class="w-5" style="filter: brightness(0) invert(1);">
                    </a>
                    <a href="#" class="transition duration-150 ease-in-out text-white">
                        <img src="/images/icons/ig.png" class="w-5" style="filter: brightness(0) invert(1);">
                    </a>
                </div>
            </BreezeNavLink>
        </div>


    </div>
</template>
