<script setup>
    import AuthenticatedUserLayout from '@/Layouts/User/AuthenticatedUser.vue';
    import BreezeDropdown from '@/Components/Dropdown.vue';
    import BreezeLabel from '@/Components/Label.vue';
    import BreezeTextarea from '@/Components/Textarea.vue';
    import BreezeInput from '@/Components/Input.vue';
    import BreezeButton from '@/Components/Button.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import categories from '@/Utilities/Categories.vue'
    import toJSON from '@/Helpers/StringToJson'
    import toDate from '@/Helpers/StringToDate'
    import currency from '@/Helpers/formatCurrency'
    import moment from 'moment'
    import { reactive, ref, onMounted } from 'vue';
    import { createToaster } from '@meforma/vue-toaster'
    import { useStore } from 'vuex';

    import { useVuelidate } from '@vuelidate/core'

    // validator
    import { required$, maxLength$, email$ } from '@/Helpers/validators'


    const store = useStore()
    const props = defineProps({
        event: Object
    })
    const event = props.event
    const headerTitle = 'Register | '+event.title

    const toaster = createToaster({
        dismissible: true,
        duration: 2000
    })

    const isExistInCart = ref(false)
    const isSucessRegistration = ref(false)

    onMounted(() => {

        // check the cart cookie is exist, create if none
        if(!localStorage.getItem("cart"))  {
            localStorage.setItem("cart", [])
        }

        // check if the selected event is already exist in the cart.
        if(localStorage.getItem("cart") !== "")
        {
            if(JSON.parse(localStorage.getItem("cart")).find(record => record.programCode === props.event.programCode))
            {
                isExistInCart.value = true
            }
        }
    })

    // setup form validation of the form
    const rules = {
        nirc: {
            required: required$('nirc'),
            maxlength: maxLength$(4),
        },
        firstName: {
            required: required$('First Name')
        },
        lastName: {
            required: required$('Last Name')
        },
        email: {
            required: required$('Email Address'),
            email$
        },
        phoneNumber: {
            required: required$('Phone Number'),
            maxLength: maxLength$(9)
        },
        gender: {
            required: required$('Gender')
        },
        address: {},
        city: {},
        postalCode: {},
        country: {},
        church: {},
    }

    // Registration Form Init
    const initialState = reactive({
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
        gender:'',
    })

    const registration = reactive({ ...initialState })

    // Form Reset
    function resetForm()
    {
        Object.assign(registration, initialState)
    }

    // validate registration with the validation rules implemented
    const v = useVuelidate(rules, registration)

    // Submit Registration Form
    const submitRegistration = () => {

        // validatiaon check before the fomr submission
        v.value.$validate()

        // check if the form passed the validation
        if(v.value.$invalid) return

        // passed the vaidation, save to localStorage
        store.dispatch('cart/addToCart', {'event':props.event, 'registrant':registration})
            .then(() => {
                toaster.success("Added to cart successfully")
                isExistInCart.value = true
                isSucessRegistration.value = true
                resetForm()
                v.value.$reset()
                document.body.scrollTop = 0; // For Safari
                document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
            })
            .catch(() => {
                toaster.error("Already exist in the cart.")
            })
    }

</script>

