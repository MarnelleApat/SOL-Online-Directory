<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

    import BreezeButton from '@/Components/Button.vue';
    import BreezeInput from '@/Components/Input.vue';

    defineProps({
        partners: Object
    });

    const form = useForm({
        keyword: '',
    });

    const submit = () => {
        form.post(route('/'), {
            // onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };

</script>

<template>
    <Head title="Events" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Partners</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- searching feature -->
                <form @submit.prevent="submit" class="mb-8">
                    <div class="flex flex-cols">
                        <BreezeInput id="keyword" type="text" class="block w-full rounded-none" placeholder="Search Partners" v-model="form.keyword" required autofocus autocomplete="keyword" />
                        <BreezeButton class="ml-4 py-1 rounded-none" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Search</BreezeButton>
                    </div>
                </form>

                <!-- <pre>{{ events.data[0] }}</pre> -->
                <!-- <pre>{{ events.links }}</pre> -->

                <div class="grid grid-cols-4 gap-10">
                    <!-- card for ADD NEW -->
                    <Link :href="route('partners.create')">
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
                    </Link>

                    <div v-for="partner in partners.data" class="min-h-[200px] w-full bg-white border shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="uppercase tracking-wide text-xs text-orange-500 hover:text-orange-300 font-bold">
                                <Link :href="route('event.profile', partner.slug)">
                                    {{partner.name}}
                                </Link>
                            </div>
                            <Link :href="route('event.profile', partner.slug)" class="block mt-1 text-lg font-bold leading-tight text-gray-500 hover:text-gray-400">

                                {{partner.description}}
                            </Link>
                            <br>
                            <p class="mt-2 text-slate-500">
                                Website link: <span class="text-red-800">
                                        <Link :href="partner.websiteUrl" target="_blank">
                                            {{ partner.websiteUrl }}
                                        </Link>
                                    </span>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
