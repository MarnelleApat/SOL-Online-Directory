<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import toJSON from '@/Helpers/StringToJson'
    import toDate from '@/Helpers/StringToDate'
    import categories from '@/Utilities/Categories.vue'
    import BreezeDropdown from '@/Components/Dropdown.vue';
    import BreezeButton from '@/Components/Button.vue';
    import currency from '@/Helpers/formatCurrency'
    import modal from '@/Utilities/MainModal.vue'
    import eventRegistration from '@/Pages/Customer/EventRegistration.vue'
    import moment from 'moment'
    import { ref } from 'vue';

    const props = defineProps(['event', 'loggedInUser'])
    const event = props.event

    const headerTitle = event.title
    const themecolor = toJSON(event.specialSettings)[0].themeColor
    const regForm = toJSON(event.specialSettings)[1].customFields

    const isOpen = ref(false)
    const openModal = (emittedValue) => {
        isOpen.value = emittedValue
    }
</script>

<template>
    <Head :title="headerTitle"></Head>

    <BreezeAuthenticatedLayout>
        <div class="p-5 min-h-[300px]" :style="{'background-color':themecolor}">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 py-5">
                <div class="flex justify-between">
                    <div class="flex flex-col gap-2 w-3/5">
                        <!-- categories -->
                        <categories :categories="event.categories" :styleClass="'bg-gray-800 border hover:bg-gray-400 hover:text-gray-800 text-white text-xs rounded-full mr-1 mb-1 py-1 px-2 inline-flex'" />
                        <!-- title -->
                        <div class="flex flex-col gap-3">
                            <h1 class="text-white text-4xl font-bold leading-10">{{headerTitle}}</h1>
                            <p class="text-white text-sm font-normal">
                                Hosted by:
                                <a :href="event.department.websiteUrl" class="text-white hover:text-blue-600 font-bold">
                                    {{event.department.name}}
                                </a>
                            </p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-baseline space-x-1 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 14" fill="currentColor">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                </svg>
                                <p class="text-sm font-semibold">20 registered <span class="italic">{{event.limit>0 ? '('+event.limit+' seats available)' : ''}}</span></p>
                            </div>
                            <div class="flex text-white items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 19" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>&nbsp;
                                <BreezeDropdown align='right' width="48">
                                    <template #trigger>
                                        <p class="text-gray-600 pl-2 pr-1 text-sm inline-flex items-center rounded-0 bg-white">
                                            {{event.type}} Event
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
                            <div class="flex items-center space-x-1 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 white-text fw-100 lh-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                <template v-if="event.schedules.length">
                                    <BreezeDropdown v-if="event.schedules.length>1" align="right" width="48">
                                        <template #trigger>
                                            <p class="text-sm inline-flex">
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
                                    <p v-else class="text-sm inline-flex">
                                        {{toDate(event.schedules[0].date, 'll')}} @ {{moment(event.schedules[0].startTime, 'HH:mm').format('LT')}}-{{moment(event.schedules[0].endTime, 'HH:mm').format('LT')}}
                                        <svg v-if="event.schedules.length > 1" class="h-5 w-5 cursor-pointer opacity-70" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </p>
                                </template>
                            </div>
                            <div class="mt-5 flex flex-col text-white">
                                <p class="text-sm text-white">Registration Fee:</p>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                    </svg>&nbsp;
                                    <span class="font-bold text-xl">{{currency(event.price)}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-2/5 relative">
                        <div class="min-h-[300px] absolute right-0 w-3/4">
                            <div class="flex flex-col gap-10">
                                <img class="w-full shadow-xl overflow-hidden border-4 border-gray-100" :src="event.banner ? event.banner : 'https://via.placeholder.com/300x500/FFFFFF/DDDDDD/?text=EVENT+POSTER'" />
                                <div class="flex flex-col gap-1">
                                    <!-- Registration Modal -->
                                    <modal :isOpen="isOpen" @open-modal="openModal">
                                        <template #openTriggerButton>
                                            <BreezeButton type="button" class="text-gray-100 bg-gray-600 hover:bg-gray-500 w-full rounded-none text-lg shadow-lg font-bold py-3 px-4">
                                                Register Now
                                            </BreezeButton>
                                        </template>
                                        <template #title>
                                        </template>
                                        <template #content>
                                            <eventRegistration :event="event" :customFields="regForm">
                                                <template #button>
                                                    <BreezeButton @click="isOpen=false" type="button" class="inline-flex justify-center uppercase rounded-sm border bg-gray-400 px-4 py-2 text-sm font-bold text-white hover:bg-gray-500">
                                                        Cancel
                                                    </BreezeButton>
                                                    <BreezeButton type="submit" class="inline-flex justify-center uppercase rounded-sm border border-gray-400 bg-gray-700 px-4 py-2 text-sm font-bold text-white hover:bg-gray-600">
                                                        Register & Proceed to Payment
                                                    </BreezeButton>
                                                </template>
                                            </eventRegistration>
                                        </template>
                                    </modal>
                                    <BreezeButton type="button" class="flex items-center justify-center gap-2 text-gray-100 bg-green-600 hover:bg-green-700 rounded-none text-lg shadow-lg font-bold py-3 px-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                        </svg>
                                        Add to Cart
                                    </BreezeButton>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-12 bg-white">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col gap-5">
                    <div class="flex justify-between min-h-[300px]">
                        <div class="flex flex-col gap-10 w-3/5">
                            <div>
                                <p class="text-gray-600 text-xl font-bold leading-10">Description:</p>
                                <p class="text-gray-600 text-md font-normal">{{event.description}}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-xl font-bold leading-10">Contact Details:</p>
                                <p class="text-gray-600 text-md font-normal">Event Incharge: {{event.eventIncharge}}</p>
                                <p class="text-gray-600 text-md font-normal">Email Address: {{event.email}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col" v-if="event.speakers">
                    <p class="text-gray-600 text-xl font-bold leading-10">About the Speaker(s):</p>
                    <div class="flex gap-5">
                        <template v-if="event.speakers.length <= 1">
                            <div class="flex w-full p-5 gap-3 h-[220px] overflow-hidden" :style="{'background-color':themecolor}">
                                <img :src="event.speakers[0].profileImg" class="h-30 mb-2" />
                                <div>
                                    <h1 class="font-bold text-2xl text-white">{{event.speakers[0].name}}</h1>
                                    <p class="font-normal text-white text-sm">
                                        {{event.speakers[0].description}}
                                    </p>
                                </div>
                            </div>
                        </template>
                        <div v-else class="grid grid-cols-5 gap-3">
                            <div class="flex flex-col justify-center items-center" v-for="(speaker, idx) in event.speakers" :key="idx">
                                <img :src="speaker.profileImg" class="rounded-full h-30 mb-2" />
                                <p class="font-bold text-gray-500 text-md">{{ speaker.name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>


