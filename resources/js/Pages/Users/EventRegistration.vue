<script setup>
    import BreezeLabel from '@/Components/Label.vue';
    import BreezeTextarea from '@/Components/Textarea.vue';
    import BreezeInput from '@/Components/Input.vue';
    import { Switch } from '@headlessui/vue'
    import { onMounted, ref } from 'vue';
    import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

    const props = defineProps(['event_id', 'customFields', 'loggedInUser'])
    const _eventID = props.event_id
    const _cf = props.customFields
    const _user = props.loggedInUser
    const setAddToBillingAdd = ref(false)
    const setAddToShippingAdd = ref(false)
    const createAccount = ref(false)

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
        username:'',
        password:'',
        password_confirmation:'',
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
        specialSettings:''
    })

    // Process Flow
    // Check logged in or not. If logged-in, auto-populate the form based on the logged-in user data | Else, let the user populate the form
    onMounted(() => {
        registrationForm.nirc = _user ? _user.nirc : ''
        registrationForm.firstName = _user ? _user.firstName : ''
        registrationForm.lastName = _user ? _user.lastName : ''
        registrationForm.email = _user ? _user.email : ''
        registrationForm.phoneNumber = _user ? _user.phoneNumber : ''
        registrationForm.address = _user ? _user.address : ''
        registrationForm.city = _user ? _user.city : ''
        registrationForm.postalCode = _user ? _user.postalCode : ''
        registrationForm.country = _user ? _user.country : ''
        registrationForm.church = _user ? _user.church : ''
        registrationForm.gender = _user ? _user.gender : ''
    })

    // Send to the backend
    const submitRegistration = async () => {

        // If don't want to creat an account, generate random value
        const dummyChar = Math.random().toString(36).slice(2)

        if(!createAccount.value)
        {
            registrationForm.username = dummyChar
            registrationForm.password = dummyChar
            registrationForm.password_confirmation = dummyChar
        }

        await Inertia.post(route('register.event', _eventID), registrationForm,
            {
                preserveScroll: true,
                onSuccess: (response) => {

                    console.log(response)
                    // let __data = null
                    // if(updateForm.columnName == 'venue')
                    //     __data = updateForm
                    // else
                    //     __data = updateForm.newData

                    // emit('successUpdate', [props.colName, __data])
                    // validationErrors.value = []
                    // showError.value = false
                    // isOpen.value = false
                },
                onError: errors => {
                    console.log(errors)
                    // validationErrors.value = errors
                    // showError.value = true
                }
            })
    }
</script>

