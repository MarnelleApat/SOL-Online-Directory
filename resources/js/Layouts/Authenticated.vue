<script setup>
    import { defineComponent } from 'vue';
    import AuthencatedNavigation from './AuthencatedNavigation.vue';

    defineComponent(() => {
        AuthencatedNavigation
    })
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">

            <!-- navigation -->
            <AuthencatedNavigation />

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
