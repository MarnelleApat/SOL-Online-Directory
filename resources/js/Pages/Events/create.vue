<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import BreezeButton from '@/Components/Button.vue';
    import BreezeInput from '@/Components/Input.vue';
    import BreezeTextarea from '@/Components/Textarea.vue';
    import BreezeInputError from '@/Components/InputError.vue';
    import BreezeLabel from '@/Components/Label.vue';
    import { reactive, ref } from 'vue';
    import SelectCategories from '@/Utilities/SelectCategories.vue'
    import { useStore } from 'vuex'
    import { computed } from '@vue/reactivity';
    const store = useStore()

    const getCat = computed(() => store.getters.getSelectedCategories)

    // init the required props
    defineProps({
        categories: {
            type: Object,
            required: true
        },
        departments: {
            type: Object,
            required: true
        }
    })

    // Manually set the 2 types of event
    const eventType = ref(["Physical", "Online"]);

    // separate declaration for event schedule
    let schedules = reactive([{startDate:'', startTime:'', endTime:''}]);

    // add schedule function
    const addSchedule = () => {
        schedules.push({startDate:'', startTime:'', endTime:''})
    }

    //remove schedule function
    const removeSchedule = (selected) => {
        let selectedIdx = schedules.indexOf(selected,0)
        schedules.splice(selectedIdx,1)
    }

    //composition for physical event
    const venue = reactive({
        location: null,
        city: null,
        postalcode: null
    })

    //composition for online event
    const online = reactive({
        url: null,
        meetingID: null,
        passcode: null
    })

    // the whole form models
    const eventForm = useForm({
        department: '',
        programCode: null,
        title: null,
        description: null,
        personIncharge: null,
        emailIncharge: null,
        registrationFee: null,
        validity: null,
        limitRegistration: null,
        checkHandler: null,
        eventType: '',
        schedules: null,
        venue: null,
        categories: getCat
    })

    // Process for submission of Event to the backend
    const eventSubmitForm = () => {
        // console.log(eventForm.data)
        // console.log(venue)
        // console.log(online)

        eventForm.post(route('event.store'));
    }

</script>

