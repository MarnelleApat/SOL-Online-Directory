<script setup>
    import AuthenticatedUserLayout from '@/Layouts/User/AuthenticatedUser.vue'
    import { Head, useForm } from '@inertiajs/inertia-vue3'
    import currency from '@/Helpers/formatCurrency'
    import CheckPromo from '@/Utilities/CheckPromo.vue'
    import { createToaster } from '@meforma/vue-toaster'
    import BreezeButton from '@/Components/Button.vue';
    import MainModal from '@/Utilities/MainModal.vue'
    import { useStore } from 'vuex';
    import { ref } from 'vue';
    import { computed } from '@vue/reactivity'
    import { Inertia } from '@inertiajs/inertia'
    import Spinner from '@/Utilities/Spinner.vue'

    const toaster = createToaster({
            dismissible: true,
            duration: 2000
        })

    const store = useStore()

    const cartItems = computed(() => store.getters['cart/cart'])


    const showMore = ref(null)
    const selectPayment = ref(false)
    const isPaymentProcessing = ref(false)

    const showDetails = (idx) => {
        showMore.value === idx ? (showMore.value = null) : (showMore.value = idx);
    }

    const getGrandTotal = (items) => {
            let total
            let subTotal = []

            if(items.length > 0) {
                items.forEach((value) => {
                    let getDiscount = value.discount==null ? 0 : value.discount
                    total = value.price - getDiscount

                    subTotal.push(total)
                })
                return subTotal.reduce((a, b) => a+b)
            }

        }


    const getValidatedPromo = (e, i) => {
        cartItems.value[i].discount = e.status ? e.promo.discountPrice : null
        cartItems.value[i].promo_id = e.status ? e.promo.id : null
    }

    const removeItem = (item) => {
            const index = cartItems.value.findIndex(value => value.id === item.id);

            if (index > -1) {
                let remainingCartItems = cartItems.value.filter(value => value.id !== item.id)

                store.dispatch('cart/removeItemFromCart', remainingCartItems)
                    .then(() => {
                        toaster.warning('Cart item removed successfully');
                })
            }
        }

    const emptyCart = async () => {

        store.dispatch('cart/emptyCart')
            .then(() => {
                toaster.error('Successfully emoved all cart items.');
            })
    }

    const orderForm = useForm({
        cartItems: cartItems.value,
        customerInfo: 'Customer Info Here'
    })

    const processPayment = (paymentType) => {

        isPaymentProcessing.value = true
        orderForm.paymentType = paymentType;

        Inertia.post(route('checkout'), orderForm,
            {
                preserveScroll: true,
                onSuccess: (response) => {
                    console.log(response)
                    isPaymentProcessing.value = false
                },
                onError: errors => {
                    console.log(errors)
                    isPaymentProcessing.value = false
                }
            })
    }

</script>

