<script setup>
    import BreezeLabel from '@/Components/Label.vue';
    import BreezeTextarea from '@/Components/Textarea.vue';
    import BreezeInput from '@/Components/Input.vue';
    import BreezeButton from '@/Components/Button.vue';
    import MainModal from '@/Utilities/MainModal.vue'
    import { createToaster } from '@meforma/vue-toaster'
    import { useStore } from 'vuex';
    import { ref, reactive, onMounted, computed } from 'vue';

    const props = defineProps(['selectedEvent'])
    const isExistInCart = ref(false)
    const store = useStore()

    const toaster = createToaster({
            dismissible: true,
            duration: 2000
        })

    onMounted(() => {
        // check the cart cookie is exist, create if none
        if(!localStorage.getItem("cart"))  {
            localStorage.setItem("cart", [])
        }

        // check if the selected event is already exist in the cart.
        if(localStorage.getItem("cart") !== "")
        {
            if(JSON.parse(localStorage.getItem("cart")).find(record => record.id === props.selectedEvent.id))
            {
                isExistInCart.value = true
            }
        }
    })

    // Registration Form Init
    const registration = reactive({
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

    const saveRegistrationAndAddToCart = () => {
        store.dispatch('cart/addToCart', props.selectedEvent)
            .then(() => {
                toaster.success("Added to cart successfully")
                isExistInCart.value = true
            })
            .catch(() => {
                toaster.error("Already exist in the cart.")
            })
    }

    const isOpen = ref(false)
    const openModal = () => {
        isOpen.value = true
    }

</script>

<template>
    <MainModal :isOpen="isOpen" @open-modal="openModal">
        <template #openTriggerButton>
            <BreezeButton
                :disabled="isExistInCart"
                :class="{'bg-green-400 hover:bg-green-400 active:bg-green-400 text-green-800':isExistInCart}"
                @click="openModal"
                type="button"
                class="flex w-full items-center justify-center gap-2 text-gray-100 bg-green-600 hover:bg-green-700 rounded-none text-lg shadow-lg font-bold py-3 px-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
                {{isExistInCart ? 'Added to cart' : 'Add to Cart'}}
            </BreezeButton>
        </template>
        <template #title>
            <h3 class="text-2xl font-bold">Registration Required before adding to cart</h3>
        </template>
        <template #content>
            <p class="text-sm leading-5 font-light my-5 mb-3">
                By providing your contact details, you consent to our collection,
                use and disclosure of your personal data as described in our privacy policy
                on our website. We do strive to limit the amount of personal data we collect
                to that which is sufficient to support the intended purpose of the collection.
                Kindly check our <a href="#" class="text-blue-500 hover:text-blue-400 underline">Privacy Policy</a>
            </p>
            <form @submit.prevent="saveRegistrationAndAddToCart">
                <div class="flex flex-col gap-5 mt-6">
                    <div class="w-1/4">
                        <BreezeLabel value="NIRC (Last 4-digit)" class="text-gray-500 leading-0 font-semibold" />
                        <BreezeInput v-model="registration.nirc" type="text" class=" text-gray-700 w-full rounded-none" placeholder="NIRC (Last 4-digit)" />
                    </div>
                    <div class="flex gap-5">
                        <div class="w-1/2">
                            <BreezeLabel value="First Name" class="text-gray-500 leading-0 font-semibold" />
                            <BreezeInput v-model="registration.firstName" type="text" class="text-gray-700 w-full rounded-none" placeholder="First Name" />
                        </div>
                        <div class="w-1/2">
                            <BreezeLabel value="Last Name" class="text-gray-500 leading-0 font-semibold" />
                            <BreezeInput v-model="registration.lastName" type="text" class="text-gray-700 w-full rounded-none" placeholder="Last Name" />
                        </div>
                    </div>
                    <div class="flex gap-5">
                        <div class="w-1/2">
                            <BreezeLabel value="Email Address" class="text-gray-500 leading-0 font-semibold" />
                            <BreezeInput v-model="registration.email" type="text" class="text-gray-700 w-full rounded-none" placeholder="Email Address" />
                        </div>
                        <div class="w-1/2">
                            <BreezeLabel value="Contact Number" class="text-gray-500 leading-0 font-semibold" />
                            <BreezeInput v-model="registration.phoneNumber" type="text" class="text-gray-700 w-full rounded-none" placeholder="Phone Number" />
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <BreezeLabel value="Gender" class="text-gray-500 leading-0 font-semibold" />
                        <select v-model="registration.gender" class="text-gray-700 w-full border-gray-300 focus:border-gray-300 focus:ring-gray-200 focus:ring-opacity-0 rounded-none shadow-sm">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <BreezeLabel value="Church" class="text-gray-500 leading-0 font-semibold" />
                        <BreezeInput v-model="registration.church" type="text" class=" text-gray-700 w-full rounded-none" placeholder="Church" />
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
                                <BreezeInput v-model="registration.city" type="text" class="text-gray-700 w-full rounded-none" placeholder="City" />
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
                    <div class="flex justify-end mt-10 gap-3">
                        <button @click="isOpen=false" type="button" class="inline-flex justify-center items-center uppercase rounded-sm border bg-gray-600 hover:bg-gray-500 px-4 py-2 text-sm font-bold text-white">
                            Cancel
                        </button>
                        <button
                            class="flex gap-1 justify-center items-center uppercase rounded-sm border bg-green-600 hover:bg-green-500 px-4 py-2 text-sm font-bold text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                            Add to cart
                        </button>
                    </div>
                </div>
            </form>
            <pre>{{registration}}</pre>
            <pre>{{props.selectedEvent}}</pre>
        </template>
    </MainModal>
</template>