<template>
    <form @submit.prevent="submitRegistration">
        <div class="flex flex-col gap-5 mt-6">
            <div class="w-1/4">
                <BreezeLabel value="NIRC (Last 4-digit)" class="text-gray-500 leading-0 font-semibold" />
                <BreezeInput v-model="registrationForm.nirc" required type="text" class=" text-gray-700 w-full rounded-none" placeholder="NIRC (Last 4-digit)" />
            </div>
            <div class="flex gap-5">
                <div class="w-1/2">
                    <BreezeLabel value="First Name" class="text-gray-500 leading-0 font-semibold" />
                    <BreezeInput v-model="registrationForm.firstName" required type="text" class="text-gray-700 w-full rounded-none" placeholder="First Name" />
                </div>
                <div class="w-1/2">
                    <BreezeLabel value="Last Name" class="text-gray-500 leading-0 font-semibold" />
                    <BreezeInput v-model="registrationForm.lastName" required type="text" class="text-gray-700 w-full rounded-none" placeholder="Last Name" />
                </div>
            </div>
            <div class="flex gap-5">
                <div class="w-1/2">
                    <BreezeLabel value="Email Address" class="text-gray-500 leading-0 font-semibold" />
                    <BreezeInput v-model="registrationForm.email" required type="text" class="text-gray-700 w-full rounded-none" placeholder="Email Address" />
                </div>
                <div class="w-1/2">
                    <BreezeLabel value="Contact Number" class="text-gray-500 leading-0 font-semibold" />
                    <BreezeInput v-model="registrationForm.phoneNumber" required type="text" class="text-gray-700 w-full rounded-none" placeholder="Phone Number" />
                </div>
            </div>

            <div class="flex flex-col">
                <BreezeLabel value="Gender" class="text-gray-500 leading-0 font-semibold" />
                <select v-model="registrationForm.gender" required class="text-gray-700 w-full border-gray-300 focus:border-gray-300 focus:ring-gray-200 focus:ring-opacity-0 rounded-none shadow-sm">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="flex flex-col">
                <BreezeLabel value="Church" class="text-gray-500 leading-0 font-semibold" />
                <BreezeInput v-model="registrationForm.church" required type="text" class=" text-gray-700 w-full rounded-none" placeholder="Church" />
            </div>

            <div class="flex flex-col gap-2">
                <p class="text-md font-bold">Address</p>
                <div class="flex flex-col">
                    <BreezeLabel value="Street / Block # / Building No." class="text-gray-500 leading-0 font-semibold" />
                    <BreezeTextarea v-model="registrationForm.address" required rows="2" class="text-gray-700 rounded-none" placeholder="Street No / Block # / Bldg. No" />
                </div>
                <div class="flex gap-5">
                    <div class="w-1/3">
                        <BreezeLabel value="City" class="text-gray-500 leading-0 font-semibold" />
                        <BreezeInput v-model="registrationForm.city" required type="text" class="text-gray-700 w-full rounded-none" placeholder="City" />
                    </div>
                    <div class="w-1/3">
                        <BreezeLabel value="Postal Code" class="text-gray-500 leading-0 font-semibold" />
                        <BreezeInput v-model="registrationForm.postalCode" required type="text" class="text-gray-700 w-full rounded-none" placeholder="Postal Code" />
                    </div>
                    <div class="w-1/3">
                        <BreezeLabel value="Country" class="text-gray-500 leading-0 font-semibold" />
                        <BreezeInput v-model="registrationForm.country" required type="text" class="text-gray-700 w-full rounded-none" placeholder="Country" />
                    </div>
                </div>
            </div>

            <template v-if="_cf.length">
                <template v-for="customFields in _cf">
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
                                <BreezeTextarea v-model="registrationForm.billingAddress.address" required rows="2" class="text-gray-700 rounded-none" placeholder="Street No / Block # / Bldg. No" />
                            </div>
                            <div class="flex gap-5">
                                <div class="w-1/3">
                                    <BreezeLabel value="City" class="text-gray-500 leading-0 font-semibold" />
                                    <BreezeInput v-model="registrationForm.billingAddress.city" required type="text" class="text-gray-700 w-full rounded-none" placeholder="City" />
                                </div>
                                <div class="w-1/3">
                                    <BreezeLabel value="Postal Code" class="text-gray-500 leading-0 font-semibold" />
                                    <BreezeInput v-model="registrationForm.billingAddress.postalCode" required type="text" class="text-gray-700 w-full rounded-none" placeholder="Postal Code" />
                                </div>
                                <div class="w-1/3">
                                    <BreezeLabel value="Country" class="text-gray-500 leading-0 font-semibold" />
                                    <BreezeInput v-model="registrationForm.billingAddress.country" required type="text" class="text-gray-700 w-full rounded-none" placeholder="Country" />
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
                                <BreezeTextarea v-model="registrationForm.shippingAddress.address" required rows="2" class="text-gray-700 rounded-none" placeholder="Street No / Block # / Bldg. No" />
                            </div>
                            <div class="flex gap-5">
                                <div class="w-1/3">
                                    <BreezeLabel value="City" class="text-gray-500 leading-0 font-semibold" />
                                    <BreezeInput v-model="registrationForm.shippingAddress.city" required type="text" class="text-gray-700 w-full rounded-none" placeholder="City" />
                                </div>
                                <div class="w-1/3">
                                    <BreezeLabel value="Postal Code" class="text-gray-500 leading-0 font-semibold" />
                                    <BreezeInput v-model="registrationForm.shippingAddress.postalCode" required type="text" class="text-gray-700 w-full rounded-none" placeholder="Postal Code" />
                                </div>
                                <div class="w-1/3">
                                    <BreezeLabel value="Country" class="text-gray-500 leading-0 font-semibold" />
                                    <BreezeInput v-model="registrationForm.shippingAddress.country" required type="text" class="text-gray-700 w-full rounded-none" placeholder="Country" />
                                </div>
                            </div>
                        </div>
                    </template>
                </template>
            </template>
            <div v-if="_user==null" class="flex flex-col gap-2 mt-5">
                <div class="flex items-center gap-1">
                    <Switch v-model="createAccount" :class="createAccount ? 'bg-orange-500' : 'bg-gray-400'" class="relative inline-flex h-4 w-10 items-center rounded-full">
                        <span :class="createAccount ? 'translate-x-6' : 'translate-x-1'" class="inline-block h-3 w-3 transform rounded-full bg-white transition"/>
                    </Switch>
                    <p class="text-sm text-gray-700">As soon as you register, you can also establish an account. If not, continue to register as a guest.</p>
                </div>
            </div>
            <div class="flex gap-5" v-if="createAccount">
                <div class="w-1/3">
                    <BreezeLabel value="Username" class="text-gray-500 leading-0 font-semibold" />
                    <BreezeInput v-model="registrationForm.username" required type="text" class="text-gray-700 w-full rounded-none" placeholder="Username" />
                </div>
                <div class="w-1/3">
                    <BreezeLabel value="Password" class="text-gray-500 leading-0 font-semibold" />
                    <BreezeInput v-model="registrationForm.password" required type="password" class="text-gray-700 w-full rounded-none" placeholder="Password" />
                </div>
                <div class="w-1/3">
                    <BreezeLabel value="Confirm Password" class="text-gray-500 leading-0 font-semibold" />
                    <BreezeInput v-model="registrationForm.password_confirmation" required type="password" class="text-gray-700 w-full rounded-none" placeholder="Confirm Password" />
                </div>
            </div>
            <div class="mt-10 flex w-full justify-end gap-3">
                <slot name="button" />
            </div>
        </div>
    </form>
</template>