<template>
    <Head title="Checkout"></Head>
    <AuthenticatedUserLayout>
        <div class="max-w-6xl mx-auto px-6 md:px-10 lg:px-8 py-12">
            <!-- <pre>{{ cartItems[0] }}</pre> -->
            <template v-if="cartItems.length">
                <h2 class="text-4xl font-bold text-gray-600 mt-5">Checkout</h2>
                <p class="italic text-gray-600 mb-5 text-md leading-tight">Note: Please double check all the items listed below before proceed to payment</p>
                <div class="overflow-x-scroll">
                    <table class="w-full whitespace-nowrap md:whitespace-normal lg:whitespace-normal">
                        <tr v-for="(item, index) in cartItems" :key="index" class="bg-gray-50 hover:bg-gray-100 border-t border-x">
                            <td class="text-center align-center pl-4" width="2%">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    @click="removeItem(item)"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6 text-red-700 hover:text-red-500 cursor-pointer font-extrabold">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </td>
                            <td class="p-5 w-[200px] md:w-[500px] lg:w-[500px]">
                                <div class="flex gap-4">
                                    <img :src="item.thumbnail" class="w-28 h-40 border shadow-lg" />
                                    <div class="">
                                        <h2 class="text-xl font-bold text-blue-500 hover:text-blue-400 leading-tight">
                                            <a :href="route('singleEvent.public', item.slug)">{{ item.title }}</a>
                                        </h2>
                                        <div class="mt-2">
                                            <p class="text-gray-500 text-sm font-thin leading-tight overflow-hidden" :class="{'':showMore!==index, 'h-[90px]':showMore===index}">
                                                {{ item.description }}
                                            </p>
                                            <p @click="showDetails(index)" class="text-xs text-gray-700 hover:text-gray-500 font-bold cursor-pointer inline-flex items-center">
                                                <template v-if="showMore!==index">
                                                    show more
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 font-bolder">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                    </svg>
                                                </template>
                                                <template v-else>
                                                    Show less
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 font-bolder">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                                    </svg>
                                                </template>

                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-5 w-[200px] text-center align-baseline">
                                <CheckPromo :programcode="item.programCode" @validate-promo="getValidatedPromo($event, index)" >
                                    <template #headerText>
                                        <span class="text-sm text-gray-500 leading-tigth text-left italic">Apply Promo</span>
                                    </template>
                                </CheckPromo>
                            </td>
                            <td class="p-5 text-right align-baseline">
                                <p class="text-gray-700">
                                    <span class="font-bold text-lg" :class="{'font-normal line-through text-red-600': item.discount && item.price > 0}">{{item.price > 0 ? currency(item.price) : 'FREE'}}</span>
                                    <span class="font-bold text-lg ml-2" v-if="item.discount && item.price > 0">{{ currency(item.price-item.discount) }}</span>
                                </p>
                                <span v-if="item.discount && item.price > 0" class="font-bold text-xs ml-2 italic">
                                    {{ currency(item.discount) }} discount
                                </span>
                            </td>
                        </tr>
                    </table>
                    <div class="checkoutTableFooter bg-gray-50 flex justify-between shadow-md">
                        <div class="p-10 text-right">
                            <p class="text-xl text-gray-600 font-bold">Grand Total</p>
                        </div>
                        <div class="p-5" colspan="2">
                            <p class="text-2xl font-bold text-gray-700 text-center">
                                {{ getGrandTotal(cartItems) > 0 ? currency(getGrandTotal(cartItems)) : currency(0.00) }}
                            </p>
                        </div>
                    </div>

                </div>
                <div class="flex justify-end my-8 gap-6">
                    <BreezeButton @click.prevent="emptyCart()" type="button" class="text-white transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300 leading-none bg-gray-600 hover:bg-gray-500 rounded-none text-md shadow-lg font-bold p-5">
                        Empty Cart
                    </BreezeButton>
                    <MainModal :isClose="selectPayment">
                        <template v-slot:openTriggerButton="{ onClick }">
                            <BreezeButton @click="onClick" type="button" class="text-white transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300 leading-none bg-green-600 hover:bg-green-500 rounded-none text-md shadow-lg font-bold p-5">
                                Process Payment
                            </BreezeButton>
                        </template>

                        <template #title>
                            <h3 class="font-bold text-xl text-gray-800">
                                Select Payment Method
                            </h3>
                        </template>

                        <template #default>
                            <div v-if="isPaymentProcessing" class="text-center py-10">
                                <h2 class="text-4xl text-green-500/70 mb-4">Processing Payment....</h2>
                                <Spinner />
                            </div>
                            <div v-else class="flex flex-col">
                                <div class="border hover:bg-gray-50">
                                    <button type="button" @click.prevent="processPayment('cheque')" class="flex p-4 text-left">
                                        <div class="mr-10">
                                            <img src="../../../../public/images/bss-logo.png" width="170" style="filter: invert(100%);" />
                                        </div>
                                        <div>
                                            <h5 class="text-lg font-semibold">Payment by Cheque</h5>
                                            <p class="text-sm">
                                                Please make your cheque payable to The Bible Society of Singapore and mail to:
                                            </p>
                                            <p class="text-sm border-2 border-gray-300 p-2 my-4">
                                                <span class="font-bold">The Bible Society of Singapore</span><br />
                                                7 Armenian Street<br />
                                                Bible House #04-01<br />
                                                Singapore 179932<br />
                                                <!-- Attn: {{props.checkoutItem.checkHandler}} ({{props.checkoutItem.programCode}}) -->
                                            </p>
                                            <p class="text-sm">Kindly state on the back of the cheque:</p>
                                            <ol class="list-decimal ml-4">
                                                <li class="text-sm">Generated Registration Number (to be sent in your email)</li>
                                                <li class="text-sm">Your name and contact number.</li>
                                            </ol>
                                        </div>
                                    </button>
                                </div>
                                <div class="border hover:bg-gray-50 pb-10">
                                    <a href="#!" @click.prevent="processPayment('stripe')" class="flex p-4">
                                        <div class="mr-10">
                                            <img src="../../../../public/images/logo-stripe.png" width="170" height="80" />
                                        </div>
                                        <div>
                                            <h5 class="text-lg font-semibold">Payment by Visa/Mastercard Credit Card</h5>
                                            <p class="text-sm">
                                                Card payments are processed securely via Stripe on behalf of the Bible Society of Singapore
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <div class="border relative">
                                    <div class="bg-gray-400 h-full w-full absolute opacity-70 z-50">
                                        <div class="flex items-center justify-center h-full w-full">
                                            <h4 class="text-3xl text-dark opacity-70">Coming soon</h4>
                                        </div>
                                    </div>
                                    <a href="#" class="hover:bg-gray-50 flex p-4 opacity-20">
                                        <img src="../../../../public/images/paynow-logo.png" width="170" />
                                        <div>
                                            <h5 class="text-lg font-semibold">Payment Via PayNow</h5>
                                            <p class="text-sm">
                                                Card payments are processed securely via Stripe on behalf of the Bible Society of Singapore
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <div class="borde relative">
                                    <div class="bg-gray-400 h-full w-full absolute opacity-70 z-50">
                                        <div class="flex items-center justify-center h-full w-full">
                                            <h4 class="text-3xl text-dark opacity-70">Coming soon</h4>
                                        </div>
                                    </div>
                                    <a href="#" class="hover:bg-gray-50 flex p-4 opacity-20">
                                        <img src="../../../../public/images/paymaya-logo.png" width="170" />
                                        <div>
                                            <h5 class="text-lg font-semibold">Payment Via PayMaya</h5>
                                            <p class="text-sm">
                                                Card payments are processed securely via Stripe on behalf of the Bible Society of Singapore
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </template>
                    </MainModal>
                </div>
            </template>
            <div v-else class="flex justify-center items-center min-h-[300px]">
                <h1 class="text-5xl text-gray-400">Cart is empty</h1>
            </div>
        </div>
    </AuthenticatedUserLayout>
</template>
<style>
    .checkoutTableFooter {
        border-block: 2px dashed #d1d3d5;
        border-inline: 1px solid #e4e7eb;
    }
</style>
