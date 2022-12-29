<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
    import { Head } from '@inertiajs/inertia-vue3'
    import currency from '@/Helpers/formatCurrency'
    import CheckPromo from '@/Utilities/CheckPromo.vue'
    import { createToaster } from '@meforma/vue-toaster'
    import BreezeButton from '@/Components/Button.vue';
    import { useStore } from 'vuex';
    import { ref, onMounted } from 'vue';
    import { computed } from '@vue/reactivity'

    const toaster = createToaster({
            dismissible: true,
            duration: 2000
        })

    const store = useStore()
    // const cartItems = JSON.parse(localStorage.getItem('cart'))

    const cartItems = computed(() => store.getters['cart/cart'])


    const showMore = ref(null)
    const showDetails = (idx) => {
        showMore.value === idx ? (showMore.value = null) : (showMore.value = idx);
    }

    onMounted(() => {
        // console.log(cartItems)
    })

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

    const appliedPromo = ref({});
    // const showDiscount = ref(null)
    const getValidatedPromo = (e, i) => {
        appliedPromo.value = e
        if(e.status)
        {
            cartItems.value[i].discount = e.promo.discountPrice
            cartItems.value[i].promo_id = e.promo.id
        }
        else{
            cartItems.value[i].discount = null
            cartItems.value[i].promo_id = null
        }
        // showDiscount.value === i ? (showDiscount.value = null) : (showDiscount.value = i);
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

    const emptyCart = async() => {
        await store.dispatch('cart/emptyCart')
                .then(() => {
                    toaster.success('Cat item removed successfully');

            })

        location.reload()
    }

</script>

<template>
    <Head title="Checkout"></Head>
    <BreezeAuthenticatedLayout>
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 py-5">
            <!-- <pre>{{ cartItems[0] }}</pre> -->
            <template v-if="cartItems.length">
                <h2 class="text-2xl font-bold text-gray-600 mt-5">Checkout</h2>
                <p class="italic text-gray-600 mb-5 text-sm">Note: All the items below will be purchased. Kindly double check the details and amount before proceed to payment</p>
                <table class="w-full" >
                    <tr v-for="(item, index) in cartItems" :key="index" class="bg-white hover:bg-gray-50 border-t border-x">
                        <td class="p-5" width="60%">
                            <div class="flex gap-4">
                                <img :src="item.thumbnail" class="w-28 h-40 border shadow-lg" />
                                <div class="flex flex-col gap-2">
                                    <h2 class="text-xl font-bold text-blue-500 hover:text-blue-400">
                                        <a :href="route('event.public', item.slug)">{{ item.title }}</a>
                                    </h2>
                                    <div>
                                        <p class="text-gray-500 text-sm font-thin w-3/4 leading-tight overflow-hidden" :class="{'':showMore===index, 'h-[90px]':showMore!==index}">
                                            {{ item.description }}
                                        </p>
                                        <span @click="showDetails(index)" class="text-xs text-gray-700 hover:text-gray-500 font-bold cursor-pointer inline-flex items-center">
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

                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="p-5 text-center" width="15%">
                            <CheckPromo :eventid="item.id" @validate-promo="getValidatedPromo($event, index)" >
                                <template #headerText>
                                    <span class="text-sm text-gray-500 leading-6">Apply Promo</span>
                                </template>
                            </CheckPromo>
                        </td>
                        <td class="p-5 text-right">
                            <p class="text-gray-700">
                                <span class="font-bold" :class="{'font-normal line-through text-red-600': item.discount}">{{item.price > 0 ? currency(item.price) : 'FREE'}}</span>
                                <span class="font-bold ml-2" v-if="item.discount">{{ currency(item.price-item.discount) }}</span>
                            </p>
                            <span v-if="item.discount" class="font-bold text-xs ml-2 italic">
                                {{ currency(item.discount) }} discount
                            </span>
                        </td>
                        <td class="text-right p-5">
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
                    </tr>
                    <tr class="checkoutTableFooter">
                        <td class="p-10 text-right" colspan="2">
                            <p class="text-xl text-gray-600 font-bold">Grand Total</p>
                        </td>
                        <td class="p-5" colspan="2">
                            <p class="text-2xl font-bold text-gray-700 text-center">
                                {{ currency(getGrandTotal(cartItems)) }}
                            </p>
                        </td>
                    </tr>
                </table>
                <div class="flex justify-end my-8 gap-3">
                    <BreezeButton @click.prevent="emptyCart()" type="button" class="text-white bg-gray-600 hover:bg-gray-500 rounded-none text-xl shadow-lg font-bold py-3 px-4">
                        Empty Cart
                    </BreezeButton>
                    <BreezeButton type="button" class="text-white bg-green-600 hover:bg-green-500 rounded-none text-xl shadow-lg font-bold py-3 px-4">
                        Process Payment
                    </BreezeButton>
                </div>
            </template>
            <div v-else class="flex justify-center items-center min-h-[300px]">
                <h1 class="text-5xl text-gray-400">Cart is empty</h1>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
<style>
    .checkoutTableFooter {
        border-block: 2px dashed #d1d3d5;
        border-inline: 1px solid #e4e7eb;
        background-color: #fff;
    }
</style>
