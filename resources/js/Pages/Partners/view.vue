<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
    import BreezeInput from '@/Components/Input.vue';
    import BreezeTextarea from '@/Components/Textarea.vue';
    import BreezeInputError from '@/Components/InputError.vue';
    import BreezeLabel from '@/Components/Label.vue';
    import BreezeButton from '@/Components/Button.vue';
    import { reactive, ref } from 'vue';
    import { Inertia } from '@inertiajs/inertia'
    import { Switch } from '@headlessui/vue'

   const props =  defineProps({
        partners: Object,
        status: null,
        errors:Object
    });

    const form = reactive({
        name: props.partners.name,
        description: props.partners.description,
        websiteUrl: props.partners.websiteUrl,
        slug: props.partners.slug,
        status: (props.status==1)?true:false
    });

    let successNotif = ref(false);

    const submit = () => {
        Inertia.put('/partners/update', form,{
            onSuccess:res => {
                successNotif.value=true;
            },
            onError: errors => {
                //
            },
        })
    };

    setTimeout(()=>{
        successNotif.value = false;
    },10000);


</script>

<template>
    <Head title="Partners" />

    <BreezeAuthenticatedLayout>

        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Partners</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-row gap-4">
                    <div class="w-3/4">
                        <div class="flex flex-col gap-4">

                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 relative mb-5" role="alert" v-if="successNotif">
                                <p class="font-bold mb-2">Success</p>
                                <p>Partners Successfully Updated !</p>
                                <button v-on:click="successNotif = !successNotif">
                                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title>
                                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                                        </svg>
                                    </span>
                                </button> 
                            </div>

                            <div class="bg-white overflow-hidden shadow-sm border ring-opacity-75 p-4">
                                <form @submit.prevent="submit">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="flex flex-col p-6">
                                            <h5 class="font-bold text-xl text-gray-600 mb-6">Details</h5>
                        

                                            <div class="flex flex-col gap-2">
                                                <BreezeLabel for="name" value="Name" class="flex items-center font-bold" />
                                                <BreezeInput id="name" type="text" class="mt-1 block w-full rounded-none" placeholder="Name" v-model="form.name" autofocus autocomplete="name" required/>
                                                <BreezeInputError class="mt-2" v-if="errors.name" :message="errors.name"/>
                                            </div>

                                            <div class="flex flex-col gap-2 mt-6">
                                                <BreezeLabel for="websiteUrl" value="Website Url" class="flex items-center font-bold" />
                                                <BreezeInput id="websiteUrl" type="text" class="mt-1 block w-full rounded-none" placeholder="Website Url" v-model="form.websiteUrl" autofocus autocomplete="websiteUrl" required />
                                                <BreezeInputError class="mt-2" v-if="errors.websiteUrl" :message="errors.websiteUrl" />
                                            </div>

                                            <div class="flex flex-col gap-2 mt-6">
                                                <BreezeLabel for="desc" value="Description" class="flex items-center font-bold" />
                                                <BreezeTextarea id="desc" rows="6" class="mt-1 block w-full rounded-none" placeholder="Description" v-model="form.description" autofocus autocomplete="description" required />
                                                <BreezeInputError class="mt-2" v-if="errors.description" :message="errors.description"/>
                                            </div>

                                            <div class="flex flex-col gap-2 mt-6">
                                                <BreezeLabel for="status" value="Account Status" class="flex items-center font-bold mb-2" />
                                                <Switch
                                                    id="status"
                                                    v-model="form.status"
                                                    :class="form.status ? 'bg-orange-500' : 'bg-gray-400'"
                                                    class="relative inline-flex h-6 w-11 items-center rounded-full"
                                                >
                                                    <span 
                                                    :class="form.status ? 'translate-x-6' : 'translate-x-1'"
                                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition"
                                                    />
                                                </Switch>
                                                <BreezeInputError class="mt-2" />
                                                
                                            </div>
                                            <div class="flex flex-col gap-2 mt-10">
                                                <BreezeButton class="inline-flex w-1/4 justify-center border border-transparent sm:text-sm rounded-none" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Update</BreezeButton>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>