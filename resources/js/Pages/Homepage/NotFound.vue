<script setup>
    import AuthenticatedUserLayout from '@/Layouts/User/AuthenticatedUser.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import SearchInput from '@/Components/Input.vue';

    // const event = props.events
    const headerTitle = 'Page Not Found - Streams Of Life'

</script>

<template>
    <Head :title="headerTitle"></Head>

    <AuthenticatedUserLayout>
        <div class="min-h-xl p-10 bg-gradient-to-r from-gray-300 via-slate-300 to-gray-300 ">
            <div class="max-w-6xl mx-auto h-[200px] flex justify-center items-center">

                <span class="text-gray-600/50 text-3xl font-bold leading-tight">
                    <span class="font-bold text-gray-500 text-4xl">Oops!...</span>
                    Seems like you cannot find what you are looking for.
                </span>
            </div>
        </div>
        <div class="max-w-6xl mx-auto flex flex-col justify-center items-center mt-10 gap-4">
            <p class="text-gray-400 text-xl">You can use search to find what you are looking for.</p>
            <SearchInput id="search" type="search" class="rounded-none py-4 text-lg shadow-lg block w-3/4"  placeholder="Search..." required />
        </div>
    </AuthenticatedUserLayout>
</template>


