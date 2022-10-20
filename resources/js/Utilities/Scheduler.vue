<script setup>
    import { reactive, ref } from 'vue';
    import BreezeInput from '@/Components/Input.vue';

    // default event schedule
    let schedules = reactive([{startDate:'', startTime:'', endTime:''}]);

    const finalSchedule = ref([])

    // init custom events
    const emit = defineEmits(['getSchedules'])

    // Default schedule set
    const addSchedule = async() => {
        finalSchedule.value = schedules
        schedules.push({startDate:'', startTime:'', endTime:''})
        await emit('getSchedules', schedules)
    }

    //remove schedule function
    const removeSchedule = (selected) => {
        let selectedIdx = schedules.indexOf(selected,0)
        schedules.splice(selectedIdx,1)
    }


</script>

<template>
    <div class="flex flex-col p-6">
        <div class="flex gap-2 justify-between mb-4">
            <h5 class="font-bold text-xl text-gray-600">Schedule Details</h5>
            <svg
                @click="addSchedule()"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="w-8 h-8 text-blue-500 hover:text-blue-400 cursor-pointer">
                <path fill-rule="evenodd"
                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z"
                clip-rule="evenodd" />
            </svg>
        </div>
        <div v-for="(schedule, indx) in schedules" class="flex gap-3 my-3 items-end justify-between">
            <div class="w-full">
                <p v-if="schedules.length > 1">Session {{indx+1}}:</p>
                <p>Start Date</p>
                <BreezeInput required type="date" class="w-full rounded-none" placeholder="Start Date" v-model="schedule.startDate" />
            </div>
            <div class="w-full">
                <p>Start Time</p>
                <BreezeInput required type="time" class="w-full rounded-none" v-model="schedule.startTime" />
            </div>
            <div class="w-full">
                <p>End Time</p>
                <BreezeInput required type="time" class="w-full rounded-none" v-model="schedule.endTime" />
            </div>
            <div class="pb-3">
                <svg v-if="indx > 0"
                    @click="removeSchedule(schedule)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="w-5 h-5 text-red-400 hover:text-red-500 cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
        </div>
    </div>
</template>
