<script setup>
    import AuthenticatedUserLayout from '@/Layouts/User/AuthenticatedUser.vue'
    import { Head } from '@inertiajs/inertia-vue3'
    import currency from '@/Helpers/formatCurrency'
    import BreezeButton from '@/Components/Button.vue';
    import { ref, onMounted } from 'vue';
    import { computed } from '@vue/reactivity'
    import { Inertia } from '@inertiajs/inertia'
    import Spinner from '@/Utilities/Spinner.vue'

    const props = defineProps({
        PaymentType: String,
        items: Object,
        GrandTotal: Number
    })

    const showDisplay = ref(true)
    const timeoutTimer = 1000;

    onMounted(() => {
        setTimeout(() => {
            showDisplay.value = false
        }, timeoutTimer)

    })

    const confirmPayment = () => {

        showDisplay.value = true

        setTimeout(() => {
            showDisplay.value = false
        }, timeoutTimer)

        const data = {
            PaymentType: props.PaymentType,
            items: props.items,
            GrandTotal: props.GrandTotal
        }

        Inertia.post(route('checkout.store'), data,
        {
            preserveScroll: true,
            onSuccess: (response) => {
                console.log(response)
                showDisplay.value = true
            },
            onError: errors => {
                console.log(errors)
                showDisplay.value = true
            }
        })
    }

</script>

<template>
    <Head title="Confirm Checkout"></Head>
    <AuthenticatedUserLayout>
        <Spinner v-if="showDisplay" />
        <div v-else class="min-h-xl p-10 bg-gradient-to-r from-gray-100/70 via-slate-300/40 to-gray-100/70">
            <div class="max-w-6xl mx-auto px-6 md:px-10 lg:px-8">
                <h2 class="text-4xl font-bold text-gray-600 mt-5">Confirm Checkout</h2>
                <p class="italic text-gray-600 mb-5 text-md leading-tight">
                    Note: Please double check all the items listed below before proceed to payment
                </p>
                <div class="flex gap-5">
                    <div class="w-3/4 bg-white shadow-md">
                        <div v-for="(event, index) in items" :key="index" class="overflow-x-scroll sm:overflow-x-scroll md:overflow-x-scroll lg:overflow-x-hidden xl:overflow-x-hidden border p-4">
                            <div class="flex justify-between">
                                <div class="flex gap-2">
                                    <img :src="event.thumbnail" class="w-20 h-28 border shadow-lg" />
                                    <h2 class="text-xl font-bold text-gray-700 hover:text-gray-500 leading-tight">
                                        <a :href="route('singleEvent.public', event.slug)">{{ event.title }}</a>
                                    </h2>
                                </div>
                                <div class="text-right flex flex-col justify-between">
                                    <div>
                                        <p class="text-gray-700">
                                            <span class="font-bold text-xl">{{ event.price > 0 ? currency(event.price) : 'FREE' }}</span>
                                        </p>
                                        <p class="italic">
                                            <span class="font-normal text-md mr-2 text-red-600">Discount</span>
                                            <span class="font-normal text-md text-red-600">{{ event.discount > 0 ? currency(event.discount*-1) : 0 }}</span>
                                        </p>
                                    </div>
                                    <p class="text-gray-700">
                                        <span class="font-bold text-lg"><span class="italic">Total:</span> {{ currency(event.netTotal) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="w-1/4 shadow-md border bg-white flex flex-col justify-between">
                        <div class="p-4 flex flex-col gap-2">
                            <div>
                                <p class="text-sm text-gray-700">Payment Method:</p>
                                <p class="uppercase font-bold text-gray-500 text-lg">{{ PaymentType }}</p>
                            </div>
                            <template v-if="PaymentType=='cheque'">
                                <p class="text-sm text-gray-800">Important Note:</p>
                                <ol class="list-decimal px-4">
                                    <li class="text-sm text-gray-900 leading-tight py-1">Bank Accnt Name: Bible Society of Singapore </li>
                                    <li class="text-sm text-gray-900 leading-tight py-1">Bank Accnt #: 123-4443-223 </li>
                                    <li class="text-sm text-gray-900 leading-tight py-1">Please send the photo copy to test@email.com</li>
                                    <li class="text-sm text-gray-900 leading-tight py-1">For concerns/clarification, contact us at 123-321-321</li>
                                </ol>
                            </template>
                            <template v-else>
                                <p>Stripe Payment</p>
                            </template>
                        </div>
                        <div class="checkoutTableFooter bg-gray-50 flex justify-between">
                            <div class="p-4 flex items-center justify-center">
                                <p class="text-md text-gray-600 font-bold">Grand Total</p>
                            </div>
                            <div class="p-4 flex items-center justify-center">
                                <p class="text-xl font-bold text-gray-700">
                                    {{ currency(GrandTotal) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end my-8 gap-6">
                    <a :href="route('checkout.index')" class="text-white uppercase transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300 leading-none bg-red-500 hover:bg-red-600 rounded-none text-md shadow-lg font-bold p-5">
                        Cancel
                    </a>
                    <BreezeButton @click.prevent="confirmPayment()" type="button" class="text-white transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300 leading-none bg-green-600 hover:bg-green-500 rounded-none text-md shadow-lg font-bold p-5">
                        Confirm
                    </BreezeButton>
                </div>
            </div>
        </div>
    </AuthenticatedUserLayout>
</template>
<style>
    .checkoutTableFooter {
        border-block: 1px dashed #d1d3d5;
        border-inline: 1px solid #e4e7eb;
    }
</style>
