<script setup>
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import AuthenticatedAdminLayout from '@/Layouts/Admin/AuthenticatedAdmin.vue';
    import currency from '@/Helpers/formatCurrency'
    import toDate from '@/Helpers/StringToDate'
    import toJSON from '@/Helpers/StringToJson'
    import BreezeButton from '@/Components/Button.vue';
    import BreezeInput from '@/Components/Input.vue';
    import BreezeTextarea from '@/Components/Textarea.vue';
    import BreezeInputError from '@/Components/InputError.vue';
    import Multiselect from '@vueform/multiselect'
    import moment from 'moment';
    import { reactive, ref } from 'vue';

    const headerTitle = "Manage Event - Admin Portal"

    // Manually set the 2 types of event
    const eventType = ref([
        { value: "Physical", label: "Phyical" },
        { value: "Online", label: "Online" },
        { value: "Hybrid", label: "Hybrid" },
    ]);

    const _venue = toJSON(props.event.venue)

    //composition for physical event
    const venue = reactive({
        location: _venue.location,
        city: _venue.city,
        postalcode: _venue.postalcode,
        url: _venue.url,
        meetingID: _venue.meetingID,
        passcode: _venue.passcode
    })

    // init the required props
    const props = defineProps({
        errors: {
            type: Object
        },
        event: {
            type: Object,
            default: []
        },
        message: {
            type: String,
        }
    })

    // const eventData = useForm(props.event)
    const eventData = useForm({
        title: props.event.title,
        slug: props.event.slug,
        price: props.event.price,
        email: props.event.email,
        description: props.event.description,
        eventIncharge: props.event.eventIncharge,
        limit: props.event.limit,
        activeUntil: props.event.activeUntil,
        type: props.event.type,
        venue: venue
    })

    const updateEventForm = () => {
        console.log(eventData);
    }

</script>

