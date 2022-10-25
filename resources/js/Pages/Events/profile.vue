<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import { reactive, ref, watch } from 'vue';
    import toJSON from '@/Helpers/StringToJson'
    import toDate from '@/Helpers/StringToDate'
    import currency from '@/Helpers/formatCurrency'
    import categories from '@/Utilities/Categories.vue'
    import MediaDialog from '@/Utilities/MediaDialog.vue'
    import EditRecordModal from '@/Utilities/EditRecordDialog.vue'
    import moment from 'moment'
    import { createToaster } from '@meforma/vue-toaster'

    const toaster = createToaster({
            dismissible: true,
            duration: 2000
        })

    const props = defineProps({
        event: Object
    })

    let event = reactive(props.event)

    const getBanner = ref('')
        // Emit (event) for Banner
    const getSeletedBanner = async (emitedBanner) => {
        getBanner.value = emitedBanner
        await updateImage('banner', emitedBanner)
    }

    const getPhoto = ref('')
    // Emit (event) for Photo Image
    const getSeletedImage = async (emitedImage) => {
        getPhoto.value = emitedImage
        await updateImage('thumbnail', emitedImage)

    }

    const v = toJSON(event.venue);

    // Update Banner/Photo Image
    function updateImage(colName, newImage) {
        axios.post(route('updateEventRecord.api'), { event_id: event['id'], columnName: colName, newData: newImage })
            .then(() => {
                toaster.success('Image updated successfully.')
            })
            .catch((error) => {
                toaster.error(error.message+'. Please contact administrator')
            })
    }

    const updateRecord = (emitedRecord) => {
        toaster.success('Record updated successfully.')
        setTimeout(() => {
            window.location.reload()
        }, 2000)
    }

