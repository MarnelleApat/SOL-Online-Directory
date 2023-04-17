<script setup>
    import { defineComponent } from 'vue';
    import UserNavigation from './AuthUserNav.vue';
    import HomeFooter from '@/Pages/Homepage/HomeFooter.vue';

    defineComponent(() => {
        UserNavigation
    })
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">

            <!-- navigation -->
            <div class="fixed w-full z-10">
                <UserNavigation />
            </div>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main id="content" class="bg-white min-h-screen pt-24">
                <slot />
            </main>

            <!-- Footer Section -->
            <HomeFooter />
        </div>
    </div>
</template>
