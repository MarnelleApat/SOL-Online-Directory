<script setup>
    import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle, } from '@headlessui/vue'

    const emit = defineEmits(['openModal'])
    const props = defineProps({
        isOpen: [Boolean]
    })

    const openModal = () => {
        emit('openModal', true)
    }

</script>

<template>
    <div @click="openModal">
        <slot name="openTriggerButton"></slot>
    </div>
    <TransitionRoot appear :show="props.isOpen" as="template">
        <Dialog as="div" class="relative z-10">
            <div className="fixed inset-0 bg-black/70" aria-hidden="true" />
            <div class="fixed inset-0 overflow-y-scroll">
                <div class="flex min-h-full justify-center p-4 text-center">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95">
                        <DialogPanel
                        class="w-full max-w-4xl transform rounded-none bg-white p-10 text-left align-middle shadow-xl transition-all">
                            <DialogTitle
                                as="h3"
                                class="text-xl font-bold leading-4 text-gray-600 flex flex-col">
                                <h5 class="text-2xl">
                                    <slot name="title"></slot>
                                </h5>
                            </DialogTitle>

                            <slot name="content"></slot>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>

        </Dialog>
    </TransitionRoot>

</template>
