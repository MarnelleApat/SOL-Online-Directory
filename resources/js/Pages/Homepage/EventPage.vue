<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import toJSON from '@/Helpers/StringToJson'

    const props = defineProps(['event'])
    const event = props.event

    const headerTitle = event.title
    const themecolor = toJSON(event.specialSettings)[0].themeColor



</script>

<template>
    <Head :title="headerTitle" />

    <BreezeAuthenticatedLayout>
        <div class="p-5 h-[300px]" :style="{'background-color':themecolor}">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="text-gray-700 text-3xl">
                    {{headerTitle}}
                </h1>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        {{themecolor}}
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
