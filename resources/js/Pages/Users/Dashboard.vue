<script setup>
    import { Head } from '@inertiajs/inertia-vue3';
    import AuthenticatedUserLayout from '@/Layouts/User/AuthenticatedUser.vue';

    const headerTitle = "Dashboard - User Portal"

    const props = defineProps({
        errors: Object
    })

</script>

<template>
    <Head>
        <title>
            {{ headerTitle }}
        </title>
    </Head>
    <AuthenticatedUserLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between gap-8">
                <div class="rounded-lg w-1/4 bg-white border p-18"></div>
                <div class="rounded-lg w-3/4 bg-white border flex flex-col p-8 gap-6">
                    <template v-for="x in [1,2,3,4,5,6,7,8,9.10]">
                        <div class="rounded-lg border bg-white w-full p-16 shadow-md hover:bg-gray-100">
                        </div>
                    </template>
                </div>


            </div>
        </div>
    </AuthenticatedUserLayout>
</template>
