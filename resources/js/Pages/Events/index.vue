<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
    import BreezeButton from '@/Components/Button.vue';
    import BreezeInput from '@/Components/Input.vue';
    import BreezeDropdown from '@/Components/Dropdown.vue';

    // Utilities
    import categories from '@/Utilities/Categories.vue'
    import paginator from '@/Utilities/Paginator.vue'

    // Helpers
    import toJSON from '@/Helpers/StringToJson'
    import toDate from '@/Helpers/StringToDate'
    import moment from 'moment'

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
                <div class="grid grid-cols-4 gap-8 mb-12">
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

                    <div v-for="event in events.data" class="w-full bg-white border shadow-sm sm:rounded-lg min-h-[460px] relative">
                        <div class="md:shrink-0">
                            <img class="object-cover h-48 w-full" :src="event.thumbnail" alt="Modern building architecture">
                        </div>
                        <div class="px-6 py-4 flex flex-col gap-2">
                            <div class="uppercase tracking-wide text-xs text-orange-500 hover:text-orange-300 font-bold leading-7">
                                <Link :href="route('partners.view', event.department.slug)">
                                    {{event.department.name}}
                                </Link>
                            </div>
                            <Link :href="route('event.profile', event.slug)" class="flex items-start capitalize text-lg font-bold leading-tight h-11 overflow-hidden text-ellipsis text-gray-500 hover:text-gray-400">
                                {{event.title}}
                            </Link>
                            <div>
                                <template v-if="event.schedules.length">
                                    <BreezeDropdown v-if="event.schedules.length>1" align="right" width="48">
                                        <template #trigger>
                                            <p class="text-slate-500 text-xs py-1 inline-flex">
                                                {{toDate(event.schedules[0].date, 'll')}} @ {{moment(event.schedules[0].startTime, 'HH:mm').format('LT')}}-{{moment(event.schedules[0].endTime, 'HH:mm').format('LT')}}
                                                <svg v-if="event.schedules.length > 1" class="h-5 w-5 cursor-pointer opacity-70" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </p>
                                        </template>

                                        <template #content>
                                            <template v-if="event.schedules.length > 1">
                                                <div class="w-72 bg-white border shadow-lg rounded-md p-3">
                                                    <template v-for="(schedule,indx) in event.schedules">
                                                        <div class="mb-2">
                                                            <p class="text-slate-500 text-sm leading-0 italic">Session {{indx+1}}</p>
                                                            <p class="text-slate-500 text-sm leading-0">
                                                                {{toDate(schedule.date, 'll')}} @ {{moment(schedule.startTime, 'HH:mm').format('LT')}}-{{moment(schedule.endTime, 'HH:mm').format('LT')}}
                                                            </p>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>
                                        </template>
                                    </BreezeDropdown>
                                    <p v-else class="text-slate-500 text-xs py-1 inline-flex">
                                        {{toDate(event.schedules[0].date, 'll')}} @ {{moment(event.schedules[0].startTime, 'HH:mm').format('LT')}}-{{moment(event.schedules[0].endTime, 'HH:mm').format('LT')}}
                                        <svg v-if="event.schedules.length > 1" class="h-5 w-5 cursor-pointer opacity-70" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </p>
                                </template>
                            </div>
                            <div class="flex flex-col">
                                <BreezeDropdown align="right" width="48">
                                    <template #trigger>
                                        <p class="text-white pl-2 pr-1 text-md inline-flex items-center rounded"
                                            :class="{'bg-green-500':event.type=='Online', 'bg-blue-500':event.type=='Physical', 'bg-amber-500':event.type=='Hybrid'}">
                                            {{event.type}}
                                            <svg class="h-5 w-5 cursor-pointer opacity-70" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </p>
                                    </template>

                                    <template #content>
                                        <div class="w-72 bg-white border shadow-lg rounded-md p-3">
                                            <div class="flex flex-col gap-5">
                                                <div v-if="event.type=='Online'">
                                                    <p class="text-slate-500 text-sm leading-none font-bold">Online Details</p>
                                                    <a :href="toJSON(event.venue).url" class="text-blue-500 text-md leading-0 pl-2">{{toJSON(event.venue).url}}</a>
                                                </div>
                                                <div v-else-if="event.type=='Physical'">
                                                    <p class="text-slate-500 text-sm leading-none font-bold">Venue:</p>
                                                    <p class="text-slate-500 text-md leading-0 pl-2">
                                                        {{toJSON(event.venue).location}} {{toJSON(event.venue).city}} {{toJSON(event.venue).postalcode}}
                                                    </p>
                                                </div>
                                                <template v-else>
                                                    <div>
                                                        <p class="text-slate-500 text-sm leading-none font-bold">Online Details</p>
                                                        <span class="text-slate-500 text-sm leading-none">URL:</span> <a :href="toJSON(event.venue).url" class="text-blue-500 text-md leading-0 pl-2">{{toJSON(event.venue).url}}</a>
                                                    </div>
                                                    <div>
                                                        <p class="text-slate-500 text-sm leading-none font-bold">Location Details</p>
                                                        <p class="text-slate-500 text-md leading-0 pl-2">
                                                            {{toJSON(event.venue).location}} {{toJSON(event.venue).city}} {{toJSON(event.venue).postalcode}}
                                                        </p>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </BreezeDropdown>
                            </div>
                        </div>
                        <!-- show categories of the event in encaptulated -->
                        <div class="px-3 py-4 absolute w-full bottom-0" v-if="event.categories.length">
                            <!-- <p class="text-xs italic text-gray-500 leading-6">Categories:</p> -->
                            <categories
                                :categories="event.categories"
                                styleClass="inline-flex bg-gray-800 hover:bg-gray-400 hover:text-gray-800 text-white text-xs rounded-full gap-4 mr-1 py-1 px-2 leading-none items-center" />
                        </div>
                    </div>
                </div>
                <paginator :links="events.links" />
                <!-- <pre>{{ events.links }}</pre> -->
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
