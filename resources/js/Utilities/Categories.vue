<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    import { computed } from '@vue/reactivity';

    const props = defineProps(['categories', 'styleClass'])

    const classes = computed(() => props.styleClass ? props.styleClass : 'bg-gray-800 hover:bg-gray-400 hover:text-gray-800 text-white text-xs rounded-full mr-1 mb-1 px-2 leading-none flex items-center'
);

</script>

<template>
    <div class="flex-wrap">
        <span v-for="category in props.categories" :class="classes">
            <Link :href="route('category.view', category.slug)">
                {{category.name}}
            </Link>
        </span>
    </div>
</template>
