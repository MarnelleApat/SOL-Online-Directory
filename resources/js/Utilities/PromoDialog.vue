<script setup>
    import { onMounted, reactive, watch, ref } from 'vue';
    import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle, } from '@headlessui/vue'
    import { useForm } from '@inertiajs/inertia-vue3';
    import BreezeInput from '@/Components/Input.vue';
    import BreezeTextarea from '@/Components/Textarea.vue';
    import BreezeInputError from '@/Components/InputError.vue';
    import BreezeButton from '@/Components/Button.vue';
    import BreezeLabel from '@/Components/Label.vue';
    import { Inertia } from '@inertiajs/inertia';


    const props = defineProps({
            event_id: Number
        })

    let validationErrors = ref([])
    let showError = ref(false)

    const isOpen = ref(false)

    const closeModal = () => {
        isOpen.value = false
    }

    const openModal = () => {
        isOpen.value = true
    }

    const promoForm = useForm({
        event_id: props.event_id,
        name: '',
        promoCode: '',
        description: '',
        quantity: '',
        validFrom: '',
        validTo: '',
    });

    const submit = async () => {
        await Inertia.post(route('promo.store'), promoForm, {
            onSuccess:response => {
                isOpen.value = false
            },
            onError: errors => {
                validationErrors.value = errors
                showError.value = true
            },
        })
    };


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
                                <h5 class="text-2xl mb-8">Create Promo</h5>
                            </DialogTitle>
                            <div class="flex flex-col mb-4" v-if="showError">
                                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 relative" role="alert">
                                    <p class="font-bold mb-3">Error</p>
                                    <ul class=" my-2">
                                        <li v-for="error in validationErrors">
                                            <p class="text-sm text-red-600">{{error}}</p>
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

                            <div class="flex flex-col">
                                <form @submit.prevent="submit">
                                    <div class="flex flex-col gap-5">
                                        <div>
                                            <BreezeLabel for="name" value="Name" class="flex items-center font-bold" />
                                            <BreezeInput id="name" type="text" :class="{ 'border-red-600':validationErrors.name }" class="mt-1 block w-full rounded-none" placeholder="Promo Name" v-model="promoForm.name" />
                                        </div>
                                        <div>
                                            <BreezeLabel for="promocode" value="Promo Code" class="flex items-center font-bold" />
                                            <BreezeInput id="promocode" type="text" :class="{ 'border-red-600':validationErrors.promoCode }" class="mt-1 block w-full rounded-none" placeholder="Unique Promocode" v-model="promoForm.promoCode" />
                                        </div>
                                        <div>
                                            <BreezeLabel for="desc" value="Short Description" class="flex items-center font-bold" />
                                            <BreezeTextarea id="desc" rows="6" :class="{ 'border-red-600':validationErrors.description }" class="mt-1 block w-full rounded-none" v-model="promoForm.description" placeholder="Short Description" />
                                        </div>
                                        <div>
                                            <BreezeLabel for="quantity" value="Promo quantity limit (0 for unlimited)" class="flex items-center font-bold" />
                                            <BreezeInput id="quantity" type="number" min="0" :class="{ 'border-red-600':validationErrors.quantity }" class="mt-1 block w-full rounded-none" placeholder="Quantity limit of the promo (0 for no limit)" v-model="promoForm.quantity" />
                                        </div>
                                        <div class="flex gap-5">
                                            <div class="flex flex-col w-1/2">
                                                <BreezeLabel for="validFrom" value="Valid From" class="flex items-center font-bold" />
                                                <BreezeInput id="validFrom" type="date" :class="{ 'border-red-600':validationErrors.validFrom }" class="mt-1 block w-full rounded-none" placeholder="Start date of the promo" v-model="promoForm.validFrom" />
                                            </div>
                                            <div class="flex flex-col w-1/2">
                                                <BreezeLabel for="validTo" value="Valid Until" class="flex items-center font-bold" />
                                                <BreezeInput id="validTo" type="date" :class="{ 'border-red-600':validationErrors.validTo }" class="mt-1 block w-full rounded-none" placeholder="End date of the promo" v-model="promoForm.validTo" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-10 flex w-full justify-between gap-3">
                                        <button
                                            type="button"
                                            @click="closeModal"
                                            class="inline-flex justify-center uppercase rounded-sm border bg-gray-400 px-4 py-2 text-xs font-bold text-white hover:bg-gray-500">
                                            Cancel
                                        </button>
                                        <div class="flex gap-3">
                                            <button type="button" class="inline-flex justify-center uppercase rounded-sm border bg-blue-500 px-4 py-2 text-xs font-bold text-white hover:bg-blue-600">
                                                View Existing Promos
                                            </button>
                                            <BreezeButton class="inline-flex justify-center uppercase rounded-sm border border-gray-400 bg-gray-700 px-4 py-2 text-xs font-bold text-white hover:bg-gray-600" :class="{ 'opacity-25': promoForm.processing }" :disabled="promoForm.processing">
                                                Create Promo
                                            </BreezeButton>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>




</template>
