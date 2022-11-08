<script setup>
    import MainModal from '@/Utilities/MainModal.vue'
    import BreezeLabel from '@/Components/Label.vue';
    import BreezeTextarea from '@/Components/Textarea.vue';
    import BreezeInput from '@/Components/Input.vue';
    import { Switch } from '@headlessui/vue'
    import { reactive, ref } from 'vue';

    import Multiselect from '@vueform/multiselect'

    const customization = [
            {'name':'Billing Address'},
            {'name':'Gender'},
            {'name':'Church'},
            {'name':'Church Position'},
            {'name':'Company Name'},
            {'name':'Company Position'}
        ]

    const setSameAddress = ref(false)
    const addedCustomization = reactive([])

    const isOpen = ref(false)

    const openModal = () => {
        isOpen.value = true
    }
    const closeModal = () => {
        isOpen.value = false
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
                <div class="flex flex-col gap-2 mt-3">
                    <BreezeLabel value="Billing Address" class="text-gray-500 leading-0 font-bold" />
                    <div class="flex gap-3 items-center justify-end">
                        <BreezeLabel value="Set my address as billing address" class="text-gray-400 leading-0" />
                        <Switch @change="setSameAddress" v-model="setSameAddress" :class="setSameAddress ? 'bg-gray-600' : 'bg-gray-400'" class="relative inline-flex h-5 w-11 rounded-full">
                            <span :class="setSameAddress ? 'translate-x-6' : 'translate-x-1'" class="inline-block h-5 w-5 transform rounded-full bg-white transition" />
                        </Switch>
                    </div>
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
            <div class="flex flex-col gap-5 mt-5 bg-gray-100 p-5">
                <BreezeLabel value="Add Form Customization" class="text-gray-500 leading-0 font-bold" />
                <Multiselect
                    v-model="addedCustomization"
                    mode="tags"
                    @input=""
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
                <button type="button"
                    @click="isOpen=false"
                    class="inline-flex justify-center uppercase rounded-sm border bg-gray-400 px-4 py-2 text-xs font-bold text-white hover:bg-gray-500">
                    CLOSE
                </button>
                <button type="button"
                    class="inline-flex justify-center uppercase rounded-sm border bg-blue-500 px-4 py-2 text-xs font-bold text-white hover:bg-blue-400">
                    SAVE CHANGES
                </button>
            </div>
        </template>
    </MainModal>
</template>
