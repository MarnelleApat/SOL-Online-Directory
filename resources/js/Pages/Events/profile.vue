<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import toJSON from '@/Helpers/StringToJson'
    import toDate from '@/Helpers/StringToDate'
    import currency from '@/Helpers/formatCurrency'
    import categories from '@/Utilities/Categories.vue'

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
                        <div class="flex flex-col justify-center gap-10">
                            <img :src="props.event.thumbnail" class="rounded-full h-56 w-56" />
                            <div class="flex flex-col">
                                <span class="text-gray-400 leading-0 text-md">Registration Fee:</span>
                                <p class="hover:text-orange-400 uppercase tracking-tight text-2xl text-orange-500 font-bold">
                                    {{props.event.price > 0 ? currency(props.event.price) : 'FREE'}}
                                </p>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-center mb-3">
                                    <span class="text-gray-400 leading-0 text-md">Categories:</span>
                                    <span class="text-blue-600 hover:text-blue-400 leading-0 text-sm px-3 italic cursor-pointer">(Edit)</span>
                                </div>
                                <categories :categories="props.event.categories" />
                            </div>
                            <div class="flex flex-col">
                                <span class="text-gray-400 leading-0 text-md">Registered participants:</span>
                                <p class="hover:text-orange-400 uppercase tracking-tight text-2xl text-orange-500 font-bold">
                                    {{props.event.totalRegistrants}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="w-3/4">
                        <div class="flex flex-col">
                            <img :src="props.event.banner" class="w-full h-48" />
                            <div class="uppercase tracking-wide text-sm text-orange-500 font-bold my-5">
                                Code: <span class="hover:text-orange-300">{{props.event.programCode}}</span>
                            </div>

                            <h2 class="text-4xl font-bold leading-0">{{props.event.title}}</h2>
                            <p class="text-sm italic text-gray-400">Published last {{toDate(props.event.created_at, 'LL')}}</p>
                            <p v-if="props.event.activeUntil" class="text-sm italic text-gray-400">Event registration active until {{toDate(props.event.activeUntil, 'LL')}}</p>

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

                            <div class="mt-14">
                                <p class="text-gray-400 leading-0 text-md">Additional Details:</p>
                                <p class="leading-relaxed px-3">Contact Email: <span class="font-bold">{{props.event.email}}</span></p>
                                <p class="leading-relaxed px-3">Contact Person <i>(Event Incharge)</i>: <span class="capitalize font-bold">{{props.event.eventIncharge}}</span></p>
                                <p class="leading-relaxed px-3">For cheque payment <i>(Cheque name to)</i>: <span class="capitalize font-bold">{{props.event.checkHandler}}</span></p>
                            </div>

                            <div v-if="props.event.speakers.length" class="mt-14">
                                <h3 class="text-gray-400 leading-0 text-md">{{props.event.speakers.length > 1 ? 'Speakers:' : 'Speaker:'}}</h3>

                                <div class="grid grid-cols-5 gap-3 my-4">
                                    <div class="flex flex-col justify-center items-center" v-for="speaker in props.event.speakers">
                                        <img :src="speaker.profileImg" class="rounded-full h-28 mb-2" />
                                        <p class="font-bold text-gray-500 text-md">{{ speaker.name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="flex">
                    <span class="text-gray-300 leading-0 text-sm">Event created by: {{props.event.user.niceName}}</span>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
