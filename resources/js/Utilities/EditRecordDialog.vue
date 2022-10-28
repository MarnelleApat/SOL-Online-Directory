<script setup>
    import { onMounted, reactive, ref, watch } from 'vue'
    import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle, } from '@headlessui/vue'
    import BreezeInput from '@/Components/Input.vue';
    import { createToaster } from '@meforma/vue-toaster'
    import BreezeTextarea from '@/Components/Textarea.vue';
    import BreezeLabel from '@/Components/Label.vue';
    import BreezeInputError from '@/Components/InputError.vue';
    import Scheduler from '@/Utilities/Scheduler.vue'
    import SelectCategories from '@/Utilities/SelectCategories.vue'
    import SelectSpeakers from '@/Utilities/SelectSpeakers.vue'

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

    const isOpen = ref(false)
    let newData = ref(props.recordValue)
    const isEmpty = ref(false)
    const validationMsg = ref("")

    const isEmail    = ref(false);
    const isText     = ref(false);
    const isDate     = ref(false);
    const isTextArea = ref(false);
    const isNumber   = ref(false);
    const isVenue    = ref(false)
    const isSchedule = ref(false)
    const isCategory = ref(false)
    const isSpeaker  = ref(false)

    let venueData = ref({})
    let updatedSchedule = reactive([])
    let updatedCategories = reactive([])
    let updatedSpeakers = reactive([])

    onMounted(() => {
        // newData = props.recordValue

        if(props.colName=='activeUntil')
            isDate.value = true
        else if(props.colName=='email')
            isEmail.value = true
        else if(props.colName=='description')
            isTextArea.value = true
        else if(props.colName=='schedules')
            isSchedule.value = true
        else if(props.colName=='categories')
            isCategory.value = true
        else if(props.colName=='speakers')
            isSpeaker.value = true
        else if(props.colName=='price' || props.colName=='limit')
            isNumber.value = true
        else if(props.colName=='venue')
        {
            isVenue.value = true
            venueData.value = JSON.parse(props.recordValue[1])
        }
        else
            isText.value = true

    })

    const updateRecord = () => {

        let _newData = null

        // assigning data to holder
        if(props.colName==='venue')
        {
            _newData = [newData.value[0], JSON.stringify(venueData.value)]
        }
        else if(props.colName==='schedules')
            _newData = updatedSchedule.value
        else if(props.colName==='categories')
            _newData = updatedCategories.value
        else if(props.colName==='speakers')
            _newData = updatedSpeakers.value
        else
            _newData = newData.value

        //check if empty
        // if(!_newData || _newData === "")
        // {
        //     isEmpty.value = true
        //     validationMsg.value = "Field must not be empty."
        //     return false;
        // }

        // send to backend after passing the validation
        let data = {
            event_id: props.event_id,
            columnName: props.colName,
            newData: _newData
        }

        axios.post(route('updateEventRecord.api'), data)
            .then((response) => {
                emit('successUpdate',[props.colName, _newData])
                isOpen.value = false
            })
            .catch((error) => {
                toaster.error(error.message)
            })
    }

    const closeModal = () => {
        isOpen.value = false
    }

    const openModal = () => {
        isOpen.value = true
    }

    watch(isOpen, (newValue) => {
        if(newData.value === "") {
            newData.value = props.recordValue
            isEmpty.value = false
        }
    })

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

</script>

