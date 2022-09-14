<script setup>
    import { Link } from '@inertiajs/inertia-vue3';

    defineProps({
        categoryName: {
            type: String,
        },
        postTags: {
            type: Array,
            default: ['Singapore', 'Asia', 'World']
        }
    })

</script>

<template>
    <div class="container mx-auto mb-4 md:px-2 lg:px-0">
        <div class="text-center md:flex md:justify-between">
            <div class="flex flex-col items-center justify-center space-x-2 md:flex-row md:items-baseline">
                <h1 class="font-bold text-5xl md:text-3xl leading-none">{{ categoryName }}</h1>
                <div>
                    <Link class="text-gray-700 uppercase hover:text-orange-700 leading-3" href="#"> {{ postTags[0] }} </Link>
                    <Link class="text-gray-700 uppercase hover:text-orange-700 leading-3" href="#"> {{ postTags[1] }} </Link>
                    <Link class="text-gray-700 uppercase hover:text-orange-700 leading-3" href="#"> {{ postTags[2] }} </Link>
                </div>
            </div>
            <Link class="text-gray-700 my-2 hover:text-orange-700 leading-3 text-lg md:text-md"
                :href="route('login')" :active="route().current('login')">
                View All <span class="ml-1 text-xl">▸</span>
            </Link>
        </div>
    </div>
</template>
