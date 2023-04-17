<script setup>
    import { reactive, ref } from 'vue'
    import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle, } from '@headlessui/vue'
    import spinner from '@/Utilities/Spinner.vue'

    const isOpen = ref(false)

    const closeModal = () => {
        isOpen.value = false
    }

    const openModal = async () => {
        await getAllMedia()
        isOpen.value = true
    }

    // all media variable holder
    const allMedia = ref([])

    // get all the media items
    const getAllMedia = () => axios.get(route('allMedia.api'))
            .then((response) => {
                 allMedia.value = response.data.data
            })

    let selectedPhoto = reactive([])
    const setSelected = async (selectedImg) => {

        // check if there's a previous selected item
        const getPreviousSelected = allMedia.value.filter((element) => element.isSelected)

        // set the new selected to the clicked item
        const selected = allMedia.value.find((element) => { return element.id === selectedImg.id })

        //if there is/are. Get those object array and remove the key in the object
        if(getPreviousSelected.length > 0)
            getPreviousSelected.forEach((element) => { delete element.isSelected })

        // create new key 'isSelected' as flag to the selected item
        selected.isSelected = true
        selectedPhoto = selected

    }

    // create emit event
    const emit = defineEmits(['selectedImage'])

    const selectImage = () => {
        emit('selectedImage', selectedPhoto)
        isOpen.value = false
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
                <div class="flex min-h-full justify-center p-4 text-center">
                    <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">

                        <DialogPanel class="w-full max-w-4xl transform overflow-hidden rounded-none bg-white p-10 text-left align-middle shadow-xl transition-all">
                            <DialogTitle as="h3" class="text-xl font-bold leading-6 text-gray-600 flex flex-col">
                                <slot name="title"></slot>
                            </DialogTitle>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500"> Select image for your banner or profile photo. Or you can upload image. </p>
                            </div>

                            <div v-if="allMedia.length" class="border my-10 max-h-[550px] overflow-y-auto">
                                <div class="grid grid-cols-5 gap-5 p-5">
                                    <div v-for="media in allMedia" @click="setSelected(media)" :class="{ 'ring-offset-purple-800/[.50] ring-4':media.isSelected }" class="w-full bg-white border shadow-sm cursor-pointer hover:ring-offset-purple-800/[.50] hover:ring-4">
                                        <span v-if="media.isSelected" class="mx-auto absolute z-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-green-300">
                                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                        <img v-if="media.file_name" :src="media.file_name" />
                                        <spinner v-else></spinner>
                                    </div>
                                </div>
                            </div>
                            <div v-else role="status" class="flex justify-center items-center my-10">
                                <spinner></spinner>
                            </div>

                            <div class="mt-4 absolute flex w-full justify-between gap-3 right-0 px-10 bottom-8">
                                <button type="button"
                                    class="inline-flex justify-center uppercase rounded-sm border border-gray-400 bg-gray-700 px-4 py-2 text-xs font-bold text-white hover:bg-gray-600"
                                    @click="closeModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                    </svg>&nbsp;Upload
                                </button>
                                <div class="flex gap-3">
                                    <button type="button"
                                        class="inline-flex justify-center uppercase rounded-sm border px-4 py-2 text-sm font-bold text-gray-500 hover:text-gray-400 hover:bg-gray-100"
                                        @click="closeModal">Close
                                    </button>
                                    <button type="button"
                                        class="inline-flex justify-center uppercase rounded-sm border border-transparent bg-gray-300 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-200"
                                        @click="selectImage">Select Image
                                    </button>
                                </div>
                            </div>

                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
