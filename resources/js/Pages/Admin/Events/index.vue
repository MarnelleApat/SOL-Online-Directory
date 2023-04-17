<script setup>
    import { Head, useForm } from '@inertiajs/inertia-vue3';

    import AuthenticatedAdminLayout from '@/Layouts/Admin/AuthenticatedAdmin.vue';
    import currency from '@/Helpers/formatCurrency'
    import paginator from '@/Utilities/Paginator.vue'
    import toDate from '@/Helpers/StringToDate'

    import BreezeInput from '@/Components/Input.vue';

    import moment from 'moment';

    defineProps({
        events: {
            type: Object
        },
        errors: {
            type: Object
        },
    });

    const searchForm = useForm({
        keyword: route().params['keyword'] ? route().params['keyword'] : ''
    })

    const headerTitle = "Events - Admin Portal"

    // Submit keyword for searching result
    const searchEvent = () => {
        searchForm.get(route('admin.eventSearch'));
    }
</script>

<template>
    <Head>
        <title>
            {{ headerTitle }}
        </title>
    </Head>
    <AuthenticatedAdminLayout>
        <div id="admin-events" class="min-h-[670px]">
            <div class="flex mb-8 items-center">
                <form @submit.prevent="searchEvent()">
                    <label>
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <BreezeInput id="search" type="search" placeholder="Search Events" class="bg-white rounded-none w-[400px] text-gray-500 focus:ring-0" v-model="searchForm.keyword" required autocomplete="search" />
                    </label>
                    <small class="text-red-500 flex justify-end mt-1" v-if="errors.keyword">Please indicate keyword to search</small>
                </form>
            </div>
            <p v-if="route().params['keyword']" class="text-gray-800 text-xl mb-8">Search results for "<span class="italic font-bold">{{ route().params['keyword'] }}</span> "</p>
            <div v-if="!route().params['keyword']" class="flex justify-between mb-5 items-center">
                <h1 class="font-black uppercase text-xl text-gray-900">Event Records</h1>
                <a :href="route('admin.eventCreate')" class="bg-green-600 px-4 font-bold border border-white/40 py-3 text-xs leading-none text-white hover:bg-green-700 flex items-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    ADD NEW
                </a>
            </div>
            <div class="overflow-x-scroll">
                <table class="w-full whitespace-nowrap">
                    <thead class="bg-gray-800 border border-gray-800">
                        <th class="text-left py-3 px-2 text-sm font-black text-white">Code</th>
                        <th class="text-left py-3 px-2 text-sm font-black text-white">Title</th>
                        <th class="text-left py-3 px-2 text-sm font-black text-white">Category</th>
                        <th class="text-left py-3 px-2 text-sm font-black text-white">Date</th>
                        <th class="text-left py-3 px-2 text-sm font-black text-white">Type</th>
                        <th class="text-left py-3 px-2 text-sm font-black text-white">Price</th>
                        <th class="text-left py-3 px-2 text-sm font-black text-white">Status</th>
                        <th class="text-right py-3 px-2 text-sm font-black text-white">Actions</th>
                    </thead>
                    <template v-for="event in events.data" :key="event.id">
                        <tr class="border border-gray-400 hover:bg-gray-100 bg-white text-gray-500">
                            <td class="py-3 px-2">
                                <span class="text-sm font-black">{{ event.programCode }}</span>
                            </td>
                            <td class="py-3 px-2 font-bold">
                                <div class="inline-flex space-x-3 items-center">
                                    <img class="rounded-full w-8 h-8 object-cover shadow-md" :src="event.thumbnail" :alt="event.title">
                                    <span class="text-sm">{{ event.title }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-2">
                                <!-- {{ event.categories }} -->
                                <span v-if="event.categories.length" v-for="(cat, idx) in event.categories"
                                    class="rounded-full px-3 py-1 bg-gray-600 text-white border text-xs">
                                    {{ cat.name }}
                                </span>
                            </td>
                            <td class="py-3 px-2">
                                <span v-if="event.schedules.length" v-for="(sched, idx) in event.schedules" class="leading-none text-xs">
                                    <p v-if="event.schedules.length > 1" class="m-0 leading-none italic">Session {{idx+1}}:</p>
                                    {{toDate(sched.date, 'LL')}} <span class="text-[10px]">@</span> {{moment(sched.startTime, 'HH:mm').format('LT')}} - {{moment(sched.endTime, 'HH:mm').format('LT')}}
                                </span>
                                <p v-else class="leading-relaxed text-sm"> TBA</p>
                            </td>
                            <td class="py-3 px-2">
                                <span
                                    class="rounded-full px-3 py-1 text-white border text-xs uppercase"
                                    :class="{'bg-green-600': event.type==='Online', 'bg-yellow-600': event.type==='Physical', 'bg-violet-600': event.type==='Hybrid'}">
                                    {{ event.type }}
                                </span>
                            </td>
                            <td class="py-3 px-2 text-sm">
                                {{ event.price > 0 ? currency(event.price) : 'FREE' }}
                            </td>
                            <td class="py-3 px-2">
                                <span
                                    class="rounded-full px-3 py-1 text-white border text-xs uppercase"
                                    :class="{'bg-green-600': event.status==='Published', 'bg-blue-500': event.status==='Draft', 'bg-red-400': event.status==='Approval'}">
                                    {{ event.status }}
                                </span>
                            </td>
                            <td class="py-3 px-2 text-right">
                                <div class="inline-flex items-center space-x-3">
                                    <a :href="route('admin.eventProfile', event.slug)" title="View Page" class="hover:text-gray-400/60">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5` h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>
                                    <a href="#" title="Edit" class="hover:text-gray-400/60">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </template>
                </table>
            </div>
            <!-- <pre class="text-gray-900">{{ route().params['keyword'] }}</pre> -->
        </div>
        <paginator :isSearch='route().params["keyword"] ? `&keyword=${route().params["keyword"]}` : ""' :links="events.links" />
    </AuthenticatedAdminLayout>
</template>

<style scoped>
    label {
        display: grid;
        grid-template: 1fr / auto 1fr;
        /* gap: 12px; */
        border: 1px solid #CFD5DB;
        /* border-radius: 5px; */
        /* background: #fafafa; */
        /* padding: 12px; */
        color: #6C757D;
        cursor: text;
        background-color: #fff;
    }

    label svg {
        margin-top: 8px;
        opacity: 0.6;
        margin-left: 8px;
    }

    label:focus-within {
        border: 1px solid #000;
    }

    label>input {
        outline: none;
        border: none;
    }
</style>
