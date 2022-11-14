<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    defineProps({
        categories: Object
    })

</script>

<template>
    <div class="flex">
        <Link :href="route('events.create')">
            <span v-for="category in categories" class="bg-gray-800 hover:bg-gray-400 hover:text-gray-800 text-white text-xs rounded-full mr-1 mb-1 py-1 px-2 inline-flex">
                {{category.name}}
            </span>
        </Link>
    </div>
</template>
