<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

    import BreezeButton from '@/Components/Button.vue';
    import BreezeInput from '@/Components/Input.vue';

    import categories from '@/Utilities/Categories.vue'

    import moment from 'moment';

    defineProps({
        events: Object
    });

    const form = useForm({
        keyword: '',
    });

    const submit = () => {
        form.post(route('/'), {
            // onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };

    const jsonParser = (stringData) => {
        return JSON.parse(stringData);
    }

</script>

<template>
    <Head title="Events" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Events</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- searching feature -->
                <form @submit.prevent="submit" class="mb-8">
                    <div class="flex flex-cols">
                        <BreezeInput id="keyword" type="text" class="block w-full rounded-none" placeholder="Search Event" v-model="form.keyword" required autofocus autocomplete="keyword" />
                        <BreezeButton class="ml-4 py-1 rounded-none" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Search</BreezeButton>
                    </div>
                </form>

                <!-- <pre>{{ events.data[0] }}</pre> -->
                <!-- <pre>{{ events.links }}</pre> -->

                <div class="grid grid-cols-4 gap-10">
                    <!-- card for ADD NEW -->
                    <Link :href="route('events.create')">
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
                    </Link>

                    <div v-for="event in events.data" class="min-h-[200px] w-full bg-white border shadow-sm sm:rounded-lg">
                        <div class="md:shrink-0">
                            <img class="object-cover h-full w-full" :src="event.thumbnail" alt="Modern building architecture">
                        </div>
                        <div class="p-6">
                            <div class="uppercase tracking-wide text-xs text-orange-500 hover:text-orange-300 font-bold leading-7">
                                <Link :href="route('partner.profile', event.department.slug)">
                                    {{event.department.name}}
                                </Link>
                            </div>
                            <Link :href="route('event.profile', event.slug)" class="block mb-3 text-lg font-bold leading-none text-gray-500 hover:text-gray-400">
                                {{event.title}}
                            </Link>
                            <template v-for="schedule in jsonParser(event.schedule)">
                                <div class="flex mt-2">
                                    <p class="text-slate-500 text-sm leading-none font-bold">Date:</p>
                                    <p class="pl-1 text-slate-500 text-sm leading-none">{{moment(schedule.startDate).format('LL')}}</p>
                                </div>
                                <div class="flex mt-2">
                                    <p class="text-slate-500 text-sm leading-none font-bold">Time:</p>
                                    <p class="pl-1 text-slate-500 text-sm leading-none">{{schedule.startTime}} - {{schedule.endTime}}</p>
                                </div>
                            </template>
                            <div class="flex mt-2">
                                <p class="text-slate-500 text-sm leading-none font-bold">Venue:</p>
                                <p class=" pl-1 text-slate-500 text-sm leading-tight">
                                    {{jsonParser(event.venue).location}} {{jsonParser(event.venue).city}} {{jsonParser(event.venue).postalCode}}
                                </p>
                            </div>

                            <!-- show categories of the event in encaptulated -->
                            <div class="mt-6">
                                <categories v-if="event.categories.length" :categories="event.categories" />
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
