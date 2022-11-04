<script setup>
    import { onMounted, reactive, ref } from 'vue'
    import BreezeInput from '@/Components/Input.vue';
    import { createToaster } from '@meforma/vue-toaster'
    import BreezeTextarea from '@/Components/Textarea.vue';
    import Scheduler from '@/Utilities/Scheduler.vue'
    import SelectCategories from '@/Utilities/SelectCategories.vue'
    import SelectSpeakers from '@/Utilities/SelectSpeakers.vue'
    import EventType from '@/Utilities/EventType.vue'
    import MainModal from '@/Utilities/MainModal.vue'
    import { useForm } from '@inertiajs/inertia-vue3';
    import { Inertia } from '@inertiajs/inertia';

    const toaster = createToaster({
            dismissible: true
        })

    const emit = defineEmits(['successUpdate'])

    const props = defineProps({
        recordValue: {
            required: true
        },
        event_id: {
            type: Number,
            required: true
        },
        colName: {
            type: String,
            required: true
        }
    })

    let validationErrors = ref([])
    let showError = ref(false)
    let updateVenueTypeDetails = reactive([])
    let updatedSchedule = reactive([])
    let updatedCategories = reactive([])
    let updatedSpeakers = reactive([])

    onMounted(() => {
        updateForm.newData = props.recordValue
    })
    const updateForm = useForm({
        columnName: props.colName,
        newData: ''
    });

    const updateRecord = async () => {

        if(updateForm.columnName == 'venue')
        {
            updateForm.type       = updateVenueTypeDetails.value.type
            updateForm.location   = updateVenueTypeDetails.value.venue.location
            updateForm.city       = updateVenueTypeDetails.value.venue.city
            updateForm.postalcode = updateVenueTypeDetails.value.venue.postalcode
            updateForm.url        = updateVenueTypeDetails.value.venue.url
            updateForm.meetingID  = updateVenueTypeDetails.value.venue.meetingID
            updateForm.passcode   = updateVenueTypeDetails.value.venue.passcode
        }
        else if(updateForm.columnName == 'schedules')
            updateForm.newData = updatedSchedule.value
        else if(updateForm.columnName == 'categories')
            updateForm.newData = updatedCategories.value
        else if(updateForm.columnName == 'speakers')
            updateForm.newData = updatedSpeakers.value

        await Inertia.put(route('updateEventRecord', props.event_id), updateForm,
            {
                preserveScroll: true,
                onSuccess: () => {
                    let __data = null
                    if(updateForm.columnName == 'venue')
                        __data = updateForm
                    else
                        __data = updateForm.newData

                    emit('successUpdate', [props.colName, __data])
                    validationErrors.value = []
                    showError.value = false
                    isOpen.value = false
                },
                onError: errors => {
                    validationErrors.value = errors
                    showError.value = true
                }
            })
    };

    const getFinalSchedules = (emittedSchedule) => {
        updatedSchedule.value = emittedSchedule
    }

    // Emit (event) for Categories
    const getSelectedCategories = (emitedCategories) => {
        updatedCategories.value = emitedCategories
    }

    // Emit (event) for Speakers
    const getSelectedSpeakers = (emitedSpeakers) => {
        updatedSpeakers.value = emitedSpeakers
    }

    // Emit (event) for event type and venue/online details
    const getEventType = (emitedEventType) => {
        updateVenueTypeDetails.value = emitedEventType
    }

    const isOpen = ref(false)
    const openModal = (emittedValue) => {
        isOpen.value = emittedValue
    }

</script>

<template>
    <MainModal :isOpen="isOpen" @open-modal="openModal">
        <template #openTriggerButton>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600 hover:text-blue-400 cursor-pointer">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
        </template>

        <template #title>
            Update Information
        </template>

        <template #content>
            <div class="flex flex-col mt-6 mb-3" v-if="showError">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 relative" role="alert">
                    <p class="font-bold mb-3">Error</p>
                    <ul class=" my-2">
                        <li v-for="error in validationErrors">
                            <p class="text-sm text-red-600">{{error.replace('new data', props.colName)}}</p>
                        </li>
                    </ul>
                    <button @click="showError=false">
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title>
                                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
            <div class="my-8">
                <div class="flex flex-col">

                    <form @submit.prevent="updateRecord">

                        <BreezeTextarea v-if="props.colName=='description'" id="desc" rows="6" class="w-full rounded-none" v-model="updateForm.newData" placeholder="Update record" />

                        <template v-else-if="props.colName=='venue'">
                            <EventType :getEventType="props.recordValue" @get-event-type="getEventType" />
                        </template>
                        <template v-else-if="props.colName=='schedules'">
                            <Scheduler :getSchedules="props.recordValue" @get-schedules="getFinalSchedules" />
                        </template>
                        <template v-else-if="props.colName=='categories'">
                            <SelectCategories :existingCat="props.recordValue" @selected-categories="getSelectedCategories" />
                        </template>
                        <template v-else-if="props.colName=='speakers'">
                            <SelectSpeakers :existingSpeakers="props.recordValue" @selected-speakers="getSelectedSpeakers" />
                        </template>
                        <BreezeInput v-else
                            :type="props.colName=='activeUntil' ? 'date' : 'text'"
                            class="w-full rounded-none"
                            placeholder="Update record"
                            v-model="updateForm.newData"
                        />
                        <div class="mt-4 flex w-full justify-end gap-3">
                            <button @click="isOpen=false" type="button" class="inline-flex justify-center uppercase rounded-sm border bg-gray-400 px-4 py-2 text-xs font-bold text-white hover:bg-gray-500">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex justify-center uppercase rounded-sm border border-gray-400 bg-gray-700 px-4 py-2 text-xs font-bold text-white hover:bg-gray-600">
                                Save Changes
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </template>

    </MainModal>
</template>