<template>
    <Head>
        <title>
            {{ headerTitle }}
        </title>
    </Head>
    <AuthenticatedAdminLayout>

        <!-- <pre class="text-gray-700">{{ event }}</pre> -->

        <div id="admin-update-event">
            <p v-if="$page.props.flash.message" class="bg-green-500/20 rounded-md text-green-600 border border-green-600/30 px-4 py-8 mb-16 flex justify-between leading-relaxed">
                {{ $page.props.flash.message }}
                <div class="w-[20px] ml-10">
                    <svg @click="$page.props.flash.message = false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer text-green-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </p>

            <div id="event-profile-dashboard-card" class="grid gird-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-slate-500 border border-slate-600 p-10 rounded-lg shadow-lg">
                    <div class="flex flex-row space-x-4 items-center justify-center">
                        <div id="registrants-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-teal-300 text-sm font-bold uppercase leading-4">Total Registrants</p>
                            <p class="text-white font-bold text-2xl inline-flex items-center space-x-2">
                                <span>+28</span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                                    </svg>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-500 border border-slate-600 p-10 rounded-lg shadow-lg">
                    <div class="flex flex-row space-x-4 items-center justify-center">
                        <div id="events-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-teal-300 text-sm font-bold uppercase leading-4">Ticket Sales</p>
                            <p class="text-white font-bold text-2xl inline-flex items-center space-x-2">
                                <span>$25,000</span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                                    </svg>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-500 border border-slate-600 p-10 rounded-lg shadow-lg">
                    <div class="flex flex-row space-x-4 items-center justify-center">
                        <div>
                            <p class="text-teal-300 text-sm font-bold uppercase leading-4">Count Down</p>
                            <p class="text-white font-bold text-2xl inline-flex items-center space-x-2">
                                <span>10:10:30:50</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="flex flex-col">
                <div id="event-details" class="mt-10">
                    <!-- <pre class="text-red-600">{{ errors }}</pre> -->
                    <h1 class="font-bold py-4 text-2xl text-gray-500">Event Details</h1>
                    <form @submit.prevent="updateEventForm()">
                        <table class="w-full">
                            <tr class=" hover:bg-gray-600 bg-gray-700 text-white">
                                <td class="px-2 text-sm border border-gray-600 w-36">Title</td>
                                <td class="text-sm border border-gray-500">
                                    <BreezeInput type="text" required class="block placeholder-white/60 w-full rounded-none bg-gray-600 border-none" placeholder="Event Title" v-model="eventData.title" />
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-500 bg-gray-700 text-white">
                                <td class="px-2 text-sm border border-gray-600">Slug</td>
                                <td class="text-sm border border-gray-500">
                                    <div class="flex gap-4 justify-between pl-2 bg-gray-600">
                                        <a :href="`/event/${event.slug}`" target="_blank" class="text-blue-400 underline text-lg py-2">{{ eventData.slug }}</a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-500 bg-gray-700 text-white">
                                <td class="px-2 text-sm border border-gray-600">Price ($SGD)</td>
                                <td class="text-sm border border-gray-500">
                                    <BreezeInput type="number" min="0" step="0.01" required class="block placeholder-white/60 w-full rounded-none bg-gray-600 border-none" placeholder="Set 0 for FREE event" v-model="eventData.price" />
                                    <!-- <span>{{ event.price > 0 ? currency(event.price) : 'FREE' }}</span> -->
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-500 bg-gray-700 text-white">
                                <td class="px-2 text-sm border border-gray-600">Contact Email</td>
                                <td class="text-sm border border-gray-500">
                                    <BreezeInput type="email" required class="block placeholder-white/60 w-full rounded-none bg-gray-600 border-none" placeholder="Contact Email Address" v-model="eventData.email" />
                                </td>
                            </tr>
                            <tr class="bg-gray-700 text-white">
                                <td class="px-2 text-sm border border-gray-600">Desciption</td>
                                <td class="text-sm border border-gray-500">
                                    <BreezeTextarea id="desc" rows="6" :class="{ 'border-red-600':errors.description }" class="block placeholder-white/60 w-full rounded-none bg-gray-600 border-none" v-model="eventData.description" placeholder="Short Description" />
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-500 bg-gray-700 text-white">
                                <td class="px-2 text-sm border border-gray-600">Event Incharge</td>
                                <td class="text-sm border border-gray-500">
                                    <BreezeInput type="text" class="block placeholder-white/60 w-full rounded-none bg-gray-600 border-none" placeholder="Incharge of the event" v-model="eventData.eventIncharge" />
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-500 bg-gray-700 text-white">
                                <td class="px-2 text-sm border border-gray-600">Registration Limit</td>
                                <td class="text-sm border border-gray-500">
                                    <BreezeInput type="number" min="0" step="0.01" required class="block placeholder-white/60 w-full rounded-none bg-gray-600 border-none" placeholder="Registration Limit" v-model="eventData.limit" />
                                    <!-- <span>{{ event.price > 0 ? currency(event.price) : 'FREE' }}</span> -->
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-600 bg-gray-700 text-white">
                                <td class="px-2 text-sm border border-gray-600">Active Until</td>
                                <td class="text-sm border border-gray-500">
                                    <BreezeInput type="date" required class="block placeholder-white/60 text-white w-full rounded-none bg-gray-600 border-none" placeholder="Registration Limit" v-model="eventData.activeUntil" />
                                </td>
                            </tr>
                            <tr class="bg-gray-700 text-white">
                                <td class="px-2 text-sm border border-gray-600">Type</td>
                                <td class="text-sm border border-gray-600 bg-gray-600">
                                    <Multiselect required v-model="eventData.type"
                                        placeholder="Online or Physical Event"
                                        :options="eventType"
                                        style="color: #fff !important; background: none; border: none;"
                                        :class="{ 'multiselect_validation_err':errors.eventType }" />
                                </td>
                            </tr>
                            <tr class="bg-gray-700 text-white">
                                <td class="px-2 text-sm border border-gray-600">{{eventData.type=='Physical' ? 'Venue' : eventData.type=='Online' ? 'Online Details' : 'Venue & Online Details' }}</td>
                                <td class="text-sm border border-gray-600 bg-gray-600">
                                    <template v-if="eventData.type=='Physical' || eventData.type=='Hybrid'">
                                        <div class="flex flex-col">
                                            <BreezeInput id="venue" v-model="venue.location" type="text" class="block placeholder-white/70 w-full rounded-none bg-gray-600 border border-white/10" placeholder="Street / Block placeholder-white/70 / Bldg Address" />
                                        </div>

                                        <div class="flex">
                                            <BreezeInput v-model="venue.city" type="text" class="block placeholder-white/70 w-full rounded-none bg-gray-600 border border-white/10" placeholder="City" />
                                            <BreezeInput v-model="venue.postalcode" type="text" class="block placeholder-white/70 w-full rounded-none bg-gray-600 border border-white/10" min="0" placeholder="Postal Code" />
                                        </div>
                                    </template>
                                    <template v-if="eventData.type=='Online' || eventData.type=='Hybrid'">
                                        <div class="flex flex-col">
                                            <BreezeInput id="meetingLink" v-model="venue.url" type="text" class="block placeholder-white/70 w-full rounded-none bg-gray-600 border border-white/10" placeholder="Meeting URL (ex.https://zoom.sg)" />
                                        </div>
                                        <div class="flex">
                                            <BreezeInput v-model="venue.meetingID" type="text" class="block placeholder-white/70 w-full rounded-none bg-gray-600 border border-white/10" placeholder="Meeting ID" />
                                            <BreezeInput v-model="venue.passcode" type="text" class="block placeholder-white/70 w-full rounded-none bg-gray-600 border border-white/10" min="0" placeholder="Meeting Password" />
                                        </div>
                                    </template>

                                </td>
                            </tr>
                        </table>
                        <div class="flex justify-end">
                            <BreezeButton class="inline-block rounded-none mt-4 shadow-lg shadow-gray-900/30 font-bold text-[16px] py-3 px-12 bg-green-500 hover:bg-green-600 active:bg-green-600 focus:bg-green-600" :class="{ 'opacity-25': updateEventForm.processing }" :disabled="updateEventForm.processing">
                                SUBMIT
                            </BreezeButton>
                        </div>
                    </form>
                </div>
                <h1 class="font-bold pt-4 text-2xl text-gray-500">Other Details</h1>
                <hr class="mb-8 border border-gray-400/20"/>
                <div class="flex gap-4 justify-between mt-8">
                    <div id="event-schedules" class="w-1/2">
                        <div class="flex justify-between mb-1 items-center">
                            <h1 class="font-black uppercase text-md text-gray-800">Schedule(s)</h1>
                            <button class="bg-yellow-600 font-bold border border-white/40 p-2 text-sm leading-none text-white hover:bg-yellow-500/90 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                New Schedule
                            </button>
                        </div>
                        <table class="w-full">
                            <thead class="bg-gray-800 border border-gray-600">
                                <th class="text-left py-3 px-2 text-sm">Session</th>
                                <th class="text-left py-3 px-2 text-sm">Schedule</th>
                                <th class="text-right py-3 px-2 text-sm">&nbsp;</th>
                            </thead>
                            <tr v-if="event.schedules.length > 0" v-for="sched in event.schedules" class="bg-white text-gray-600 border border-gray-300">
                                <td class="py-3 px-2 text-sm w-36">Session 1</td>
                                <td class="py-3 px-2 text-sm">
                                    <div class="flex gap-4 justify-between">
                                        <div class="flex flex-col">
                                            <span v-if="event.schedules.length" v-for="(sched, idx) in event.schedules" class="leading-none">
                                                <p v-if="event.schedules.length > 1" class="m-0 leading-none italic">Session {{idx+1}}:</p>
                                                {{toDate(sched.date, 'LL')}} <span class="text-[10px]">@</span> {{moment(sched.startTime, 'HH:mm').format('LT')}} - {{moment(sched.endTime, 'HH:mm').format('LT')}}
                                            </span>
                                            <p v-else class="leading-relaxed text-sm"> TBA</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-2 text-sm">
                                    <a href="" title="Edit" class="hover:text-orange-500 flex justify-end">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            <tr v-else>
                                <td colspan="3"> <p class="italic text-gray-500">No record(s) found</p></td>
                            </tr>
                        </table>
                    </div>
                    <div id="event-speakers" class="w-1/2">
                        <div class="flex justify-between mb-1 items-center">
                            <h1 class="font-black uppercase text-xl text-gray-800">Speaker(s)</h1>
                            <button class="bg-yellow-600 p-2 font-bold border border-white/40 text-sm leading-none text-white hover:bg-yellow-500/90 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                New Speaker
                            </button>
                        </div>
                        <div class="overflow-x-scroll">
                            <table class="w-full whitespace-nowrap">
                                <thead class="bg-gray-800 border border-gray-600">
                                    <th class="text-left py-3 px-2 text-sm">Name</th>
                                    <th class="text-left py-3 px-2 text-sm">Email</th>
                                    <th class="text-left py-3 px-2 text-sm">Contact Number</th>
                                    <th class="text-right py-3 px-2 text-sm">&nbsp;</th>
                                </thead>
                                <tr v-if="event.speakers.length > 0" v-for="speaker in event.speakers" class="border border-gray-600 hover:bg-gray-600 bg-gray-700 text-white">
                                    <td class="py-2 px-4 font-bold text-sm">
                                        <div class="inline-flex space-x-3 items-center">
                                            <span>
                                                <img class="rounded-full w-8 h-8"
                                                    :src='speaker.profileImg ? speaker.profileImg : "https://via.placeholder.com/450x300?text=Sower+Institute"' />
                                            </span>
                                            <span>{{ speaker.name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-2 text-sm">{{ speaker.name }}</td>
                                    <td class="py-3 px-2 text-sm">{{ speaker.phoneNumber }}</td>
                                    <td class="py-3 px-2 text-sm text-right">
                                        <div class="inline-flex items-center space-x-3">
                                            <a href="" title="Edit" class="hover:text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                            <a href="#" title="Edit" class="hover:text-gray-400/80">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-else class="border border-gray-300 bg-white text-center">
                                    <td colspan="5"> <p class="italic text-gray-500 py-2">No record(s) found</p></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- <hr class="my-8 border border-gray-400/20"/> -->
                <div class="flex gap-4 justify-between mt-8">
                    <div id="event-promos" class="w-1/2">
                        <div class="flex justify-between mb-1 items-center">
                            <h1 class="font-black uppercase text-md text-gray-800">Promo(s)</h1>
                            <button class="bg-yellow-600 p-2 font-bold border border-white/40 text-sm leading-none text-white hover:bg-yellow-500/90 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                New Promo
                            </button>
                        </div>
                        <table class="w-full">
                            <thead class="bg-gray-800 border border-gray-600">
                                <th class="text-left py-3 px-2 text-sm font-black">Code</th>
                                <th class="text-left py-3 px-2 text-sm font-black">Discount</th>
                                <th class="text-left py-3 px-2 text-sm font-black">Validity</th>
                                <th class="text-left py-3 px-2 text-sm font-black">Quantity</th>
                                <th class="text-left py-3 px-2 text-sm font-black">Consumed</th>
                            </thead>
                            <tr v-if="event.promos.length > 0" v-for="promo in event.promos" class="hover:bg-gray-600 bg-gray-700 text-white">
                                <td class="py-3 px-2 text-sm border border-gray-600">EBP2023</td>
                                <td class="py-3 px-2 text-sm border border-gray-600">$80.00</td>
                                <td class="py-3 px-2 text-sm border border-gray-600">
                                    <span>February 30 - March 30, 2023</span>
                                </td>
                                <td class="py-3 px-2 text-sm border border-gray-600">1,000</td>
                                <td class="py-3 px-2 text-sm border border-gray-600">
                                    <div class="flex gap-4 justify-between">
                                        <span>100</span>
                                        <a href="" title="Edit" class="hover:text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr v-else class="border border-gray-300 bg-white text-center">
                                <td colspan="5"> <p class="italic text-gray-500 py-2">No record(s) found</p></td>
                            </tr>
                        </table>
                    </div>
                    <div id="event-media" class="w-1/2">
                        <div class="flex justify-between mb-1 items-center">
                            <h1 class="font-black uppercase text-md text-gray-800">Featured Image/Poster</h1>
                            <button class="bg-yellow-600 p-2 font-bold border border-white/40 text-sm leading-none text-white hover:bg-yellow-500/90 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Change Poster
                            </button>
                        </div>
                        <div class="overflow-x-scroll">
                            <table class="w-full">
                                <tr class="bg-gray-700 text-white">
                                    <!-- <td class="py-3 px-2 text-sm border border-gray-600 w-36">Banner</td> -->
                                    <td class="py-3 px-2 text-sm border border-gray-600">
                                        <div class="flex gap-4 justify-between">
                                            <span>
                                                <img class="w-18" src="https://images.generated.photos/tGiLEDiAbS6NdHAXAjCfpKoW05x2nq70NGmxjxzT5aU/rs:fit:256:256/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy92M18w/OTM4ODM1LmpwZw.jpg" alt="">
                                            </span>
                                            <a href="" title="Edit" class="hover:text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- <tr class="hover:bg-gray-600 bg-gray-700 text-white">
                                    <td class="py-3 px-2 text-sm border border-gray-600 w-36">Thumbnail</td>
                                    <td class="py-3 px-2 text-sm border border-gray-600">
                                        <div class="flex gap-4 justify-between">
                                            <span>
                                                <img class="w-10" src="https://images.generated.photos/tGiLEDiAbS6NdHAXAjCfpKoW05x2nq70NGmxjxzT5aU/rs:fit:256:256/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy92M18w/OTM4ODM1LmpwZw.jpg" alt="">
                                            </span>
                                            <a href="" title="Edit" class="hover:text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr> -->
                                <!-- <tr class="hover:bg-gray-600 bg-gray-700 text-white">
                                    <td class="py-3 px-2 text-sm border border-gray-600 w-36">Theme Color</td>
                                    <td class="py-3 px-2 text-sm border border-gray-600">
                                        <div class="flex gap-4 justify-between">
                                            <div class="w-10 h-10 bg-yellow-300 rounded-none border border-white/90"></div>
                                            <a href="" title="Edit" class="hover:text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr> -->
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedAdminLayout>
</template>
<style src="@vueform/multiselect/themes/default.css"></style>
<style>
    .multiselect-option {
        color: #000 !important;
    }
</style>