<template>
    <Head title="Create New Event" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Create New Event</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="eventSubmitForm">
                    <div class="flex flex-row gap-4">
                        <div class="w-1/4">
                            <div class="bg-white overflow-hidden shadow-sm border ring-opacity-75 cursor-pointer group mb-5">
                                <div class="flex justify-center px-4 py-32 items-center text-gray-400 uppercase text-lg font-bold group-hover:bg-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-10 h-10 text-gray-400 group-hover:text-gray-200 font-black">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    <span class="group-hover:text-gray-100">Upload Photo</span>
                                </div>
                            </div>

                            <!-- Select Category Component -->
                            <SelectCategories :categories="categories" />

                        </div>
                        <div class="w-3/4">
                            <div class="flex flex-col gap-4">
                                <div class="bg-white overflow-hidden shadow-sm border ring-opacity-75 cursor-pointer group">
                                    <div class="flex justify-center px-4 py-20 items-center text-gray-400 uppercase text-lg font-bold group-hover:bg-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="w-10 h-10 text-gray-400 group-hover:text-gray-200 font-black">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        <span class="group-hover:text-gray-100">Upload Banner</span>
                                    </div>
                                </div>
                                <div class="bg-white overflow-hidden shadow-sm border ring-opacity-75 p-4">
                                    <div class="flex flex-col p-6">
                                        <h5 class="font-bold text-xl text-gray-600 mb-6">Event Details</h5>

                                        <div class="flex flex-col gap-2">
                                            <BreezeLabel for="Department" value="Select Partners" class="flex items-center font-bold" />
                                            <select v-model="eventForm.department" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-none shadow-sm">
                                                <option value="" selected>Select Department</option>
                                                <option v-for="department in departments" :value="department.id">{{department.name}}</option>
                                            </select>
                                        </div>

                                        <div class="flex flex-col gap-2 mt-6">
                                            <BreezeLabel for="programCode" value="Program Code" class="flex items-center font-bold" />
                                            <BreezeInput id="programCode" v-model="eventForm.programCode" type="text" class="mt-1 block w-full rounded-none" placeholder="Unique Reference Code" />
                                            <BreezeInputError class="mt-2" />
                                        </div>

                                        <div class="flex flex-col gap-2 mt-6">
                                            <BreezeLabel for="title" value="Title" class="flex items-center font-bold" />
                                            <BreezeInput id="title" type="text" class="mt-1 block w-full rounded-none" v-model="eventForm.title" placeholder="Title" />
                                            <BreezeInputError class="mt-2" />
                                        </div>

                                        <div class="flex flex-col gap-2 mt-6">
                                            <BreezeLabel for="desc" value="Description" class="flex items-center font-bold" />
                                            <BreezeTextarea id="desc" rows="6" class="mt-1 block w-full rounded-none" v-model="eventForm.description" placeholder="About the event" />
                                            <BreezeInputError class="mt-2" />
                                        </div>

                                        <div class="flex gap-2 mt-6">
                                            <div class="w-5/12">
                                                <BreezeLabel for="eventIncharge" value="Person Incharge" class="flex items-center font-bold" />
                                                <BreezeInput id="eventIncharge" type="text" class="mt-1 block w-full rounded-none" v-model="eventForm.eventIncharge" placeholder="Contact Person" />
                                                <BreezeInputError class="mt-2" />
                                            </div>
                                            <div class="w-5/12">
                                                <BreezeLabel for="email" value="Email Incharge" class="flex items-center font-bold" />
                                                <BreezeInput id="email" type="email" class="mt-1 block w-full rounded-none" v-model="eventForm.email" placeholder="Event contact email" />
                                                <BreezeInputError class="mt-2" />
                                            </div>
                                            <div class="w-1/6">
                                                <BreezeLabel for="price" value="Price (in SGD)" class="flex items-center font-bold" />
                                                <BreezeInput id="price" type="number" step="0.01" class="mt-1 block w-full rounded-none" v-model="eventForm.price" placeholder="00.00" />
                                                <BreezeInputError class="mt-2" />
                                            </div>
                                        </div>


                                        <div class="flex gap-2 mt-6">
                                            <div class="w-1/4">
                                                <BreezeLabel for="validity" value="Validity" class="flex items-center font-bold" />
                                                <BreezeInput id="validity" v-model="eventForm.validity" type="date" class="mt-1 block w-full rounded-none" />
                                                <BreezeInputError class="mt-2" />
                                            </div>
                                            <div class="w-1/4">
                                                <BreezeLabel for="limit" value="Limit Regiration" class="flex items-center font-bold" />
                                                <BreezeInput id="limit" v-model="eventForm.limitRegistration" type="number" class="mt-1 block w-full rounded-none" min="0" placeholder="0 for no registration" />
                                                <BreezeInputError class="mt-2" />
                                            </div>

                                            <div class="w-1/2">
                                                <BreezeLabel for="checkHandler" value="Check Handler" class="flex items-center font-bold" />
                                                <BreezeInput id="checkHandler" v-model="eventForm.checkHandler" type="text" class="mt-1 block w-full rounded-none" min="0" placeholder="Name for check payment" />
                                                <BreezeInputError class="mt-2" />
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="bg-white overflow-hidden shadow-sm border ring-opacity-75 p-4">
                                    <div class="flex flex-col p-6">
                                        <div class="flex flex-col gap-2">
                                            <BreezeLabel for="type" value="Type of Event" class="flex items-center font-bold" />
                                            <select v-model="eventForm.eventType" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-none shadow-sm">
                                                <option value="" selected>Online/Physical</option>
                                                <option v-for="event_type in eventType" :value="event_type">{{event_type}}</option>
                                            </select>
                                        </div>
                                        <template v-if="eventForm.eventType=='Physical'">
                                            <div class="flex flex-col gap-2 mt-6">
                                                <BreezeLabel for="venue" value="Event Venue or Location" class="flex items-center font-bold" />
                                                <BreezeInput id="venue" v-model="venue.location" type="text" class="mt-1 block w-full rounded-none" placeholder="Street / Block / Bldg Address" />
                                                <BreezeInputError class="mt-2" />
                                            </div>

                                            <div class="flex gap-2 mt-2">
                                                <BreezeInput v-model="venue.city" ty pe="text" class="mt-1 block w-full rounded-none" placeholder="City" />
                                                <BreezeInputError class="mt-2" />
                                                <BreezeInput v-model="venue.postalcode" type="text" class="mt-1 block w-full rounded-none" min="0" placeholder="Postal Code" />
                                                <BreezeInputError class="mt-2" />
                                            </div>
                                        </template>
                                        <template v-if="eventForm.eventType=='Online'">
                                            <div class="flex flex-col gap-2 mt-6">
                                                <BreezeLabel for="meetingLink" value="Online Event Details" class="flex items-center font-bold" />
                                                <BreezeInput id="meetingLink" v-model="online.url" type="text" class="mt-1 block w-full rounded-none" placeholder="Meeting URL (ex.https://zoom.sg)" />
                                                <BreezeInputError class="mt-2" />
                                            </div>
                                            <div class="flex gap-2 mt-2">
                                                <BreezeInput v-model="online.meetingID" type="text" class="mt-1 block w-full rounded-none" placeholder="Meeting ID" />
                                                <BreezeInputError class="mt-2" />
                                                <BreezeInput v-model="online.passcode" type="text" class="mt-1 block w-full rounded-none" min="0" placeholder="Meeting Password" />
                                                <BreezeInputError class="mt-2" />
                                            </div>
                                        </template>

                                    </div>
                                </div>

                                <div class="bg-white overflow-hidden shadow-sm border ring-opacity-75 p-4">
                                    <div class="flex flex-col p-6">
                                        <div class="flex gap-2 justify-between mb-4">
                                            <h5 class="font-bold text-xl text-gray-600">Schedule Details</h5>
                                            <svg
                                                @click="addSchedule()"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                fill="currentColor"
                                                class="w-8 h-8 text-blue-500 hover:text-blue-400 cursor-pointer">
                                                <path fill-rule="evenodd"
                                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z"
                                                clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div v-for="(schedule, indx) in schedules" class="flex gap-3 my-3 items-end justify-between">
                                            <div class="w-full">
                                                <p v-if="schedules.length > 1">Session {{indx+1}}:</p>
                                                <p>Start Date</p>
                                                <BreezeInput type="date" class="w-full rounded-none" placeholder="Start Date" v-model="schedule.startDate" />
                                            </div>
                                            <div class="w-full">
                                                <p>Start Time</p>
                                                <BreezeInput type="time" class="w-full rounded-none" v-model="schedule.startTime" />
                                            </div>
                                            <div class="w-full">
                                                <p>End Time</p>
                                                <BreezeInput type="time" class="w-full rounded-none" v-model="schedule.endTime" />
                                            </div>
                                            <div class="pb-3">
                                                <svg v-if="indx > 0"
                                                    @click="removeSchedule(schedule)"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24"
                                                    fill="currentColor"
                                                    class="w-6 h-6 text-red-400 hover:text-red-600 cursor-pointer">
                                                    <path fill-rule="evenodd"
                                                    d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"
                                                    clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end mt-4">
                                <BreezeButton class="w-1/4 inline-block rounded-none text-lg font-semiblod py-3 px-4" :class="{ 'opacity-25': eventSubmitForm.processing }" :disabled="eventSubmitForm.processing">SUBMIT</BreezeButton>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
