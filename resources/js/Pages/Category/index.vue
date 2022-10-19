<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

    defineProps({
        categories: Object
    });


</script>

<template>
    <Head title="Events" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Categories</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-4 gap-10">
                    <!-- card for ADD NEW -->
                    <a href="#" @click="isOpen=true">
                        <div class="group">
                            <div class="h-full w-full mx-auto bg-gray-200 hover:bg-gray-300 border shadow-sm sm:rounded-lg px-4 py-40 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-14 h-14 text-gray-400 group-hover:text-gray-100 font-black">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </div>
                        </div>
                    </a>

                    <div v-for="category in categories" class="min-h-[200px] w-full bg-white border shadow-sm sm:rounded-lg">
                        
                        <div class="p-6 ">
                            <div class="uppercase tracking-wide text-xs text-orange-500 hover:text-orange-300 font-bold">
                                <Link :href="route('category.view', category.slug)">
                                    {{category.name}}
                                </Link> . 
                            </div>
                            <Link :href="route('category.view', category.slug)" class="block mt-1 text-lg font-bold leading-tight text-gray-500 hover:text-gray-400 truncate ...">
                                {{category.description}}
                            </Link>
                        </div>
                    </div>

                </div>
                <paginator :links="categories.links" />
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
