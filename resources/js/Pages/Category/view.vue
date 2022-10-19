<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

    defineProps({
        categories: Object
    });


</script>

<template>
    <Head title="Categories" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Categories</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-4 gap-10">
                    <!-- card for ADD NEW -->
                    {{ categories }}

                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
