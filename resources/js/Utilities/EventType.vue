<script setup>
    import BreezeInput from '@/Components/Input.vue';
    import BreezeLabel from '@/Components/Label.vue';
    import BreezeInputError from '@/Components/InputError.vue';
    import Multiselect from '@vueform/multiselect'
    import { reactive, ref, watch } from 'vue';

    const emit = defineEmits(['getEventType'])
    const props = defineProps({
        getEventType: Array
    })

    const _event = reactive({
        type: props.getEventType[0],
        venue: JSON.parse(props.getEventType[1])
    })
    const eventType = ref([
        {value: "Physical", label: "Phyical"},
        {value: "Online", label: "Online"},
        {value: "Hybrid", label: "Hybrid"},
    ]);

    watch(_event, (newValue) => {
        emit('getEventType', newValue)
    }, {immediate:true})

</script>

<template>
    <div class="flex flex-col p-6">
        <div class="flex flex-col gap-2">
            <BreezeLabel for="type" value="Type of Event" class="flex items-center font-bold" />
            <Multiselect
                required
                v-model="_event.type"
                placeholder="Online or Physical Event"
                :close-on-select="true"
                :options="eventType"
                />
        </div>
        <template v-if="_event.type=='Physical' || _event.type=='Hybrid'">
            <div class="flex flex-col gap-2 mt-6">
                <BreezeLabel for="venue" value="Event Venue or Location" class="flex items-center font-bold" />
                <BreezeInput required id="venue" v-model="_event.venue.location" type="text" class="mt-1 block w-full rounded-none" placeholder="Street / Block / Bldg Address" />
            </div>

            <div class="flex gap-2 mt-2">
                <BreezeInput required v-model="_event.venue.city" type="text" class="mt-1 block w-full rounded-none" placeholder="City" />
                <BreezeInput required v-model="_event.venue.postalcode" type="text" class="mt-1 block w-full rounded-none" min="0" placeholder="Postal Code" />
            </div>
        </template>
        <template v-if="_event.type=='Online' || _event.type=='Hybrid'">
            <div class="flex flex-col gap-2 mt-6">
                <BreezeLabel for="meetingLink" value="Online Event Details" class="flex items-center font-bold" />
                <BreezeInput required id="meetingLink" v-model="_event.venue.url" type="text" class="mt-1 block w-full rounded-none" placeholder="Meeting URL (ex.https://zoom.sg)" />
            </div>
            <div class="flex gap-2 mt-2">
                <BreezeInput required v-model="_event.venue.meetingID" type="text" class="mt-1 block w-full rounded-none" placeholder="Meeting ID" />
                <BreezeInput required v-model="_event.venue.passcode" type="text" class="mt-1 block w-full rounded-none" min="0" placeholder="Meeting Password" />
            </div>
        </template>
    </div>
</template>
