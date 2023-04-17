
<script setup>
    import { Link } from "@inertiajs/inertia-vue3";

    defineProps({
        links: {
            type: Array
        },
        isSearch: {
            type: String
        }
    })
</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap mt-4">
            <template v-for="(link, key) in links" :key="key">
                <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-600 bg-gray-200 border border-gray-400 rounded shadow-md" v-html="link.label"></div>
                <Link v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-gray-400 text-gray-600 border-gray-400"
                    :class="{ 'bg-gray-500 text-white': link.active }"
                    :href="link.url+isSearch" v-html="link.label" />
            </template>
        </div>
    </div>
</template>
