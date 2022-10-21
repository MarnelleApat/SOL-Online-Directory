<script setup>
    import { onMounted, ref } from 'vue'
    import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle, } from '@headlessui/vue'
    import BreezeInput from '@/Components/Input.vue';
    import { createToaster } from '@meforma/vue-toaster'
    // import route  from 'vendor/tightenco/ziggy/src/js';

    const toaster = createToaster({
            dismissible: true
        })

    const emit = defineEmits(['successUpdate'])

    const isOpen = ref(false)
    const newData = ref('')

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

    onMounted(() => {
        newData.value = props.recordValue
    })

    const updateRecord = () => {

        // update only if not empty and the new data is not the same with the previous value
        if(newData.value !== "" && newData.value !== props.recordValue)
        {
            axios.post(route('updateEventRecord.api'), { event_id: props.event_id, columnName: props.colName, newData: newData.value })
                .then((response) => {
                    toaster.success('Record updated successfully.')
                    emit('successUpdate',response.data)
                    isOpen.value = false
                })
                .catch((error) => {
                    toaster.error(error.message+'. Please contact administrator')
                })
        }
    }

    const closeModal = () => {
        isOpen.value = false
    }

    const openModal = () => {
        isOpen.value = true
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

                        <DialogPanel class="w-full max-w-4xl transform overflow-hidden rounded-none bg-white p-10 text-left align-middle shadow-xl transition-all">
                            <DialogTitle as="h3" class="text-xl font-bold leading-6 text-gray-600 flex flex-col">
                                <slot name="title"></slot>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Modify the {{props.colName}} of the event</p>
                                </div>
                            </DialogTitle>

                            <div class="border my-10">
                                <div class="flex">
                                    <BreezeInput required type="text" class="w-full rounded-none" placeholder="Update record" v-model="newData" />
                                </div>
                            </div>

                            <div class="mt-4 flex w-full justify-end gap-3">
                                <button type="button" class="inline-flex justify-center uppercase rounded-sm border bg-gray-400 px-4 py-2 text-xs font-bold text-white hover:bg-gray-500"
                                    @click="closeModal">Cancel
                                </button>
                                <button type="button" class="inline-flex justify-center uppercase rounded-sm border border-gray-400 bg-gray-700 px-4 py-2 text-xs font-bold text-white hover:bg-gray-600"
                                    @click="updateRecord">Save
                                </button>

                            </div>

                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
