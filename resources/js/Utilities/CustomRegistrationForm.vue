<script setup>
    import MainModal from '@/Utilities/MainModal.vue'
    import BreezeLabel from '@/Components/Label.vue';
    import BreezeTextarea from '@/Components/Textarea.vue';
    import BreezeInput from '@/Components/Input.vue';
    import { onMounted, reactive, ref } from 'vue';

    import Multiselect from '@vueform/multiselect'
    import { Inertia } from '@inertiajs/inertia';

    let validationErrors = ref([])
    let showError = ref(false)

    const props = defineProps({
        event_id: {
            type: Number,
            required: true
        },
        existingSpecialSetting: [String, Array, Object]
    })

    const emit = defineEmits(['successUpdate'])

    const customization = [
            {'name':'Billing Address'},
            {'name':'Shipping Address'},
            {'name':'Gender'},
            {'name':'Church'},
            {'name':'Church Position'},
            {'name':'Company Name'},
            {'name':'Company Position'}
        ]
    let specialSettings = reactive([])
    let customizationModel = reactive(props.existingSpecialSetting[1].customFields)
    const isOpen = ref(false)

    const openModal = () => {
        isOpen.value = true
    }
    const onSelect = (data) => {
        specialSettings = data
    }

    const saveSpecialSettings = async () => {

        // console.log(specialSettings)

        // let _form = {
        //     customField: []
        // }

        // specialSettings.forEach(element => {
        //     _form.customField.push(element)
        // });

        let _spstng = {
            'columnName': 'specialSettings',
            'newData': JSON.stringify(specialSettings)
        }

        await Inertia.put(route('updateEventRecord', props.event_id), _spstng,
            {
                preserveScroll: true,
                onSuccess: () => {
                    emit('successUpdate', ['specialSettings', JSON.stringify(specialSettings)])
                    validationErrors.value = []
                    showError.value = false
                    isOpen.value = false
                },
                onError: errors => {
                    validationErrors.value = errors
                    showError.value = true
                }
            })
    }

</script>
<template>
    <MainModal :isOpen="isOpen" @open-modal="openModal">
        <template #openTriggerButton>
            <slot name="button" />
        </template>
        <template #title>
            Customize Registration Form
            <p class="text-sm font-normal leading-5 py-4 text-gray-400">Below is the default registration form. You can customize the input based on your need.</p>
        </template>
        <template #content>
            <div class="flex flex-col gap-5 mt-5 bg-gray-100 px-3 py-12">
                <div class="w-1/4">
                    <BreezeInput :disabled="true" type="text" :class="{ 'bg-gray-50 text-gray-400': true }" class="mt-1 block w-full rounded-none" placeholder="NIRC (Last 4-digit)" />
                </div>
                <div class="flex gap-5">
                    <div class="w-1/2">
                        <BreezeInput :disabled="true" type="text" :class="{ 'bg-gray-50 text-gray-400': true }" class="mt-1 block w-full rounded-none" placeholder="First Name" />
                    </div>
                    <div class="w-1/2">
                        <BreezeInput :disabled="true" type="text" :class="{ 'bg-gray-50 text-gray-400': true }" class="mt-1 block w-full rounded-none" placeholder="Last Name" />
                    </div>
                </div>
                <div class="flex gap-5">
                    <div class="w-1/2">
                        <BreezeInput :disabled="true" type="text" :class="{ 'bg-gray-50 text-gray-400': true }" class="mt-1 block w-full rounded-none" placeholder="Email Address" />
                    </div>
                    <div class="w-1/2">
                        <BreezeInput :disabled="true" type="text" :class="{ 'bg-gray-50 text-gray-400': true }" class="mt-1 block w-full rounded-none" placeholder="Phone Number" />
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <BreezeLabel value="Address" class="text-gray-500 leading-0 font-bold" />
                    <BreezeTextarea rows="2" :disabled="true" :class="{ 'bg-gray-50 text-gray-400': true }" class="block w-full rounded-none" placeholder="Street No / Block # / Bldg. No" />
                    <div class="flex gap-5">
                        <div class="w-1/3">
                            <BreezeInput :disabled="true" type="text" :class="{ 'bg-gray-50 text-gray-400': true }" class="mt-1 block w-full rounded-none" placeholder="City" />
                        </div>
                        <div class="w-1/3">
                            <BreezeInput :disabled="true" type="text" :class="{ 'bg-gray-50 text-gray-400': true }" class="mt-1 block w-full rounded-none" placeholder="Postal Code" />
                        </div>
                        <div class="w-1/3">
                            <BreezeInput :disabled="true" type="text" :class="{ 'bg-gray-50 text-gray-400': true }" class="mt-1 block w-full rounded-none" placeholder="Country" />
                        </div>
                    </div>
                </div>
            </div>
            <form @submit.prevent="saveSpecialSettings">
                <div class="flex flex-col gap-5 mt-5 bg-gray-100 p-5">
                    <div class="flex flex-col mt-6 mb-3" v-if="showError">
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 relative" role="alert">
                            <p class="font-bold mb-3">Error</p>
                            <ul class=" my-2">
                                <li v-for="error in validationErrors">
                                    <p class="text-sm text-red-600">{{error.replace('new data', 'Special settings')}}</p>
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
                    <BreezeLabel value="Add Form Customization" class="text-gray-500 leading-0 font-bold" />
                    <Multiselect
                        v-model="customizationModel"
                        mode="tags"
                        required
                        @change="onSelect"
                        :object=true
                        value-prop="name"
                        :close-on-select="false"
                        placeholder="Select Customization"
                        track-by="name"
                        label="name"
                        :options="customization">
                        <template v-slot:tag="{ option, handleTagRemove, disabled }">
                            <div class="multiselect-tag is-user" :class="{ 'is-disabled': disabled }">
                                {{ option.name }}
                                <span v-if="!disabled" class="multiselect-tag-remove" @mousedown.prevent="handleTagRemove(option, $event)">
                                    <span class="multiselect-tag-remove-icon"></span>
                                </span>
                            </div>
                        </template>
                    </Multiselect>
                </div>

                <div class="flex justify-between mt-10">
                    <button type="button" @click="isOpen=false" class="inline-flex justify-center uppercase rounded-sm border bg-gray-400 px-4 py-2 text-xs font-bold text-white hover:bg-gray-500">
                        CLOSE
                    </button>
                    <button type="submit" class="inline-flex justify-center uppercase rounded-sm border bg-blue-500 px-4 py-2 text-xs font-bold text-white hover:bg-blue-400">
                        SAVE CHANGES
                    </button>
                </div>
            </form>
        </template>
    </MainModal>
</template>
