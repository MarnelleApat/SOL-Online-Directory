<script setup>
    import AuthenticatedAdminLayout from '@/Layouts/Admin/AuthenticatedAdmin.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { reactive, ref } from 'vue';
    import BreezeButton from '@/Components/Button.vue';
    import BreezeInput from '@/Components/Input.vue';
    import BreezeTextarea from '@/Components/Textarea.vue';
    import BreezeInputError from '@/Components/InputError.vue';
    import BreezeLabel from '@/Components/Label.vue';
    import SelectCategories from '@/Utilities/SelectCategories.vue'
    import SelectSpeakers from '@/Utilities/SelectSpeakers.vue'
    import Scheduler from '@/Utilities/Scheduler.vue'
    import PaymentOption from '@/Utilities/PaymentMode.vue'
    import Multiselect from '@vueform/multiselect'
    import MediaDialog from '@/Utilities/MediaDialog.vue'

    import { createToaster } from '@meforma/vue-toaster'
    import spinner from '@/Utilities/Spinner.vue'

    const headerTitle = "Create New Event - Admin Portal"

    // init the required props
    defineProps({
        errors: {
            type: Object
        },
        events: {
            type: Object,
            default: []
        },
        partners: {
            type: Object,
            required: true
        }
    })

    const toaster = createToaster({
        dismissible: true,
        duration: 2500
    })

    // multiselect model
    const selectedPartner = ref('')

    // holders of the emitted data from another components
    const getPhoto = ref('')
    const getBanner = ref('')
    const getSpeakers = ref('')
    const getCategories = ref('')

    // Manually set the 2 types of event
    const eventType = ref([
        { value: "Physical", label: "Phyical" },
        { value: "Online", label: "Online" },
        { value: "Hybrid", label: "Hybrid" },
    ]);

    // separate declaration for event schedule
    const schedules = ref([]);


    // separate declaration for event payment mode
    const paymode = ref([]);

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
        partner: selectedPartner,
        programCode: 'TEST10', //null
        title: 'CFC Wold Conference', //null
        description: 'test cfc world conference description', //null
        personIncharge: 'Marnelle Apat', //null
        emailIncharge: 'marnelle24@gmail.com', //null
        registrationFee: '10', //null
        validity: null, //null
        limitReg: '1000', //null
        eventType: 'Physical', //null
        venue: venue,
        schedules: schedules,
        categories: getCategories,
        banner: getBanner,
        photoImg: getPhoto,
        speakers: getSpeakers,
        paymentMode: paymode,
        isSaveAsDraft: false
    })

    // Process for submission of Event to the backend
    const eventSubmitForm = () => {

        eventForm.post(route('event.store'), {
            // preserveScroll: true,
            onSuccess: () => {
                toaster.success('Event created successfully.')
            },
        });

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

     // Emit (event) for Payment Mode
     const getFinalPaymode = (emitedpayMode) => {
        paymode.value = emitedpayMode
    }


</script>

<template>
    <Head>
        <title>
            {{ headerTitle }}
        </title>
    </Head>
    <AuthenticatedAdminLayout>
        <!-- <div class="bg-black/30 w-screen h-screen fixed z-50 right-0 top-0 flex justify-center items-center">
            <spinner></spinner>
        </div> -->
        <div class="flex mb-8">
            <h1 class="font-black uppercase text-xl text-gray-900">Add New Event</h1>
        </div>
        <!-- <pre class="text-gray-900">{{ errors }}</pre> -->
        <progress v-if="eventSubmitForm.progress" :value="eventSubmitForm.progress.percentage" max="100">
            {{ eventSubmitForm.progress.percentage }}%
        </progress>

        <form @submit.prevent="eventSubmitForm">
            <div class="flex flex-col gap-4">
                <div>
                    <div class="flex flex-col gap-4">
                        <div class="flex gap-4">
                            <div class="w-1/4 flex flex-col gap-6">
                                <!-- Featured Poster -->
                                <div>
                                    <!-- <p class="text-gray-200 leading-1">Featured Image</p> -->
                                    <MediaDialog @selected-image="getSeletedBanner">
                                        <template #title>Select Photo</template>
                                        <template #button>
                                            <div class="shadow-sm border border-dashed border-gray-400 cursor-pointer group min-h-80 bg-white hover:bg-gray-50">
                                                <img v-if="getBanner.file_name" :src="getBanner.file_name+getBanner.slug" class="w-full object-cover" />
                                                <div v-else class="w-full flex justify-center items-center text-gray-400 uppercase text-lg font-bold h-80">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                        class="w-6 h-6 text-gray-400 font-black">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                                    </svg>
                                                    <span>Upload Poster</span>
                                                </div>
                                            </div>
                                        </template>
                                        </MediaDialog>
                                </div>
                                <!-- Select Category Component -->
                                <div class="shadow-md border-gray-500 ring-opacity-75">
                                    <div class="flex flex-col">
                                        <!-- <p class="text-gray-200 leading-1">Categories:</p> -->
                                        <SelectCategories @selected-categories="getSelectedCategories" />
                                        <BreezeInputError :message="errors.categories" />
                                        <button type="button" class="bg-green-700 hover:bg-green-600 inline text-sm uppercase leading-10 mt-2">Add New Category</button>
                                    </div>
                                </div>
                            </div>
                            <div class="w-3/4 flex flex-col gap-6 shadow-md border bg-white border-gray-400/60 p-6">
                                <div class="flex flex-col">
                                    <div class="flex flex-col">
                                        <BreezeLabel for="partner" value="Partners" class="flex items-center font-bold" />
                                        <Multiselect required
                                            style="justify-content: flex-start;padding-left: 15px;"
                                            v-model="selectedPartner"
                                            value-prop="slug"
                                            placeholder="Select Partner"
                                            :close-on-select="true"
                                            :object="true"
                                            :options="partners"
                                            track-by="name"
                                            label="name"
                                            :class="{ 'multiselect_validation_err':errors.partner }">

                                            <template v-slot:singlelabel="label">
                                                <div class="multiselect-singleLabel">
                                                    {{ label.value.name }}
                                                </div>
                                            </template>
                                        </Multiselect>
                                        <BreezeInputError :message="errors.partner" />
                                    </div>

                                    <div class="flex flex-col mt-6">
                                        <BreezeLabel for="programCode" value="Program Code" class="flex items-center font-bold" />
                                        <BreezeInput required id="programCode" :class="{ 'border-red-600':errors.programCode }" v-model="eventForm.programCode" type="text" class="mt-1 block w-full rounded-none text-gray-600" placeholder="Unique Reference Code" />
                                        <BreezeInputError :message="errors.programCode" />
                                    </div>

                                    <div class="flex flex-col mt-6">
                                        <BreezeLabel for="title" value="Title" class="flex items-center font-bold" />
                                        <BreezeInput required id="title" type="text" :class="{ 'border-red-600':errors.title }" class="text-gray-600 mt-1 block w-full rounded-none" v-model="eventForm.title" placeholder="Title" />
                                        <BreezeInputError :message="errors.title" />
                                    </div>

                                    <div class="flex flex-col mt-6">
                                        <BreezeLabel for="desc" value="Description" class="flex items-center font-bold" />
                                        <BreezeTextarea id="desc" rows="6" :class="{ 'border-red-600':errors.description }" class="text-gray-600 mt-1 block w-full rounded-none" v-model="eventForm.description" placeholder="About the event" />
                                        <BreezeInputError :message="errors.description" />
                                    </div>

                                    <div class="flex gap-2 mt-6">
                                        <div class="w-1/2">
                                            <BreezeLabel for="eventIncharge" value="Contact Person" class="flex items-center font-bold " />
                                            <BreezeInput required id="eventIncharge" :class="{ 'border-red-600':errors.personIncharge }" type="text" class=" mt-1 block w-full rounded-none text-gray-600" v-model="eventForm.personIncharge" placeholder="Contact Person" />
                                            <BreezeInputError :message="errors.personIncharge" />
                                        </div>
                                        <div class="w-1/2">
                                            <BreezeLabel for="email" value="Email Incharge" class="flex items-center font-bold " />
                                            <BreezeInput required id="email" :class="{ 'border-red-600':errors.emailIncharge }" type="email" class=" mt-1 block w-full rounded-none text-gray-600" v-model="eventForm.emailIncharge" placeholder="Event contact email" />
                                            <BreezeInputError :message="errors.emailIncharge" />
                                        </div>

                                    </div>
                                    <div class="flex gap-2 mt-6">
                                        <div class="w-1/3">
                                            <BreezeLabel for="validity" value="Validity" class="flex items-center font-bold" />
                                            <BreezeInput id="validity" v-model="eventForm.validity" type="date" class=" mt-1 block w-full rounded-none text-gray-600" />
                                            <BreezeInputError class="mt-2" />
                                        </div>
                                        <div class="w-1/3">
                                            <BreezeLabel for="limit" value="Limit Registration" class="flex items-center font-bold" />
                                            <BreezeInput id="limit" v-model="eventForm.limitReg" type="number" class=" mt-1 block w-full rounded-none text-gray-600" min="0" placeholder="0 for unlimited" />
                                            <BreezeInputError class="mt-2" />
                                        </div>
                                        <div class="w-1/3">
                                            <BreezeLabel for="price" value="Price (in SGD)" class="flex items-center font-bold" />
                                            <BreezeInput required id="price" :class="{ 'border-red-600':errors.registrationFee }" type="number" step="0.01" class=" mt-1 block w-full rounded-none text-gray-600" v-model="eventForm.registrationFee" placeholder="00.00" />
                                            <BreezeInputError :message="errors.registrationFee" />
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col">
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
                                            <BreezeInput required id="venue" v-model="venue.location" type="text" class="mt-1 block w-full rounded-none text-gray-600" placeholder="Street / Block / Bldg Address" />
                                            <BreezeInputError class="mt-2" />
                                        </div>

                                        <div class="flex gap-2 mt-2">
                                            <BreezeInput required v-model="venue.city" type="text" class="mt-1 block w-full rounded-none text-gray-600" placeholder="City" />
                                            <BreezeInputError class="mt-2" />
                                            <BreezeInput required v-model="venue.postalcode" type="text" class="mt-1 block w-full rounded-none text-gray-600" min="0" placeholder="Postal Code" />
                                            <BreezeInputError class="mt-2" />
                                        </div>
                                    </template>
                                    <template v-if="eventForm.eventType=='Online' || eventForm.eventType=='Hybrid'">
                                        <div class="flex flex-col gap-2 mt-6">
                                            <BreezeLabel for="meetingLink" value="Online Event Details" class="flex items-center" />
                                            <BreezeInput required id="meetingLink" v-model="venue.url" type="text" class="mt-1 block w-full rounded-none text-gray-600" placeholder="Meeting URL (ex.https://zoom.sg)" />
                                            <BreezeInputError class="mt-2" />
                                        </div>
                                        <div class="flex gap-2 mt-2">
                                            <BreezeInput required v-model="venue.meetingID" type="text" class="mt-1 block w-full rounded-none text-gray-600" placeholder="Meeting ID" />
                                            <BreezeInputError class="mt-2" />
                                            <BreezeInput required v-model="venue.passcode" type="text" class="mt-1 block w-full rounded-none text-gray-600" min="0" placeholder="Meeting Password" />
                                            <BreezeInputError class="mt-2" />
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-1/4"></div>
                            <div class="w-3/4 bg-white border border-gray-400/60 p-6 shadow-md">
                                <div>
                                    <BreezeInputError :message="errors.schedules" />
                                    <Scheduler :getSchedules="[]" @get-schedules="getFinalSchedules" />
                                </div>
                                <div></div>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-1/4"></div>
                            <div class="w-3/4 bg-white border border-gray-400/60 p-6 shadow-md">
                                <div class="flex flex-col">
                                    <h5 class="font-bold text-md text-gray-600 mb-4">Speaker/s</h5>
                                    <!-- load speakers masterlist -->
                                    <BreezeInputError :message="errors.speakers" />
                                    <SelectSpeakers @selected-speakers="getSelectedSpeakers" />
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-1/4"></div>
                            <div class="w-3/4 bg-white border border-gray-400/60 p-6 shadow-md">
                                <div>
                                    <BreezeInputError :message="errors.schedules" />
                                    <PaymentOption :getPaymentMode="[]" @get-payment-mode="getFinalPaymode" />
                                </div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-end gap-4 mt-4">
                        <BreezeButton type="reset" class="text-gray-100 bg-gray-500 hover:bg-gray-600 inline-block shadow-lg shadow-gray-900/30 rounded-none text-lg font-semibold py-3 px-8">RESET</BreezeButton>
                        <BreezeButton @click="eventForm.isSaveAsDraft = true" class="inline-block rounded-none text-lg shadow-lg shadow-gray-900/30 font-bold py-3 px-6 bg-blue-500 hover:bg-blue-600/90" :class="{ 'opacity-25': eventSubmitForm.processing }" :disabled="eventSubmitForm.processing">Save as draft</BreezeButton>
                        <BreezeButton @click="eventForm.isSaveAsDraft = false" class="inline-block rounded-none text-lg shadow-lg shadow-gray-900/30 font-bold py-3 px-6 bg-green-500 hover:bg-green-700" :class="{ 'opacity-25': eventSubmitForm.processing }" :disabled="eventSubmitForm.processing">SUBMIT</BreezeButton>
                    </div>
                </div>
            </div>
        </form>

    </AuthenticatedAdminLayout>
</template>

<style>
    .multiselect-option {
        color: #000 !important;
    }
</style>