<template>
    <div @click="openModal">
        <slot name="button"></slot>
    </div>

    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-10">
            <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-black bg-opacity-25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex justify-center p-4 text-center">
                    <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">

                        <DialogPanel class="w-full max-w-4xl transform rounded-none bg-white p-10 text-left align-middle shadow-xl transition-all">
                            <DialogTitle as="h3" class="text-xl font-bold leading-4 text-gray-600 flex flex-col">
                                <h5>
                                    <slot name="title"></slot>
                                </h5>
                            </DialogTitle>

                            <div class="my-8">
                                <div class="flex flex-col">
                                    <!-- <BreezeLabel for="desc" value="Updated information" class="flex items-center font-bold py-3" /> -->

                                    <BreezeInput v-if="isDate" required type="date" class="w-full rounded-none" placeholder="Update record" v-model="newData" />
                                    <BreezeInput v-if="isEmail" required type="email" class="w-full rounded-none" placeholder="Update record" v-model="newData" />
                                    <BreezeTextarea v-if="isTextArea" id="desc" rows="6" class="w-full rounded-none" v-model="newData" placeholder="Update record" />
                                    <BreezeInput v-if="isText" required type="text" class="w-full rounded-none" placeholder="Update record" v-model="newData" />
                                    <BreezeInput v-if="isNumber" required type="number" min="0" class="w-full rounded-none" placeholder="Update record" v-model="newData" />

                                    <template v-if="isVenue">
                                        <div class="flex flex-col gap-2">
                                            <BreezeLabel  value="Type of Event" class="flex items-center font-bold" />
                                            <select v-model="newData[0]">
                                                <option value="Physical">Physical</option>
                                                <option value="Online">Online</option>
                                                <option value="Hybrid">Hybrid</option>
                                            </select>
                                        </div>
                                        <template v-if="newData[0]=='Physical' || newData[0]=='Hybrid'">
                                            <div class="flex flex-col mt-6">
                                                <BreezeLabel for="venue" value="Venue/Location" class="flex items-center font-bold" />
                                                <BreezeInput id="venue" v-model="venueData.location" type="text" class="mt-1 block w-full rounded-none" placeholder="Street / Block / Bldg Address" />
                                            </div>

                                            <div class="flex gap-2 mt-2">
                                                <div class="flex flex-col w-1/2">
                                                    <BreezeInput v-model="venueData.city" type="text" class="mt-1 block w-full rounded-none" placeholder="City" />
                                                </div>
                                                <div class="flex flex-col w-1/2">
                                                    <BreezeInput required v-model="venueData.postalcode" type="text" class="mt-1 block w-full rounded-none" min="0" placeholder="Postal Code" />
                                                </div>
                                            </div>
                                        </template>
                                        <template v-if="newData[0]=='Online' || newData[0]=='Hybrid'">
                                            <div class="flex flex-col gap-2 mt-6">
                                                <BreezeLabel for="meetingLink" value="Online Event Details" class="flex items-center font-bold" />
                                                <BreezeInput required id="meetingLink" v-model="venueData.url" type="text" class="mt-1 block w-full rounded-none" placeholder="Meeting URL (ex.https://zoom.sg)" />
                                            </div>
                                            <div class="flex gap-2 mt-2">
                                                <div class="flex flex-col w-1/2">
                                                    <BreezeInput required v-model="venueData.meetingID" type="text" class="mt-1 block w-full rounded-none" placeholder="Meeting ID" />
                                                </div>
                                                <div class="flex flex-col w-1/2">
                                                    <BreezeInput required v-model="venueData.passcode" type="text" class="mt-1 block w-full rounded-none" min="0" placeholder="Meeting Password (ei: N/A for no password)" />
                                                </div>
                                            </div>
                                        </template>
                                    </template>

                                    <template v-if="isSchedule">
                                        <Scheduler @get-schedules="getFinalSchedules" :getSchedules="newData" />
                                    </template>
                                    <template v-if="isCategory">
                                        <SelectCategories :existingCat="newData" @selected-categories="getSelectedCategories" />
                                        <!-- <pre>{{newData}}</pre> -->
                                    </template>
                                    <template v-if="isSpeaker">
                                        <SelectSpeakers :existingSpeakers="newData" @selected-speakers="getSelectedSpeakers" />
                                    </template>
                                    <BreezeInputError v-if="isEmpty" :message="validationMsg" />

                                </div>
                            </div>

                            <div class="mt-4 flex w-full justify-end gap-3">
                                <button type="button" class="inline-flex justify-center uppercase rounded-sm border bg-gray-400 px-4 py-2 text-xs font-bold text-white hover:bg-gray-500"
                                    @click="closeModal">Cancel
                                </button>
                                <button type="button" class="inline-flex justify-center uppercase rounded-sm border border-gray-400 bg-gray-700 px-4 py-2 text-xs font-bold text-white hover:bg-gray-600"
                                    @click="updateRecord">Save Changes
                                </button>

                            </div>

                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
