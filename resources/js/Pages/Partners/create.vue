<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

    import BreezeButton from '@/Components/Button.vue';
    import BreezeInput from '@/Components/Input.vue';

    defineProps({
        partners: Object
    });

    const form = useForm({
        name: null,
        description: null,
        websiteUrl: null,
    });

    const submit = () => {
        form.post(route('partners.store'), {
            // onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };

</script>

<script>
export default {
    data() {
        return {
            isOpen:false,
            }
    },
    created() {
    },
    methods: {    
        openModal(e) {
            this.isOpen=true;
        },
        closeModal(e){
            this.isOpen=false;
        },
        createPartner(e){
            this.form.post(route('partners.store'), {
            });
            this.isOpen=false;
            location.reload();
        }
    }
}
</script>

<template>
    <Head title="Create Partner"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Create New Partner</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" class="mb-8">
                            <div class="">
                                <br>

                                <div class="grid grid-cols-8 gap-4">
                                    <div class="col-span-4">
                                        <BreezeInput id="name" type="text" class="block w-full rounded-none" placeholder="Name" v-model="form.name" required autofocus autocomplete="name" /><br>
                                        <BreezeInput id="description" type="text" class="block w-full rounded-none" placeholder="Description" v-model="form.description" required autofocus autocomplete="description" /><br>
                                        <BreezeInput id="websiteUrl" type="text" class="block w-full rounded-none" placeholder="Website Url" v-model="form.websiteUrl" required autofocus autocomplete="websiteUrl" /><br>
                                        
                                        <BreezeButton class="rounded-none" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Create</BreezeButton>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
