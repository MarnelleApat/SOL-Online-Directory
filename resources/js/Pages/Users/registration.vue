<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import BreezeButton from '@/Components/Button.vue';
    import BreezeInput from '@/Components/Input.vue';

    // Utilities
    import paginator from '@/Utilities/Paginator.vue'

    // Helpers
    import toJSON from '@/Helpers/StringToJson'
    import toDate from '@/Helpers/StringToDate'

    defineProps({
        events: Object
    });

    const form = useForm({
        keyword: '',
    });

</script>

<template>
    <Head title="Events" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Registration</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- searching feature -->
                <form @submit.prevent="submit" class="mb-8">
                    <div class="flex flex-cols">
                        <BreezeInput id="keyword" type="text" class="block w-full rounded-none" placeholder="Search registrants" v-model="form.keyword" required autofocus autocomplete="keyword" />
                        <BreezeButton class="ml-4 py-1 rounded-none" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Search</BreezeButton>
                    </div>
                </form>
                <div class="flex flex-col">
                    <div class="w-full bg-white border shadow-sm sm:rounded-lg">
                        <div class="p-12">
                            <h1>Hello world</h1>
                        </div>
                    </div>
                </div>
                <!-- <paginator :links="events.links" /> -->
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
