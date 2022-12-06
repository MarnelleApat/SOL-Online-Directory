<script setup>
    import { Inertia } from '@inertiajs/inertia';
    import { useForm } from '@inertiajs/inertia-vue3';

    const props = defineProps([
        'prices'
    ]);

    const donateForm = useForm({
        amount: '',
        customAmount: ''
    })

    const notCustom = () => {
        donateForm.customAmount = '';
    }

    const submitpayment = () => {

        Inertia.post(route('donate'), donateForm,
            {
                preserveScroll: true,
                onSuccess: (response) => {
                    console.log(response)
                },
                onError: errors => {
                    console.log(errors)
                }
            })
    }

</script>

<template>
    <div class="bg-white">
        <div class="container mx-auto">
            <h1 class="text-4xl font-bold text-gray-500">Online Donation Testing</h1>
            <p class="w-1/2 mb-10">Testing for online donation. This wraps up the quickstart. See the links below for a few different ways to process a payment for the product you just created.</p>
            <form @submit.prevent="submitpayment">
                <div class="flex flex-col">
                    <template v-for="price in props.prices">
                        <div class="flex items-center gap-2 py-1">
                            <input type="radio" v-model="donateForm.amount" :value="price.amount" @click="notCustom" /> ${{price.amount}}
                        </div>
                    </template>
                    <div class="flex items-center gap-2">
                        <input type="radio" v-model="donateForm.amount" value="custom" /> Any amount
                    </div>
                    <input class="border mt-2 w-1/4"
                        :class="{'bg-gray-300': donateForm.amount!=='custom'}"
                        v-model="donateForm.customAmount"
                        type="number"
                        step="0.01"
                        placeholder="custom amount"
                        :disabled="donateForm.amount!=='custom'" />
                </div>

                <div class="flex gap-2 mt-5">
                    <button type="submit" class="border bg-green-700 hover:bg-green-600 text-white p-3 mt-5">
                        Proceed to payment
                    </button>
                    <button type="reset" class="border bg-gray-700 hover:bg-gray-600 text-white p-3 mt-5">
                        Reset
                    </button>
                </div>
            </form>

        </div>
    </div>

</template>
