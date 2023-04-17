<script setup>
    import { onMounted, reactive, watch } from 'vue';
    import BreezeTextarea from '@/Components/Textarea.vue'
    import { Switch } from '@headlessui/vue'

    const props = defineProps({
        getPaymentMode: Array
    })

    // get the saved payment mode
    const getpaymode = props.getPaymentMode

    // init schedule
    let paymode = reactive([]);

    onMounted(() => {
        if(getpaymode.length)
        {
            getpaymode.forEach((value) => { paymode.push(value) })
        }
        else
        {
            paymode.push({type:'Free', details:'N/A', status:true})
        }
    })

    // init custom emit
    const emit = defineEmits(['getPaymentMode'])

    // Default payment mode set
    const addPaymentMode = () => {
        paymode.push({type:'Free', details:'N/A', status:true})
    }

    //remove payment mode function
    const removePaymentMode = (selected) => {
        let selectedIdx = paymode.indexOf(selected,0)
        paymode.splice(selectedIdx,1)
    }

    // Trigger emit event if any changes in the schedule
    watch(paymode, (newValue) => emit('getPaymentMode', newValue), { immediate: true })

</script>

<template>
    <div class="flex flex-col">
        <!-- {{getSched}} -->
        <div class="flex gap-2 justify-between mb-4">
            <h5 class="font-bold text-md text-gray-600">Set up Payment mode</h5>
            <svg
                @click="addPaymentMode()"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="w-7 h-7 text-green-600 hover:text-green-700/80 cursor-pointer">
                <path fill-rule="evenodd"
                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z"
                clip-rule="evenodd" />
            </svg>
        </div>
        <div v-for="(pmode, indx) in paymode" class="flex gap-3 my-3">
            <div class="w-1/3">
                <div class="flex items-center gap-1">
                    <svg v-if="indx > 0"
                        @click="removePaymentMode(pmode)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="w-7 h-7 text-red-600 hover:text-red-500 cursor-pointer">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <template v-else>
                        <div class="w-7"></div>
                    </template>
                    <!-- <p class="text-gray-600">Type</p> -->
                    <select v-model="pmode.type" class="w-full rounded-none text-gray-600">
                        <option value="Free">Free</option>
                        <option value="stripe">Stripe Credit/Debit Card</option>
                        <option value="cheque">Cheque Payment</option>
                    </select>
                </div>
            </div>
            <div class="w-2/3 flex gap-4 items-center justify-between">
                <div class="w-full">
                    <!-- <p class="text-gray-600">Payment Details</p> -->
                    <BreezeTextarea rows="1" required type="time" class="w-full rounded-none text-gray-600" v-model="pmode.details" />
                </div>
                <div class="text-right">
                    <!-- <p class="text-gray-600">Status</p> -->
                    <Switch v-model="pmode.status" :class="pmode.status ? 'bg-orange-500' : 'bg-gray-400'" class="relative inline-flex h-6 w-11 items-center rounded-full">
                        <span :class="pmode.status ? 'translate-x-6' : 'translate-x-1'" class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                    </Switch>
                </div>
                <!-- <svg v-if="indx > 0"
                    @click="removePaymentMode(pmode)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="w-7 h-7 text-red-600 hover:text-red-500 cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg> -->
            </div>
        </div>
    </div>
</template>
