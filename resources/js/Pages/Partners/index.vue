<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

    import BreezeButton from '@/Components/Button.vue';
    import BreezeInput from '@/Components/Input.vue';
    import BreezeTextarea from '@/Components/Textarea.vue';
    import BreezeInputError from '@/Components/InputError.vue';
    import BreezeLabel from '@/Components/Label.vue';
    import paginator from '@/Utilities/Paginator.vue'
    import { reactive, ref } from 'vue';
    import { Inertia } from '@inertiajs/inertia'
   import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'

    defineProps({
        partners: Object,
        isOpen:Boolean
    });

    const form = useForm({
        name: null,
        description: null,
        websiteUrl: null,
    });

    const submit = (isOpen) => {
        Inertia.post('/partners/store', form)
        form.reset('name','description','websiteUrl');
    };

</script>

<template>
    <Head title="Events" />

    <BreezeAuthenticatedLayout>

        <TransitionRoot as="template" :show="isOpen">
            <Dialog as="div" class="relative z-10" @close="isOpen = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <form @submit.prevent="submit">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="flex flex-col p-6">
                                        <h5 class="font-bold text-xl text-gray-600 mb-6">Partner Details</h5>
                                        <div class="flex flex-col gap-2">
                                            <BreezeLabel for="name" value="Name" class="flex items-center font-bold" />
                                            <BreezeInput id="name" type="text" class="mt-1 block w-full rounded-none" placeholder="Name" v-model="form.name" required />
                                            <BreezeInputError class="mt-2" />
                                        </div>

                                        <div class="flex flex-col gap-2 mt-6">
                                            <BreezeLabel for="websiteUrl" value="Website Url" class="flex items-center font-bold" />
                                            <BreezeInput id="websiteUrl" type="text" class="mt-1 block w-full rounded-none" placeholder="Website Url" v-model="form.websiteUrl" required />
                                            <BreezeInputError class="mt-2" />
                                        </div>

                                        <div class="flex flex-col gap-2 mt-6">
                                            <BreezeLabel for="desc" value="Description" class="flex items-center font-bold" />
                                            <BreezeTextarea id="desc" rows="6" class="mt-1 block w-full rounded-none" placeholder="Description" v-model="form.description" required />
                                            <BreezeInputError class="mt-2" />
                                        </div>
                                    </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <BreezeButton class="mt-3 inline-flex w-full justify-center border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm rounded-none" @click="isOpen=false">Cancel</BreezeButton>
                                <BreezeButton class="inline-flex w-full justify-center border border-transparent sm:ml-3 sm:w-auto sm:text-sm rounded-none" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Create</BreezeButton>
                            </div>
                        </form>
                    </DialogPanel>
                </TransitionChild>
                </div>
            </div>
            </Dialog>
        </TransitionRoot>
    
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Partners</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- searching feature -->
                <div class="grid grid-cols-4 gap-10">
                    <!-- card for ADD NEW -->
                    <a href="#" @click="isOpen=true">
                        <div class="group">
                            <div class="min-h-[330px] w-full mx-auto bg-gray-200 hover:bg-gray-300 border shadow-sm sm:rounded-lg p-4 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-14 h-14 text-gray-400 group-hover:text-gray-100 font-black">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </div>
                        </div>
                    </a>

                    <div v-for="partner in partners.data" class="min-h-[200px] w-full bg-white border shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="uppercase tracking-wide text-xs text-orange-500 hover:text-orange-300 font-bold">
                                <Link :href="route('partners.view', partner.slug)">
                                    {{partner.name}}
                                </Link> . 
                        </div>
                            <Link :href="route('partners.view', partner.id)" class="block mt-1 text-lg font-bold leading-tight text-gray-500 hover:text-gray-400">
                                
                                {{partner.description}}
                            </Link>
                            <br>
                            <p class="mt-2 text-slate-500">
                                Website link: 
                                <span class="text-red-800">
                                    <Link :href="partner.websiteUrl" target="_blank">
                                        {{ partner.websiteUrl }}
                                    </Link>
                                </span>
                            </p>
                        </div>
                    </div>

                </div>
                <paginator :links="partners.links" />
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>