<script setup>
    import { onMounted, ref, useSlots, watch } from 'vue'
    import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle, } from '@headlessui/vue'
    import BreezeInput from '@/Components/Input.vue';
    import { createToaster } from '@meforma/vue-toaster'
    import BreezeTextarea from '@/Components/Textarea.vue';
    import BreezeLabel from '@/Components/Label.vue';
    import BreezeInputError from '@/Components/InputError.vue';

    const toaster = createToaster({
            dismissible: true
        })

    const emit = defineEmits(['successUpdate'])

    const isOpen = ref(false)
    const newData = ref('')
    const isEmpty = ref(false)
    const validationMsg = ref("")

    const props = defineProps({
        recordValue: {
            type: String,
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

    const isEmail       = ref(false);
    const isText        = ref(false);
    const isDate        = ref(false);
    const isTextArea    = ref(false);
    const isOption      = ref(false);

    onMounted(() => {
        newData.value = props.recordValue

        if(props.colName=='activeUntil')
            isDate.value = true
        else if(props.colName=='email')
            isEmail.value = true
        else if(props.colName=='description')
            isTextArea.value = true
        else
            isText.value = true



    })

    const updateRecord = () => {

        //check if empty
        if(newData.value === "")
        {
            isEmpty.value = true
            validationMsg.value = "Field must not be empty."
            return false;
        }

        // update only if not empty and the new data is not the same with the previous value
        if(newData.value !== props.recordValue)
        {
            axios.post(route('updateEventRecord.api'), { event_id: props.event_id, columnName: props.colName, newData: newData.value })
                .then((response) => {
                    emit('successUpdate',[props.colName, newData.value])
                    isOpen.value = false
                })
                .catch((error) => {
                    toaster.error(error.message)
                })
        }
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

                        <DialogPanel class="w-full max-w-4xl transform overflow-hidden rounded-none bg-white p-10 text-left align-middle shadow-xl transition-all">
                            <DialogTitle as="h3" class="text-xl font-bold leading-4 text-gray-600 flex flex-col">
                                <h5>Modify Information</h5>
                            </DialogTitle>

                            <div class="my-10">
                                <div class="flex flex-col">
                                    <BreezeLabel for="desc" value="Updated information" class="flex items-center font-bold py-3" />

                                    <BreezeInput v-if="isDate" required type="date" class="w-full rounded-none" placeholder="Update record" v-model="newData" />
                                    <BreezeInput v-if="isEmail" required type="email" class="w-full rounded-none" placeholder="Update record" v-model="newData" />
                                    <BreezeTextarea v-if="isTextArea" id="desc" rows="6" class="w-full rounded-none" v-model="newData" placeholder="Update record" />
                                    <BreezeInput v-if="isText" required type="text" class="w-full rounded-none" placeholder="Update record" v-model="newData" />
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