<template>
    <Head :title="headerTitle"></Head>

    <AuthenticatedUserLayout>
        <div class="p-5 min-h-[300px] bg-gray-700">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 py-5">
                <div class="flex justify-between">
                    <div class="flex flex-col gap-2 w-full sm:w-3/5 md:w-3/5 lg:w-3/5 xl:w-3/5">
                        <!-- categories -->
                        <categories :categories="event.categories" :styleClass="'bg-gray-800 border hover:bg-gray-400 hover:text-gray-800 text-white text-xs rounded-full mr-1 mb-1 py-1 px-2 inline-flex'" />
                        <!-- title -->
                        <div class="flex flex-col gap-3">
                            <h1 class="text-white text-4xl font-bold leading-10">{{event.title}}</h1>
                            <p class="text-white text-sm font-normal">
                                Hosted by:
                                <a :href="event.partner.websiteUrl" class="text-white hover:text-blue-600 font-bold">
                                    {{event.partner.name}}
                                </a>
                            </p>
                        </div>
                        <div class="flex flex-col gap-4">
                            <div class="flex items-baseline space-x-1 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 14" fill="currentColor">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                </svg>
                                <p class="text-sm font-semibold">20 registered <span class="italic">{{event.limit>0 ? '('+event.limit+' seats available)' : ''}}</span></p>
                            </div>
                            <div class="flex text-white items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 19" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>&nbsp;
                                <BreezeDropdown align='center' width="48">
                                    <template #trigger>
                                        <p class="text-white pl-2 pr-1 text-sm inline-flex items-center rounded-0 border">
                                            {{event.type}} Event
                                            <svg class="h-5 w-5 cursor-pointer opacity-70" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </p>
                                    </template>

                                    <template #content>
                                        <div class="w-72 bg-white border shadow-lg rounded-md p-3 mt-1">
                                            <div class="flex flex-col gap-5">
                                                <div v-if="event.type=='Online'">
                                                    <p class="text-slate-500 text-sm leading-none font-bold">Online Details</p>
                                                    <a :href="toJSON(event.venue).url" class="text-blue-500 text-md leading-0 pl-2">{{toJSON(event.venue).url}}</a>
                                                </div>
                                                <div v-else-if="event.type=='Physical'">
                                                    <p class="text-slate-500 text-sm leading-none font-bold">Venue:</p>
                                                    <p class="text-slate-500 text-md leading-0 pl-2">
                                                        {{toJSON(event.venue).location}} {{toJSON(event.venue).city}} {{toJSON(event.venue).postalcode}}
                                                    </p>
                                                </div>
                                                <template v-else>
                                                    <div>
                                                        <p class="text-slate-500 text-sm leading-none font-bold">Online Details</p>
                                                        <span class="text-slate-500 text-sm leading-none">URL:</span> <a :href="toJSON(event.venue).url" class="text-blue-500 text-md leading-0 pl-2">{{toJSON(event.venue).url}}</a>
                                                    </div>
                                                    <div>
                                                        <p class="text-slate-500 text-sm leading-none font-bold">Location Details</p>
                                                        <p class="text-slate-500 text-md leading-0 pl-2">
                                                            {{toJSON(event.venue).location}} {{toJSON(event.venue).city}} {{toJSON(event.venue).postalcode}}
                                                        </p>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </BreezeDropdown>
                            </div>
                            <div class="flex items-center space-x-1 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white fw-100 lh-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                <template v-if="event.schedules.length">
                                    <BreezeDropdown v-if="event.schedules.length>1" align="right" width="48">
                                        <template #trigger>
                                            <p class="text-sm inline-flex">
                                                {{toDate(event.schedules[0].date, 'll')}} @ {{moment(event.schedules[0].startTime, 'HH:mm').format('LT')}}-{{moment(event.schedules[0].endTime, 'HH:mm').format('LT')}}
                                                <svg v-if="event.schedules.length > 1" class="h-5 w-5 cursor-pointer opacity-70" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </p>
                                        </template>

                                        <template #content>
                                            <template v-if="event.schedules.length > 1">
                                                <div class="w-72 bg-white border shadow-lg rounded-md p-3">
                                                    <template v-for="(schedule,indx) in event.schedules">
                                                        <div class="mb-2">
                                                            <p class="text-slate-500 text-sm leading-0 italic">Session {{indx+1}}</p>
                                                            <p class="text-slate-500 text-sm leading-0">
                                                                {{toDate(schedule.date, 'll')}} @ {{moment(schedule.startTime, 'HH:mm').format('LT')}}-{{moment(schedule.endTime, 'HH:mm').format('LT')}}
                                                            </p>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>
                                        </template>
                                    </BreezeDropdown>
                                    <p v-else class="text-sm inline-flex">
                                        {{toDate(event.schedules[0].date, 'll')}} @ {{moment(event.schedules[0].startTime, 'HH:mm').format('LT')}}-{{moment(event.schedules[0].endTime, 'HH:mm').format('LT')}}
                                        <svg v-if="event.schedules.length > 1" class="h-5 w-5 cursor-pointer opacity-70" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </p>
                                </template>
                            </div>
                            <div class="flex flex-col text-white">
                                <div class="flex items-center">
                                    <p class="text-sm text-white mr-2">Registration Fee:</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                    </svg>&nbsp;
                                    <span class="font-bold text-xl">{{currency(event.price)}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-12 bg-white">
            <div class="max-w-6xl mx-auto px-6 md:px-10 lg:px-8">
                <div v-if="isSucessRegistration" class="flex justify-between bg-green-500/20 p-4 mb-12 rounded-md text-green-600 border border-green-600/30">
                    <p  class="leading-relaxed">
                        <span class="text-green-700 font-bold text-sm">Sucess!</span>&nbsp;<span class="text-green-600 text-sm">
                            Registration successfully added to cart. To secure your seat, go to checkout and proceed to payment.
                        </span>
                    </p>
                    <div class="w-[20px] ml-10">
                        <svg @click="isSucessRegistration = false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer text-green-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
                <div class="flex gap-8">
                    <div class="w-full md:w-full lg:w-4/6">
                        <h4 class="text-xl text-gray-700 font-bold leading-relaxed">Please fill-up registration below</h4>
                        <p class="text-xs leading-relaxed text-gray-500 font-light italic mb-8">
                            By providing your contact details, you consent to our collection,
                            use and disclosure of your personal data as described in our privacy policy
                            on our website. We do strive to limit the amount of personal data we collect
                            to that which is sufficient to support the intended purpose of the collection.
                            Kindly check our <a href="#" class="text-blue-500 hover:text-blue-400 underline">Privacy Policy</a>
                        </p>
                        <form @submit.prevent="submitRegistration()">
                            <div class="flex flex-col gap-5 mt-6">
                                <div class="w-1/2">
                                    <BreezeLabel value="NIRC (Last 4-digit)" class="text-gray-500 leading-0 font-semibold" />
                                    <BreezeInput v-model="registration.nirc" type="text"
                                        :class="{ 'border-red-500': v.nirc.$errors.length }"
                                        class=" text-gray-700 w-full rounded-none" placeholder="NIRC (Last 4-digit)" />
                                    <small v-if="v.nirc.$errors.length" class="text-red-600">{{ v.nirc.$errors[0].$params.type==='required' ? 'NIRC is required' : v.nirc.$errors[0].$message }}</small>
                                </div>
                                <div class="flex gap-5">
                                    <div class="w-1/2">
                                        <BreezeLabel value="First Name" class="text-gray-500 leading-0 font-semibold" />
                                        <BreezeInput v-model="registration.firstName" type="text"
                                            :class="{ 'border-red-500': v.firstName.$errors.length }"
                                            class="text-gray-700 w-full rounded-none" placeholder="First Name" />
                                        <small v-if="v.firstName.$errors.length" class="text-red-600">{{ v.firstName.$errors[0].$message }}</small>
                                    </div>
                                    <div class="w-1/2">
                                        <BreezeLabel value="Last Name" class="text-gray-500 leading-0 font-semibold" />
                                        <BreezeInput v-model="registration.lastName" type="text"
                                            :class="{ 'border-red-500': v.lastName.$errors.length }"
                                            class="text-gray-700 w-full rounded-none" placeholder="Last Name" />
                                        <small v-if="v.lastName.$errors.length" class="text-red-600">{{ v.lastName.$errors[0].$message }}</small>
                                    </div>
                                </div>
                                <div class="flex gap-5">
                                    <div class="w-1/2">
                                        <BreezeLabel value="Email Address" class="text-gray-500 leading-0 font-semibold" />
                                        <BreezeInput v-model="registration.email" type="text"
                                            :class="{ 'border-red-500': v.email.$errors.length }"
                                            class="text-gray-700 w-full rounded-none" placeholder="Email Address" />
                                        <small v-if="v.email.$errors.length" class="text-red-600">{{ v.email.$errors[0].$message }}</small>
                                    </div>
                                    <div class="w-1/2">
                                        <BreezeLabel value="Contact Number" class="text-gray-500 leading-0 font-semibold" />
                                        <BreezeInput v-model="registration.phoneNumber" type="text"
                                            :class="{ 'border-red-500': v.phoneNumber.$errors.length }"
                                            class="text-gray-700 w-full rounded-none" placeholder="Phone Number" />
                                        <small v-if="v.phoneNumber.$errors.length" class="text-red-600">{{ v.phoneNumber.$errors[0].$message }}</small>
                                    </div>
                                </div>

                                <div class="flex flex-col">
                                    <BreezeLabel value="Gender" class="text-gray-500 leading-0 font-semibold" />
                                    <select v-model="registration.gender"
                                        :class="{ 'border-red-500': v.gender.$errors.length }"
                                        class="text-gray-700 w-full border-gray-300 focus:border-gray-300 focus:ring-gray-200 focus:ring-opacity-0 rounded-none shadow-sm">
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <small v-if="v.gender.$errors.length" class="text-red-600">{{ v.gender.$errors[0].$message }}</small>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <p class="text-md font-bold">Address</p>
                                    <div class="flex flex-col">
                                        <BreezeLabel value="Street / Block # / Building No." class="text-gray-500 leading-0 font-semibold" />
                                        <BreezeTextarea v-model="registration.address" rows="2" class="text-gray-700 rounded-none" placeholder="Street No / Block # / Bldg. No" />
                                    </div>
                                    <div class="flex gap-5">
                                        <div class="w-1/3">
                                            <BreezeLabel value="City" class="text-gray-500 leading-0 font-semibold" />
                                            <BreezeInput v-model="registration.city" type="text"
                                                :class="{ 'border-red-500': v.city.$errors.length }"
                                                class="text-gray-700 w-full rounded-none" placeholder="City" />
                                            <small v-if="v.city.$errors.length" class="text-red-600">{{ v.city.$errors[0].$message }}</small>
                                        </div>
                                        <div class="w-1/3">
                                            <BreezeLabel value="Postal Code" class="text-gray-500 leading-0 font-semibold" />
                                            <BreezeInput v-model="registration.postalCode" type="text" class="text-gray-700 w-full rounded-none" placeholder="Postal Code" />
                                        </div>
                                        <div class="w-1/3">
                                            <BreezeLabel value="Country" class="text-gray-500 leading-0 font-semibold" />
                                            <BreezeInput v-model="registration.country" type="text" class="text-gray-700 w-full rounded-none" placeholder="Country" />
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <BreezeLabel value="Church" class="text-gray-500 leading-0 font-semibold" />
                                    <BreezeInput v-model="registration.church" type="text" class=" text-gray-700 w-full rounded-none" placeholder="Church" />
                                </div>
                                <div class="flex justify-evenly md:justify-end lg:justify-end mt-5 gap-3">
                                    <BreezeButton
                                        type="reset"
                                        :class="'bg-gray-700 border border-transparent text-sm text-white disabled:bg-gray-400 disabled:border-gray-500/60 hover:bg-gray-600 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray'">
                                        Reset
                                    </BreezeButton>
                                    <BreezeButton
                                        :disabled="isExistInCart"
                                        :class="{ 'bg-gray-700 border border-transparent text-sm text-white disabled:bg-gray-400 disabled:border-gray-500/60 hover:bg-gray-600 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray':isExistInCart,
                                        'bg-green-600 border border-transparent text-sm text-white hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:shadow-outline-green':!isExistInCart }">
                                        {{ isExistInCart ? 'Already in the cart' : 'Register & Add to Cart' }}
                                    </BreezeButton>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="hidden md:hidden lg:flex md:w-2/6 lg:w-2/6 md:h-[450px] lg:h-[450px]">
                        <img class="w-full shadow-xl overflow-hidden border-4 border-gray-100" :src="event.banner ? event.banner : 'https://via.placeholder.com/300x500/FFFFFF/DDDDDD/?text=EVENT+POSTER'" />
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedUserLayout>
</template>


<style>
    html {
        scroll-behavior: smooth;
    }
</style>
