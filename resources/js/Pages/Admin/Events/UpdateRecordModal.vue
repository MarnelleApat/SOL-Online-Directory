<script setup>
    import { ref, defineExpose } from 'vue'
    import { TransitionRoot, TransitionChild, Dialog, DialogTitle, DialogPanel } from '@headlessui/vue'
    import { computed } from '@vue/reactivity';

    const isOpen = ref(false)


    const props = defineProps(['isClose'])

    const setItClose = computed(() => {
        if(props.isClose)
            isOpen.value = false
    });

    const openModal = () => {
        isOpen.value = true
    }

    const closeModal = () => {
        isOpen.value = false
    }

    defineExpose({ openModal, closeModal })

</script>

<template>
    <slot :onClick="openModal" name="button" />
    <TransitionRoot appear :show="isOpen" @close="setItClose" as="template">
        <Dialog as="div" class="relative z-10">
            <div className="fixed inset-0 bg-black/70" aria-hidden="true" />
            <div class="fixed inset-0 overflow-y-scroll">
                <div class="flex justify-center p-4 text-center">
                    <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
                        <DialogPanel class="w-full max-w-4xl transform rounded-none bg-white p-10 text-left align-middle shadow-xl transition-all">
                            <div class="flex justify-between mb-5">
                                <DialogTitle as="h3" class="text-xl font-bold leading-4 text-gray-600 flex flex-col">
                                    <slot name="header" />
                                </DialogTitle>
                                <svg :onClick="closeModal"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6 cursor-pointer font-bold hover:text-gray-400 text-gray-900">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <slot />
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

</template>
