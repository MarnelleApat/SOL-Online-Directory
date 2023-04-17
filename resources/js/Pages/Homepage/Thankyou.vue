<script setup>
    import AuthenticatedUserLayout from '@/Layouts/User/AuthenticatedUser.vue'
    import { Head } from '@inertiajs/inertia-vue3'
    import Spinner from '@/Utilities/Spinner.vue'

    defineProps({
        orders: Object
    })

</script>

<template>
    <Head title="Thank You"></Head>
    <AuthenticatedUserLayout>
        <div class="max-w-6xl mx-auto px-6 md:px-10 lg:px-8 py-12">
            <h2 class="text-4xl font-bold text-green-700 mt-5">Thank you for participating to this event</h2>
            <p class="italic text-gray-600 mb-5 text-md leading-tight">Note: Please double check all the items listed below before proceed to payment</p>

            <pre>{{ orders }}</pre>
        </div>
    </AuthenticatedUserLayout>
</template>
<style>
</style>
