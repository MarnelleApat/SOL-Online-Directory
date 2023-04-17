<script setup>
    import toDate from '@/Helpers/StringToDate'
    import toJSON from '@/Helpers/StringToJson'
    import currency from '@/Helpers/formatCurrency'
    import BreezeDropdown from '@/Components/Dropdown.vue';
    import moment from 'moment'

    defineProps({
        event: Object
    })

</script>

<template>
    <div class="border border-gray-400/60 shadow-md rounded-lg min-w-1/4 min-h-[300px] bg-white">
        <img :src="event.thumbnail" class="w-full h-[180px] object-top object-cover rounded-t-lg" />
        <div class="p-4 flex flex-col flex-nowrap gap-3 min-h-[250px]">
            <h1 class="text-lg font-bold leading-none h-[40px] overflow-x-hidden text-left text-gray-500">
                {{ event.title }}
            </h1>
            <span
                class="rounded-full text-white border text-center text-xs w-2/5"
                :class="{'bg-green-600': event.type==='Online', 'bg-yellow-600': event.type==='Physical', 'bg-violet-600': event.type==='Hybrid'}">
                {{ event.type }}
            </span>
            <div class="flex flex-col gap-1">
                <div class="flex justify-start items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 19" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>&nbsp;
                    <div class="flex flex-col gap-5 text-left">
                        <div v-if="event.type=='Online'">
                            <!-- <p class="text-slate-500 text-sm leading-none font-bold">Online Details</p> -->
                            <a :href="toJSON(event.venue).url" class="text-blue-500 text-xs leading-none">{{toJSON(event.venue).url}}</a>
                        </div>
                        <div v-else-if="event.type=='Physical'">
                            <!-- <p class="text-slate-500 text-sm leading-none font-bold">Venue:</p> -->
                            <p class="text-gray-800 text-xs leading-none">
                                {{toJSON(event.venue).location}} {{toJSON(event.venue).city}} {{toJSON(event.venue).postalcode}}
                            </p>
                        </div>
                        <template v-else>
                            <div>
                                <span class="text-gray-800 text-xs leading-none">URL:</span> <a :href="toJSON(event.venue).url" class="text-blue-500 text-xs leading-0 overflow-x-scroll">{{toJSON(event.venue).url}}</a>
                                <p class="text-gray-800 text-xs leading-0">
                                    {{toJSON(event.venue).location}} {{toJSON(event.venue).city}} {{toJSON(event.venue).postalcode}}
                                </p>
                            </div>
                        </template>
                    </div>

                </div>

                <div v-if="event.schedules.length" class="flex items-center justify-start space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sm" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    <BreezeDropdown v-if="event.schedules.length > 1" align="center">
                        <template #trigger>
                            <p class="text-xs inline-flex">
                                {{toDate(event.schedules[0].date, 'll')}} @ {{moment(event.schedules[0].startTime, 'HH:mm').format('LT')}}-{{moment(event.schedules[0].endTime, 'HH:mm').format('LT')}}
                                <svg v-if="event.schedules.length > 1" class="h-5 w-5 cursor-pointer opacity-70" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </p>
                        </template>

                        <template #content>
                            <div class="w-[230px] h-[100px] bg-white border shadow-lg rounded-md p-2 overflow-y-scroll">
                                <div class="flex flex-col text-left">
                                    <template v-for="(schedule,indx) in event.schedules">
                                        <div class="mb-2">
                                            <p class="text-gray-800 text-xs leading-0 italic">Session {{indx+1}}</p>
                                            <p class="text-gray-800 text-xs leading-0">
                                                {{toDate(schedule.date, 'll')}} @ {{moment(schedule.startTime, 'HH:mm').format('LT')}}-{{moment(schedule.endTime, 'HH:mm').format('LT')}}
                                            </p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </BreezeDropdown>
                    <p v-else class="text-xs inline-flex">
                        <!-- {{event.schedules}} -->
                        <svg v-if="event.schedules.length > 1" class="h-5 w-5 cursor-pointer opacity-70" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        {{toDate(event.schedules[0].date, 'll')}} @ {{moment(event.schedules[0].startTime, 'HH:mm').format('LT')}}-{{moment(event.schedules[0].endTime, 'HH:mm').format('LT')}}
                    </p>
                </div>
            </div>


            <div class="inline-flex gap-2 justify-between mt-auto">
                <button type="button" class="bg-teal-500 hover:bg-teal-600 shadow-sm text-white text-xs py-3 font-bold leading-none w-1/2 uppercase">{{ event.totalRegistrants }}/{{ event.limit }} seats</button>
                <a :href="route('singleEvent.public', event.slug)" :class="{ 'bg-gray-600 hover:bg-gray-500':event.price > 0, 'bg-yellow-500 hover:bg-yellow-400': event.price <= 0}" class="shadow-sm text-white text-xs py-3 w-1/2 font-bold leading-none">{{ event.price > 0 ? currency(event.price) : 'FREE' }}</a>
            </div>
        </div>
    </div>
</template>
