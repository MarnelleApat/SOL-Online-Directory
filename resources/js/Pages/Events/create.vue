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
    import SelectSpeakers from '@/Utilities/SelectSpeakers.vue'
    import Scheduler from '@/Utilities/Scheduler.vue'
    import Multiselect from '@vueform/multiselect'
    import MediaDialog from '@/Utilities/MediaDialog.vue'

    // init the required props
    defineProps({
        errors: {
            type: Object
        },
        events: {
            type: Object,
            default: []
        },
        categories: {
            type: Object,
            required: true
        },
        departments: {
            type: Object,
            required: true
        },
        speakers: {
            type: Object,
            required: true
        }
    })

    // multiselect model
    const selectedDepartment = ref('')

    // holders of the emitted data from another components
    const getPhoto = ref('')
    const getBanner = ref('')
    const getSpeakers = ref('')
    const getCategories = ref('')

    // Manually set the 2 types of event
    const eventType = ref([
        {value: "Physical", label: "Phyical"},
        {value: "Online", label: "Online"},
        {value: "Hybrid", label: "Hybrid"},
    ]);

    // separate declaration for event schedule
    const schedules = ref([]);

    //composition for physical event
    const venue = reactive({
        location: null,
        city: null,
        postalcode: null,
        url: null,
        meetingID: null,
        passcode: null
    })

    // the whole form models
    const eventForm = useForm({
        department: selectedDepartment,
        programCode: null,
        title: null,
        description: null,
        personIncharge: null,
        emailIncharge: null,
        registrationFee: null,
        validity: null,
        limitReg: null,
        checkHandler: null,
        eventType: null,
        venue: venue,
        schedules: schedules,
        categories: getCategories,
        banner: getBanner,
        photoImg: getPhoto,
        speakers: getSpeakers
    })

    // Process for submission of Event to the backend
    const eventSubmitForm = () => {
        eventForm.post(route('event.store'));
    }

    // Emit (event) for Photo Image
    const getSeletedImage = (emitedImage) => {
        getPhoto.value = emitedImage
    }

    // Emit (event) for Banner
    const getSeletedBanner = (emitedBanner) => {
        getBanner.value = emitedBanner
    }

    // Emit (event) for Speakers
    const getSelectedSpeakers = (emitedSpeakers) => {
        getSpeakers.value = emitedSpeakers
    }

    // Emit (event) for Categories
    const getSelectedCategories = (emitedCategories) => {
        getCategories.value = emitedCategories
    }

    // Emit (event) for Schedules
    const getFinalSchedules = (emitedSchedules) => {
        schedules.value = emitedSchedules
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
                            <div class="bg-white overflow-hidden shadow-sm border-2 border-dashed ring-opacity-75 cursor-pointer group mb-5 relative h-56">
                                <MediaDialog @selected-image="getSeletedImage">
                                    <template #title>Select Profile Photo</template>
                                    <template #button>
                                        <img v-if="getPhoto.file_name" :src="getPhoto.file_name+getPhoto.slug" class="h-56 w-full absolute" />
                                        <div v-else class="absolute w-full flex justify-center h-56 items-center text-gray-400 uppercase text-lg font-bold group-hover:bg-gray-300">
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
                                    </template>
                                </MediaDialog>
                            </div>

                            <!-- Select Category Component -->
                            <div class="bg-white shadow-sm border ring-opacity-75">
                                <div class="flex flex-col p-5">
                                    <p class="text-gray-400 font-bold my-3">Categories:</p>
                                    <SelectCategories @selected-categories="getSelectedCategories" />
                                    <BreezeInputError :message="errors.categories" />
                                </div>
                            </div>
                        </div>
                        <div class="w-3/4">
                            <div class="flex flex-col gap-4">
                                <div class="bg-white shadow-sm border-2 border-dashed ring-opacity-75 cursor-pointer group relative h-56">
                                    <MediaDialog @selected-image="getSeletedBanner">
                                        <template #title>Select Banner Photo</template>
                                        <template #button>
                                            <img v-if="getBanner.file_name" :src="getBanner.file_name+getBanner.slug" class="h-56 w-full absolute" />
                                            <div v-else class="absolute flex justify-center w-full h-56 items-center text-gray-400 uppercase text-lg font-bold group-hover:bg-gray-300">
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
                                        </template>
                                    </MediaDialog>
                                </div>

                                <div class="bg-white overflow-hidden shadow-sm border ring-opacity-75 p-4">
                                    <div class="flex flex-col p-6">
                                        <h5 class="font-bold text-xl text-gray-600 mb-6">Event Details</h5>

                                        <div class="flex flex-col">
                                            <BreezeLabel for="Department" value="Partners" class="flex items-center font-bold" />
                                            <Multiselect required
                                                style="justify-content: flex-start;"
                                                v-model="selectedDepartment"
                                                value-prop="slug"
                                                placeholder="Select Partner"
                                                :close-on-select="true"
                                                :object="true"
                                                :options="departments"
                                                track-by="name"
                                                label="name"
                                                :class="{ 'multiselect_validation_err':errors.department }">

                                                <template v-slot:singlelabel="label">
                                                    <div class="multiselect-singleLabel">
                                                        {{ label.value.name }}
                                                    </div>
                                                </template>
                                            </Multiselect>
                                            <BreezeInputError :message="errors.department" />
                                        </div>

                                        <div class="flex flex-col mt-6">
                                            <BreezeLabel for="programCode" value="Program Code" class="flex items-center font-bold" />
                                            <BreezeInput required id="programCode" :class="{ 'border-red-600':errors.programCode }" v-model="eventForm.programCode" type="text" class="mt-1 block w-full rounded-none" placeholder="Unique Reference Code" />
                                            <BreezeInputError :message="errors.programCode" />
                                        </div>

                                        <div class="flex flex-col mt-6">
                                            <BreezeLabel for="title" value="Title" class="flex items-center font-bold" />
                                            <BreezeInput required id="title" type="text" :class="{ 'border-red-600':errors.title }" class="mt-1 block w-full rounded-none" v-model="eventForm.title" placeholder="Title" />
                                            <BreezeInputError :message="errors.title" />
                                        </div>

                                        <div class="flex flex-col mt-6">
                                            <BreezeLabel for="desc" value="Description" class="flex items-center font-bold" />
                                            <BreezeTextarea id="desc" rows="6" :class="{ 'border-red-600':errors.description }" class="mt-1 block w-full rounded-none" v-model="eventForm.description" placeholder="About the event" />
                                            <BreezeInputError :message="errors.description" />
                                        </div>

                                        <div class="flex gap-2 mt-6">
                                            <div class="w-5/12">
                                                <BreezeLabel for="eventIncharge" value="Person Incharge" class="flex items-center font-bold" />
                                                <BreezeInput required id="eventIncharge" :class="{ 'border-red-600':errors.personIncharge }" type="text" class="mt-1 block w-full rounded-none" v-model="eventForm.personIncharge" placeholder="Contact Person" />
                                                <BreezeInputError :message="errors.personIncharge" />
                                            </div>
                                            <div class="w-5/12">
                                                <BreezeLabel for="email" value="Email Incharge" class="flex items-center font-bold" />
                                                <BreezeInput required id="email" :class="{ 'border-red-600':errors.emailIncharge }" type="email" class="mt-1 block w-full rounded-none" v-model="eventForm.emailIncharge" placeholder="Event contact email" />
                                                <BreezeInputError :message="errors.emailIncharge" />
                                            </div>
                                            <div class="w-1/6">
                                                <BreezeLabel for="price" value="Price (in SGD)" class="flex items-center font-bold" />
                                                <BreezeInput required id="price" :class="{ 'border-red-600':errors.registrationFee }" type="number" step="0.01" class="mt-1 block w-full rounded-none" v-model="eventForm.registrationFee" placeholder="00.00" />
                                                <BreezeInputError :message="errors.registrationFee" />
                                            </div>
                                        </div>


                                        <div class="flex gap-2 mt-6">
                                            <div class="w-1/4">
                                                <BreezeLabel for="validity" value="Active Until" class="flex items-center font-bold" />
                                                <BreezeInput id="validity" v-model="eventForm.validity" type="date" class="mt-1 block w-full rounded-none" />
                                                <BreezeInputError class="mt-2" />
                                            </div>
                                            <div class="w-1/4">
                                                <BreezeLabel for="limit" value="Limit Registration" class="flex items-center font-bold" />
                                                <BreezeInput id="limit" v-model="eventForm.limitReg" type="number" class="mt-1 block w-full rounded-none" min="0" placeholder="0 for unlimited" />
                                                <BreezeInputError class="mt-2" />
                                            </div>

                                            <div class="w-1/2">
                                                <BreezeLabel for="checkHandler" value="Payee Name (For cheque payment)" class="flex items-center font-bold" />
                                                <BreezeInput id="checkHandler" v-model="eventForm.checkHandler" type="text" class="mt-1 block w-full rounded-none" min="0" placeholder="Name for check payment" />
                                                <BreezeInputError class="mt-2" />
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="bg-white shadow-sm border ring-opacity-75 p-4">
                                    <div class="flex flex-col p-6">
                                        <div class="flex flex-col gap-2">
                                            <BreezeLabel for="type" value="Type of Event" class="flex items-center font-bold" />
                                            <Multiselect
                                                required
                                                v-model="eventForm.eventType"
                                                placeholder="Online or Physical Event"
                                                :close-on-select="true"
                                                :options="eventType"
                                                :class="{ 'multiselect_validation_err':errors.eventType }" />
                                            <BreezeInputError :message="errors.eventType" />
                                        </div>
                                        <template v-if="eventForm.eventType=='Physical' || eventForm.eventType=='Hybrid'">
                                            <div class="flex flex-col gap-2 mt-6">
                                                <BreezeLabel for="venue" value="Event Venue or Location" class="flex items-center font-bold" />
                                                <BreezeInput required id="venue" v-model="venue.location" type="text" class="mt-1 block w-full rounded-none" placeholder="Street / Block / Bldg Address" />
                                                <BreezeInputError class="mt-2" />
                                            </div>

                                            <div class="flex gap-2 mt-2">
                                                <BreezeInput required v-model="venue.city" type="text" class="mt-1 block w-full rounded-none" placeholder="City" />
                                                <BreezeInputError class="mt-2" />
                                                <BreezeInput required v-model="venue.postalcode" type="text" class="mt-1 block w-full rounded-none" min="0" placeholder="Postal Code" />
                                                <BreezeInputError class="mt-2" />
                                            </div>
                                        </template>
                                        <template v-if="eventForm.eventType=='Online' || eventForm.eventType=='Hybrid'">
                                            <div class="flex flex-col gap-2 mt-6">
                                                <BreezeLabel for="meetingLink" value="Online Event Details" class="flex items-center font-bold" />
                                                <BreezeInput required id="meetingLink" v-model="venue.url" type="text" class="mt-1 block w-full rounded-none" placeholder="Meeting URL (ex.https://zoom.sg)" />
                                                <BreezeInputError class="mt-2" />
                                            </div>
                                            <div class="flex gap-2 mt-2">
                                                <BreezeInput required v-model="venue.meetingID" type="text" class="mt-1 block w-full rounded-none" placeholder="Meeting ID" />
                                                <BreezeInputError class="mt-2" />
                                                <BreezeInput required v-model="venue.passcode" type="text" class="mt-1 block w-full rounded-none" min="0" placeholder="Meeting Password" />
                                                <BreezeInputError class="mt-2" />
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <div class="bg-white overflow-hidden shadow-sm border ring-opacity-75 p-4">
                                    <BreezeInputError :message="errors.schedules" />
                                    <div class="p-6">
                                        <Scheduler @get-schedules="getFinalSchedules" />
                                    </div>
                                </div>

                                <div class="bg-white shadow-sm border ring-opacity-75 p-4">
                                    <div class="flex flex-col p-6">
                                        <h5 class="font-bold text-xl text-gray-600 mb-4">Speaker/s</h5>
                                        <!-- load speakers masterlist -->
                                        <BreezeInputError :message="errors.speakers" />
                                        <SelectSpeakers :speakers="speakers" @selected-speakers="getSelectedSpeakers" />
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-4">
                                <BreezeButton type="reset" class="text-gray-100 bg-gray-500 hover:bg-gray-400 inline-block rounded-none text-[15px] font-semibold py-3 px-4">RESET</BreezeButton>
                                <BreezeButton class="w-1/4 inline-block rounded-none text-[15px] font-semibold py-3 px-4" :class="{ 'opacity-25': eventSubmitForm.processing }" :disabled="eventSubmitForm.processing">SUBMIT</BreezeButton>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style>
    .multiselect-singleLabel {
        padding-block: 5px;
        padding-inline: 10px;
        border-radius: 22px;
        text-align: center;
        background: #35495e;
        color: #fff;
    }

    .multiselect_validation_err {
        border: 1px solid #dd4c4c !important;
    }

</style>