</script>
<template>
    <Head title="Event Profile" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Event Profile</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex gap-6">
                    <div class="w-1/4">
                        <div class="flex flex-col justify-center gap-10">
                            <div class="flex flex-col">
                                <div class="flex mb-2 relative">
                                    <div class="w-56 h-12 bg-gray-100 opacity-75 absolute bottom-0 z-10 flex justify-center font-bold text-xs pt-2 text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                        Change Photo
                                    </div>
                                    <MediaDialog @selected-image="getSeletedImage">
                                        <template #title>Change Image Photo</template>
                                        <template #button>
                                            <img :src="getPhoto.file_name ? getPhoto.file_name : event.thumbnail" class="rounded-full h-56 w-56 hover:opacity-75 cursor-pointer" />
                                        </template>
                                    </MediaDialog>
                                </div>
                            </div>

                            <div class="flex flex-col">
                                <div class="flex items-baseline space-x-2">
                                    <span class="text-gray-400 leading-0 text-md">Registration Fee:</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600 hover:text-blue-400 cursor-pointer">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                </div>
                                <p class="hover:text-orange-400 uppercase tracking-tight text-2xl text-orange-500 font-bold">
                                    {{event.price > 0 ? currency(event.price) : 'FREE'}}
                                </p>
                            </div>
                            <div class="flex flex-col bg-white p-5 border gap-10 h-screen relative">
                                <div class="flex flex-col">
                                    <div class="flex items-baseline space-x-2 mb-3">
                                        <span class="te/150/000000/FFFFFF/xt-gray-400 leading-0 text-md">Categories:</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600 hover:text-blue-400 cursor-pointer">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </div>
                                    <categories :categories="event.categories" />
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-gray-400 leading-0 text-md">Registered participants:</span>
                                    <p class="hover:text-orange-400 uppercase tracking-tight text-2xl text-orange-500 font-bold">
                                        {{event.totalRegistrants}}
                                    </p>
                                </div>
                                <div class="flex flex-col gap-3 absolute bottom-4">
                                    <button class="w-full text-white bg-green-600 hover:bg-green-500 py-3 px-4 font-semibold flex justify-start items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                        </svg>&nbsp;
                                        Promo Offers
                                    </button>
                                    <button class="w-full text-white bg-blue-600 hover:bg-blue-500 py-3 px-4 font-semibold flex justify-start items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                        </svg>&nbsp;
                                        Custom Registration Form
                                    </button>
                                    <button class="w-full text-white bg-slate-600 hover:bg-slate-500 py-3 px-4 font-semibold flex justify-start items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>&nbsp;
                                        Additional Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-3/4">
                        <div class="flex flex-col">

                            <MediaDialog @selected-image="getSeletedBanner">
                                <template #title>Change Banner Photo</template>
                                <template #button>
                                    <div class="flex mb-2 cursor-pointer relative justify-center">
                                        <div class="w-full bg-gray-100 opacity-75 absolute bottom-0 z-10 flex justify-center items-center font-bold text-xs py-2 text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                            </svg>
                                            Change Banner
                                        </div>
                                        <img :src="getBanner.file_name ? getBanner.file_name : event.banner" class="w-full h-56 hover:opacity-75 rounded-xl" />
                                    </div>
                                </template>
                            </MediaDialog>

                            <div class="uppercase tracking-wide text-sm text-orange-500 font-bold my-5">
                                Code: <span class="hover:text-orange-300">{{event.programCode}}</span>
                            </div>

                            <h2 class="text-4xl font-bold leading-0 flex items-baseline gap-3">
                                {{event.title}}
                                <EditRecordModal :recordValue="event.title" colName="title" :event_id="event.id" @success-update="updateRecord">
                                    <template #button>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600 hover:text-blue-400 cursor-pointer">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </template>
                                </EditRecordModal>
                            </h2>
                            <p class="text-sm italic text-gray-400">Published last {{toDate(event.created_at, 'LL')}}</p>
                            <p v-if="event.activeUntil" class="text-sm italic text-gray-400 flex items-baseline gap-3">
                                Event registration active until {{toDate(event.activeUntil, 'LL')}}
                                <EditRecordModal :recordValue="event.activeUntil" colName="activeUntil" :event_id="event.id" @success-update="updateRecord">
                                    <template #button>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600 hover:text-blue-400 cursor-pointer">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </template>
                                </EditRecordModal>
                            </p>

                            <div class="flex flex-col bg-white p-5 mt-3 border">
                                <div class="">
                                    <p class="text-gray-400 leading-0 text-md flex items-baseline gap-3">
                                        About:
                                        <EditRecordModal :recordValue="event.description" colName="description" :event_id="event.id" @success-update="updateRecord">
                                            <template #button>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600 hover:text-blue-400 cursor-pointer">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                </svg>
                                            </template>
                                        </EditRecordModal>
                                    </p>
                                    <p class="p-3">
                                        {{event.description}}
                                    </p>
                                </div>
                                <div class="mt-14">
                                    <p class="text-gray-400 leading-0 text-md flex items-baseline gap-3">
                                        Date:
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600 hover:text-blue-400 cursor-pointer">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </p>
                                    <p v-for="(sched, idx) in event.schedules" class="leading-relaxed px-3">
                                        <span v-if="event.schedules.length > 1">Session {{idx+1}}:</span>
                                        {{toDate(sched.date, 'LL')}} @ {{moment(sched.date+' '+sched.startTime).format('hh:mm A')}} - {{moment(sched.date+' '+sched.endTime).format('hh:mm A')}}
                                    </p>
                                </div>

                                <div class="mt-14">
                                    <p class="text-gray-400 leading-0 text-md flex items-baseline gap-3">
                                        {{ event.type=='Online' ? 'Online Event Platform' : 'Venue' }}
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600 hover:text-blue-400 cursor-pointer">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </p>
                                    <p v-if="event.type=='Online'" class="leading-relaxed px-3">
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
                                    <p class="leading-relaxed px-3 flex items-baseline gap-2">
                                        Contact Email:
                                        <span class="font-bold">{{event.email}}</span>
                                        <EditRecordModal :recordValue="event.email" colName="email" :event_id="event.id" @success-update="updateRecord">
                                            <template #button>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600 hover:text-blue-400 cursor-pointer">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                </svg>
                                            </template>
                                        </EditRecordModal>
                                    </p>
                                    <p class="leading-relaxed px-3 flex items-baseline gap-2">
                                        Event Incharge:
                                        <span class="capitalize font-bold">{{event.eventIncharge}}</span>
                                        <EditRecordModal :recordValue="event.eventIncharge" colName="eventIncharge" :event_id="event.id" @success-update="updateRecord">
                                            <template #button>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600 hover:text-blue-400 cursor-pointer">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                </svg>
                                            </template>
                                        </EditRecordModal>
                                    </p>
                                    <p class="leading-relaxed px-3 flex items-baseline gap-2">
                                        Cheque name to<i>(for check payment)</i>:
                                        <span class="capitalize font-bold">{{event.checkHandler}}</span>
                                        <EditRecordModal :recordValue="event.checkHandler" colName="checkHandler" :event_id="event.id" @success-update="updateRecord">
                                            <template #button>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600 hover:text-blue-400 cursor-pointer">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                </svg>
                                            </template>
                                        </EditRecordModal>
                                    </p>
                                </div>

                                <div v-if="event.speakers.length" class="mt-14">
                                    <h3 class="text-gray-400 leading-0 text-md flex items-baseline gap-3">
                                        {{event.speakers.length > 1 ? 'Speakers:' : 'Speaker:'}}
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600 hover:text-blue-400 cursor-pointer">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </h3>

                                    <div class="grid grid-cols-5 gap-3 my-4">
                                        <div class="flex flex-col justify-center items-center" v-for="speaker in event.speakers">
                                            <img :src="speaker.profileImg" class="rounded-full h-28 mb-2" />
                                            <p class="font-bold text-gray-500 text-md">{{ speaker.name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-300 leading-0 text-sm">Event created by: {{event.user.niceName}}</span>
                    <!-- <pre>{{event}}</pre> -->
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
