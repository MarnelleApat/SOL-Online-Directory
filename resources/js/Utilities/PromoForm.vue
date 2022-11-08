<script setup>
    import { ref } from 'vue';
    import { useForm } from '@inertiajs/inertia-vue3';
    import BreezeLabel from '@/Components/Label.vue';
    import BreezeInput from '@/Components/Input.vue';
    import BreezeTextarea from '@/Components/Textarea.vue';
    import BreezeButton from '@/Components/Button.vue';
    import { Inertia } from '@inertiajs/inertia';
    import toDate from '@/Helpers/StringToDate'
    import MainModal from '@/Utilities/MainModal.vue'
    import { createToaster } from '@meforma/vue-toaster'

    const toaster = createToaster({
        dismissible: true,
        duration: 2000
    })

    const props = defineProps({
            event_id: [Number],
            eventPromos: [Array]
        })

    let validationErrors = ref([])
    let showError = ref(false)
    let isUpdate = ref(false)

    const promoForm = useForm({
        event_id: props.event_id,
        name: '',
        promoCode: '',
        description: '',
        quantity: '',
        validFrom: '',
        validTo: '',
    });

    const submit = () => {

        if(isUpdate.value)
        {
            Inertia.put(route('promo.update', promoForm.id), promoForm, {
                preserveScroll: true,
                onSuccess: async() => {
                    let findPromo = props.eventPromos.findIndex(element => element.id === promoForm.id)
                    Object.assign(props.eventPromos[findPromo], {
                        'name': promoForm.name,
                        'description': promoForm.description,
                        'quantity': promoForm.quantity,
                        'validFrom': promoForm.validFrom,
                        'validTo': promoForm.validTo,
                    })

                    validationErrors.value = []
                    showError.value = false
                    promoForm.reset()
                    isOpen.value = await false
                    isUpdate.value = await false
                    await toaster.success('Promo updated successfully.')
                },
                onError: errors => {
                    validationErrors.value = errors
                    showError.value = true
                },
            })
        }
        else
        {
            Inertia.post(route('promo.store'), promoForm, {
                preserveScroll: true,
                onSuccess: async (response) => {

                    let _promos = response.props.event.promos

                    props.eventPromos = []

                    _promos.forEach(element => {
                        props.eventPromos.push(element)
                    });

                    validationErrors.value = []
                    showError.value = false
                    promoForm.reset()
                    isOpen.value = await false
                    await toaster.success('New promo added successfully.')
                },
                onError: errors => {
                    validationErrors.value = errors
                    showError.value = true
                },
            })
        }
    };


    const isOpen = ref(false)
    const openModal = (emittedValue) => {
        isOpen.value = emittedValue
    }

    const closeModal = () => {
        isOpen.value = false
        isUpdate.value = false
        validationErrors.value = []
        showError.value = false
        promoForm.reset()
    }

    const isPromoListModal = ref(false)
    const openPromoListModal = (emittedValue) => {
        isPromoListModal.value = emittedValue
    }

    const selectPromo = (promo) => {
        isUpdate.value = true
        isPromoListModal.value = false
        validationErrors.value = []
        showError.value = false
        promoForm.id = promo.id
        promoForm.event_id = promo.event_id
        promoForm.name = promo.name
        promoForm.promoCode = promo.promoCode
        promoForm.description = promo.description
        promoForm.quantity = promo.quantity
        promoForm.validFrom = promo.validFrom
        promoForm.validTo = promo.validTo
    }

</script>

