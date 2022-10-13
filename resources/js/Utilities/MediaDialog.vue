<script setup>
    import { ref } from 'vue'
    import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle, } from '@headlessui/vue'

    const isOpen = ref(false)

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
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0">
                <div class="fixed inset-0 bg-black bg-opacity-25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full justify-center p-4 text-center">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95">

                        <DialogPanel class="w-full max-w-4xl transform overflow-hidden rounded-none bg-white p-10 text-left align-middle shadow-xl transition-all">
                            <DialogTitle as="h3" class="text-xl font-bold leading-6 text-gray-600 flex flex-col">Select Image</DialogTitle>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Select image for your banner or profile photo. Or you can upload image.
                                </p>
                            </div>

                            <div class="mt-4 flex justify-end gap-3 absolute right-8 bottom-8">
                                <button type="button"
                                    class="inline-flex justify-center uppercase rounded-sm border border-transparent bg-gray-600 px-4 py-2 text-sm font-medium text-white hover:bg-gray-500"
                                    @click="closeModal">Close
                                </button>
                                <button type="button"
                                    class="inline-flex justify-center uppercase rounded-sm border border-transparent bg-gray-300 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-200"
                                    @click="closeModal">Select Image
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
