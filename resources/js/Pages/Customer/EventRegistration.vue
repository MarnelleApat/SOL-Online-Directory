<script setup>
    import BreezeLabel from '@/Components/Label.vue';
    import BreezeTextarea from '@/Components/Textarea.vue';
    import BreezeInput from '@/Components/Input.vue';
    import BreezeButton from '@/Components/Button.vue';
    import { Switch } from '@headlessui/vue'
    import currency from '@/Helpers/formatCurrency'
    import { ref } from 'vue';
    import { useForm } from '@inertiajs/inertia-vue3';
    import categories from '@/Utilities/Categories.vue'
    import CheckPromo from '@/Utilities/CheckPromo.vue'
    import Checkout from '@/Utilities/Checkout.vue'
    import axios from 'axios';

    const props = defineProps(['event', 'customFields', 'errors'])
    const _event = props.event
    const _cf = props.customFields
    const setAddToBillingAdd = ref(false)
    const setAddToShippingAdd = ref(false)

    let validationErrors = ref([])
    let showError = ref(false)
    let hideForm = ref(false)
    const customer = ref([])

    const appliedPromo = ref({});

    // Registration Form Init
    const registrationForm = useForm({
        nirc:'',
        firstName:'',
        lastName:'',
        email:'',
        phoneNumber:'',
        address:'',
        city:'',
        postalCode:'',
        country:'',
        church:'',
        billingAddress:{
            address:'',
            city:'',
            postalCode:'',
            country:'',
        },
        shippingAddress:{
            address:'',
            city:'',
            postalCode:'',
            country:'',
        },
        gender:'',
        meta_data:''
    })

    const getValidatedPromo = (emittedPromo) => {
        appliedPromo.value = emittedPromo
    }

    // Send to the backend
    const submitRegistration = async () => {
        await axios.post(route('register.event', _event.id), registrationForm)
            .then(response => {
                customer.value = response.data
                hideForm.value = true
            })
            .catch(err => {
                validationErrors.value = err.response.data.errors
                showError.value = true
            })
    }

    const goBack = () => {
        hideForm.value = false
        appliedPromo.value = {}
    }

</script>