<template>
    <MainModal :isOpen="isOpen" @open-modal="openModal">
        <template #openTriggerButton>
            <slot name="button" />
        </template>
        <template #title>
            {{isUpdate ? 'Update Promo' : 'Create Promo'}}
        </template>
        <template #content>
            <div class="flex flex-col mt-4" v-if="showError">
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

            <div class="flex flex-col mt-5">

                <form @submit.prevent="submit">
                    <div class="flex flex-col gap-5">
                        <div>
                            <BreezeLabel for="name" value="Name" class="flex items-center font-bold" />
                            <BreezeInput
                                id="name"
                                type="text"
                                :class="{ 'border-red-600':validationErrors.name }"
                                class="mt-1 block w-full rounded-none"
                                placeholder="Promo Name"
                                v-model="promoForm.name" />
                        </div>
                        <div>
                            <BreezeLabel for="promocode" value="Promo Code" class="flex items-center font-bold" />
                            <BreezeInput :disabled="isUpdate" id="promocode" type="text" :class="{ 'border-red-600': !isUpdate && validationErrors.promoCode, 'bg-gray-100 text-gray-400 font-bold': isUpdate }" class="mt-1 block w-full rounded-none" placeholder="Unique Promocode" v-model="promoForm.promoCode" />
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
                            type="button" @click="closeModal"
                            class="inline-flex justify-center uppercase rounded-sm border bg-gray-400 px-4 py-2 text-xs font-bold text-white hover:bg-gray-500">
                            Cancel
                        </button>
                        <div class="flex gap-3">
                                <MainModal :isOpen="isPromoListModal" @open-modal="openPromoListModal">
                                    <template #openTriggerButton>
                                        <button type="button" class="inline-flex justify-center uppercase rounded-sm border bg-blue-500 px-4 py-2 text-xs font-bold text-white hover:bg-blue-600">
                                            View Existing Promos
                                        </button>
                                    </template>
                                    <template #title>
                                        Promo List
                                    </template>
                                    <template #content>
                                        <div class="flex flex-col mt-5">
                                            <table class="table-auto">
                                                <thead>
                                                    <tr>
                                                        <th class="p-2 text-sm border">Name</th>
                                                        <th class="p-2 text-sm border">Code</th>
                                                        <th class="p-2 text-sm border">Description</th>
                                                        <th class="p-2 text-sm border">Quantity</th>
                                                        <th class="p-2 text-sm border">Valid From</th>
                                                        <th class="p-2 text-sm border">Valid To</th>
                                                        <th class="p-2 text-sm border">&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-if="props.eventPromos.length" v-for="promo in props.eventPromos" class="hover:bg-gray-100">
                                                        <td class="p-2 text-sm border">{{promo.name}}</td>
                                                        <td class="p-2 text-sm border">{{promo.promoCode}}</td>
                                                        <td class="p-2 text-sm border">{{promo.description}}</td>
                                                        <td class="p-2 text-sm border">{{promo.quantity}}</td>
                                                        <td class="p-2 text-sm border">{{toDate(promo.validFrom, 'll')}}</td>
                                                        <td class="p-2 text-sm border">{{toDate(promo.validTo, 'll')}}</td>
                                                        <td class="p-2 text-sm border">
                                                            <button @click="selectPromo(promo)"
                                                                type="button"
                                                                class="inline-flex justify-center uppercase rounded-sm border bg-blue-500 px-3 py-1 text-xs font-bold text-white hover:bg-blue-400">
                                                                EDIT
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr v-else>
                                                        <td colspan="7" class="text-center text-gray-400 italic border p-5">No promo found</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!-- <pre>{{props.eventPromos}}</pre> -->
                                        </div>

                                        <button type="button" @click="isPromoListModal=false" class="mt-5 inline-flex justify-center uppercase rounded-sm border bg-gray-400 px-4 py-2 text-xs font-bold text-white hover:bg-gray-500">
                                            CLOSE
                                        </button>
                                    </template>
                                </MainModal>
                            <BreezeButton type="submit" class="inline-flex justify-center uppercase rounded-sm border border-gray-400 bg-gray-700 px-4 py-2 text-xs font-bold text-white hover:bg-gray-600" :class="{ 'opacity-25': promoForm.processing }" :disabled="promoForm.processing">
                                Save Promo
                            </BreezeButton>
                        </div>
                    </div>
                </form>
            </div>
        </template>
    </MainModal>

</template>
