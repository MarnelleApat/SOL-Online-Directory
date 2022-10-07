<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head } from '@inertiajs/inertia-vue3';

    import BreezeInput from '@/Components/Input.vue';
    import BreezeTextarea from '@/Components/Textarea.vue';
    import BreezeInputError from '@/Components/InputError.vue';
    import BreezeLabel from '@/Components/Label.vue';

    defineProps({
        event: Object
    })

</script>

<template>
    <Head title="Event Profile" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Event Profile</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- <pre>{{event}}</pre> -->

                <div class="flex flex-row gap-4">
                    <div class="w-1/4">
                        <div class="bg-white overflow-hidden shadow-sm border ring-opacity-75 cursor-pointer group">
                            <div class="flex justify-center px-4 py-32 items-center text-gray-300 uppercase text-lg font-bold group-hover:bg-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-10 h-10 text-gray-300 group-hover:text-gray-100 font-black">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span class="group-hover:text-gray-100">Upload Photo</span>
                            </div>
                        </div>
                    </div>
                    <div class="w-3/4">
                        <div class="flex flex-col gap-4">
                            <div class="bg-white overflow-hidden shadow-sm border ring-opacity-75 cursor-pointer group">
                                <div class="flex justify-center px-4 py-20 items-center text-gray-300 uppercase text-lg font-bold group-hover:bg-gray-200">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-10 h-10 text-gray-300 group-hover:text-gray-100 font-black">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    <span class="group-hover:text-gray-100">Upload Banner</span>
                                </div>
                            </div>
                            <div class="bg-white overflow-hidden shadow-sm border ring-opacity-75p-4">
                                <div class="flex flex-col px-6 py-12">
                                    <div class="flex flex-col gap-2">
                                        <BreezeLabel for="title" value="Title" class="flex items-center" />
                                        <BreezeInput id="title" type="text" v-model="event.title" class="mt-1 block w-full rounded-none" required autocomplete="title" />
                                        <BreezeInputError class="mt-2" />
                                    </div>

                                    <div class="flex flex-col gap-2 mt-10">
                                        <BreezeLabel for="desc" value="Description" class="flex items-center" />
                                        <BreezeTextarea id="desc" rows="6" v-model="event.description" class="mt-1 block w-full rounded-none" required autocomplete="desc" />
                                        <BreezeInputError class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