<template>
    <template v-if="!hideForm">
        <h5 class="text-2xl font-bold">Event Registration Form</h5>
        <p class="text-sm leading-5 font-light mt-2 mb-3">
            By providing your contact details, you consent to our collection,
            use and disclosure of your personal data as described in our privacy policy
            on our website. We do strive to limit the amount of personal data we collect
            to that which is sufficient to support the intended purpose of the collection.
            Kindly check our <a href="#" class="text-blue-500 hover:text-blue-400 underline">Privacy Policy</a>
        </p>
        <ul v-if="showError" class="bg-red-100 p-5">
            <li class="text-red-500" v-for="(error, idx) in validationErrors" :key="idx">{{error[0]}}</li>
        </ul>
        <form @submit.prevent="submitRegistration">
            <div class="flex flex-col gap-5 mt-6">
                <div class="w-1/4">
                    <BreezeLabel value="NIRC (Last 4-digit)" class="text-gray-500 leading-0 font-semibold" />
                    <BreezeInput v-model="registrationForm.nirc" type="text" class=" text-gray-700 w-full rounded-none" placeholder="NIRC (Last 4-digit)" />
                </div>
                <div class="flex gap-5">
                    <div class="w-1/2">
                        <BreezeLabel value="First Name" class="text-gray-500 leading-0 font-semibold" />
                        <BreezeInput v-model="registrationForm.firstName" type="text" class="text-gray-700 w-full rounded-none" placeholder="First Name" />
                    </div>
                    <div class="w-1/2">
                        <BreezeLabel value="Last Name" class="text-gray-500 leading-0 font-semibold" />
                        <BreezeInput v-model="registrationForm.lastName" type="text" class="text-gray-700 w-full rounded-none" placeholder="Last Name" />
                    </div>
                </div>
                <div class="flex gap-5">
                    <div class="w-1/2">
                        <BreezeLabel value="Email Address" class="text-gray-500 leading-0 font-semibold" />
                        <BreezeInput v-model="registrationForm.email" type="text" class="text-gray-700 w-full rounded-none" placeholder="Email Address" />
                    </div>
                    <div class="w-1/2">
                        <BreezeLabel value="Contact Number" class="text-gray-500 leading-0 font-semibold" />
                        <BreezeInput v-model="registrationForm.phoneNumber" type="text" class="text-gray-700 w-full rounded-none" placeholder="Phone Number" />
                    </div>
                </div>

                <div class="flex flex-col">
                    <BreezeLabel value="Gender" class="text-gray-500 leading-0 font-semibold" />
                    <select v-model="registrationForm.gender" class="text-gray-700 w-full border-gray-300 focus:border-gray-300 focus:ring-gray-200 focus:ring-opacity-0 rounded-none shadow-sm">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="flex flex-col">
                    <BreezeLabel value="Church" class="text-gray-500 leading-0 font-semibold" />
                    <BreezeInput v-model="registrationForm.church" type="text" class=" text-gray-700 w-full rounded-none" placeholder="Church" />
                </div>

                <div class="flex flex-col gap-2">
                    <p class="text-md font-bold">Address</p>
                    <div class="flex flex-col">
                        <BreezeLabel value="Street / Block # / Building No." class="text-gray-500 leading-0 font-semibold" />
                        <BreezeTextarea v-model="registrationForm.address" rows="2" class="text-gray-700 rounded-none" placeholder="Street No / Block # / Bldg. No" />
                    </div>
                    <div class="flex gap-5">
                        <div class="w-1/3">
                            <BreezeLabel value="City" class="text-gray-500 leading-0 font-semibold" />
                            <BreezeInput v-model="registrationForm.city" type="text" class="text-gray-700 w-full rounded-none" placeholder="City" />
                        </div>
                        <div class="w-1/3">
                            <BreezeLabel value="Postal Code" class="text-gray-500 leading-0 font-semibold" />
                            <BreezeInput v-model="registrationForm.postalCode" type="text" class="text-gray-700 w-full rounded-none" placeholder="Postal Code" />
                        </div>
                        <div class="w-1/3">
                            <BreezeLabel value="Country" class="text-gray-500 leading-0 font-semibold" />
                            <BreezeInput v-model="registrationForm.country" type="text" class="text-gray-700 w-full rounded-none" placeholder="Country" />
                        </div>
                    </div>
                </div>

                <template v-if="_cf.length">
                    <template v-for="(customFields, indx) in _cf" :key="indx">
                        <template v-if="customFields.name === 'Billing Address'">
                            <div class="flex flex-col gap-2 mt-5">
                                <div class="flex justify-between">
                                    <p class="text-md font-bold">Billing Address</p>
                                    <div class="flex gap-1">
                                        <p class="text-sm text-gray-500">Billing Address is the same with my address</p>
                                        <Switch v-model="setAddToBillingAdd" :class="setAddToBillingAdd ? 'bg-orange-500' : 'bg-gray-400'" class="relative inline-flex h-6 w-11 items-center rounded-full">
                                            <span :class="setAddToBillingAdd ? 'translate-x-6' : 'translate-x-1'" class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
                                        </Switch>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <BreezeLabel value="Street / Block # / Building No." class="text-gray-500 leading-0 font-semibold" />
                                    <BreezeTextarea v-model="registrationForm.billingAddress.address" rows="2" class="text-gray-700 rounded-none" placeholder="Street No / Block # / Bldg. No" />
                                </div>
                                <div class="flex gap-5">
                                    <div class="w-1/3">
                                        <BreezeLabel value="City" class="text-gray-500 leading-0 font-semibold" />
                                        <BreezeInput v-model="registrationForm.billingAddress.city" type="text" class="text-gray-700 w-full rounded-none" placeholder="City" />
                                    </div>
                                    <div class="w-1/3">
                                        <BreezeLabel value="Postal Code" class="text-gray-500 leading-0 font-semibold" />
                                        <BreezeInput v-model="registrationForm.billingAddress.postalCode" type="text" class="text-gray-700 w-full rounded-none" placeholder="Postal Code" />
                                    </div>
                                    <div class="w-1/3">
                                        <BreezeLabel value="Country" class="text-gray-500 leading-0 font-semibold" />
                                        <BreezeInput v-model="registrationForm.billingAddress.country" type="text" class="text-gray-700 w-full rounded-none" placeholder="Country" />
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-if="customFields.name === 'Shipping Address'">
                            <div class="flex flex-col gap-2 mt-5">
                                <div class="flex justify-between">
                                    <p class="text-md font-bold">Shipping Address</p>
                                    <div class="flex gap-1">
                                        <p class="text-sm text-gray-500">Shipping Address is the same with my address</p>
                                        <Switch v-model="setAddToShippingAdd" :class="setAddToShippingAdd ? 'bg-orange-500' : 'bg-gray-400'" class="relative inline-flex h-6 w-11 items-center rounded-full">
                                            <span :class="setAddToShippingAdd ? 'translate-x-6' : 'translate-x-1'" class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
                                        </Switch>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <BreezeLabel value="Street / Block # / Building No." class="text-gray-500 leading-0 font-semibold" />
                                    <BreezeTextarea v-model="registrationForm.shippingAddress.address" rows="2" class="text-gray-700 rounded-none" placeholder="Street No / Block # / Bldg. No" />
                                </div>
                                <div class="flex gap-5">
                                    <div class="w-1/3">
                                        <BreezeLabel value="City" class="text-gray-500 leading-0 font-semibold" />
                                        <BreezeInput v-model="registrationForm.shippingAddress.city" type="text" class="text-gray-700 w-full rounded-none" placeholder="City" />
                                    </div>
                                    <div class="w-1/3">
                                        <BreezeLabel value="Postal Code" class="text-gray-500 leading-0 font-semibold" />
                                        <BreezeInput v-model="registrationForm.shippingAddress.postalCode" type="text" class="text-gray-700 w-full rounded-none" placeholder="Postal Code" />
                                    </div>
                                    <div class="w-1/3">
                                        <BreezeLabel value="Country" class="text-gray-500 leading-0 font-semibold" />
                                        <BreezeInput v-model="registrationForm.shippingAddress.country" type="text" class="text-gray-700 w-full rounded-none" placeholder="Country" />
                                    </div>
                                </div>
                            </div>
                        </template>
                    </template>
                </template>
                <div class="mt-10 flex w-full justify-end gap-3">
                    <slot name="button" />
                </div>
            </div>
        </form>
    </template>
    <template v-else>
        <h5 class="text-2xl font-bold">Confirm Registration</h5>
        <p class="text-sm leading-5 font-light mt-2 mb-3">
            Double check the information before you proceed to checkout.
        </p>
        <hr />
        <div class="flex flex-col gap-2 mt-6">
            <!-- <pre>{{customer}}</pre> -->
            <h3 class="text-lg font-bold leading-none">Participant's Information</h3>
            <table>
                <tr><td class="border p-2">NIRC (Last 4 digit)</td><td class="border p-2">{{customer.nirc}}</td></tr>
                <tr><td class="border p-2">Name</td><td class="border p-2">{{customer.firstName}} {{customer.lastName}}</td></tr>
                <tr><td class="border p-2">Email</td><td class="border p-2">{{customer.email}}</td></tr>
                <tr><td class="border p-2">Contact #</td><td class="border p-2">{{customer.phoneNumber}}</td></tr>
                <tr><td class="border p-2">Address</td><td class="border p-2">{{customer.address}} {{customer.city}} {{customer.postalCode}} {{customer.country}}</td></tr>
            </table>
        </div>
        <div class="flex flex-col gap-2 mt-6">
            <!-- <pre>{{customer}}</pre> -->
            <h3 class="text-lg font-bold leading-none">Event Information</h3>
            <div class="flex space-x-4 border p-4">
                <div class="w-[250px]">
                    <img :src="_event.banner" class="w-auto" />
                </div>
                <div class="w-1/2 flex flex-col gap-1 justify-start">
                    <h2 class="text-2xl font-bold">{{_event.title}}</h2>
                    <p class="text-xs leading-tight italic">{{_event.description}}</p>
                    <span class="text-xs italic mt-4">Categories:</span>
                    <categories
                        :categories="_event.categories"
                        :styleClass="'bg-gray-800 border hover:bg-gray-400 hover:text-gray-800 text-white text-xs rounded-full mr-1 mb-1 py-1 px-2 inline-flex'" />
                    <div>
                        <span class="text-xs italic">Registration Fee:</span>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                            </svg>&nbsp;
                            <span class="font-normal text-md" :class="{'line-through text-red-600': appliedPromo.promo}">
                                &nbsp;{{currency(_event.price)}}&nbsp;
                            </span>
                            <span v-if="appliedPromo.promo" class="font-bold text-md ml-2">
                                {{currency(appliedPromo.promo.discountPrice)}}
                            </span>

                            <!-- {{appliedPromo.promo}} -->
                        </div>
                    </div>
                    <div class="flex flex-col mt-5">
                        <CheckPromo :eventid="_event.id" @validate-promo="getValidatedPromo" />
                        <!-- <pre>{{appliedPromo}}</pre> -->
                    </div>
                </div>
            </div>

        </div>
        <!-- <pre>{{_event}}</pre> -->
        <div class="flex gap-5 mt-6 justify-between">
            <BreezeButton @click="goBack" type="button" class="text-gray-100 bg-gray-600 hover:bg-gray-500 w-40 rounded-none text-lg shadow-lg font-bold py-3 px-4">
                Edit
            </BreezeButton>
            <Checkout :customer="customer" :checkoutItem="_event" :promoApply="appliedPromo">
                <template v-slot:button="{ onClick }">
                    <BreezeButton @click="onClick" type="button" class="text-white bg-green-600 hover:bg-green-500 rounded-none text-lg shadow-lg font-bold py-3 px-4">
                        Confirm and Checkout
                    </BreezeButton>
                </template>
            </Checkout>
        </div>
    </template>
</template>
