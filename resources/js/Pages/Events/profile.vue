<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import toJSON from '@/Helpers/StringToJson'
    import toDate from '@/Helpers/StringToDate'

    const props = defineProps({
        event: Object
    })

    const schedules = toJSON(props.event.schedule)
    const v =  toJSON(props.event.venue);

</script>

<template>
    <Head title="Event Profile" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Profile</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex gap-4">
                    <div class="w-1/4">
                        <div class="flex justify-center">
                            <img :src="props.event.thumbnail" class="rounded-full h-56 w-56" />
                        </div>
                    </div>
                    <div class="w-3/4">
                        <div class="flex flex-col">
                            <img :src="props.event.banner" class="w-full h-48" />
                            <div class="uppercase tracking-wide text-sm text-orange-500 font-bold my-5">
                                Code: <span class="hover:text-orange-300">{{props.event.programCode}}</span>
                            </div>

                            <h2 class="text-4xl font-bold leading-0">{{props.event.title}}</h2>

                            <div class="mt-14">
                                <p class="text-gray-400 leading-0 text-md">About:</p>
                                <p class="p-3">
                                    {{props.event.description}}
                                </p>
                            </div>
                            <div class="mt-14">
                                <p class="text-gray-400 leading-0 text-md">Date:</p>
                                <p v-for="(sched, idx) in schedules" class="leading-relaxed px-3">
                                    <span v-if="schedules.length > 1">Session {{idx+1}}:</span> {{toDate(sched.startDate, 'LL')}} @ {{sched.startTime}} - {{sched.endTime}}
                                </p>
                            </div>

                            <div class="mt-14">
                                <p class="text-gray-400 leading-0 text-md">{{ props.event.type=='Online' ? 'Online Event Platform' : 'Venue' }}</p>
                                <p v-if="props.event.type=='Online'" class="leading-relaxed px-3">
                                    <p v-if="v.url">Link: {{v.url}}, </p>
                                    <p v-if="v.meetingID">Meeting ID: {{v.meetingID}}, </p>
                                    <p v-if="v.passcode">Pass Code: {{v.passcode}}</p>
                                </p>

                                <p v-else class="leading-relaxed px-3">
                                    <span v-if="v.location">{{v.location}}, </span>
                                    <span v-if="v.city">{{v.city}}, </span>
                                    <span v-if="v.postalcode">{{v.postalcode}}</span>
                                </p>
                            </div>

                            <pre>{{props.event}}</pre>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
