<script setup>
    import BreezeInput from '@/Components/Input.vue';
    import axios from 'axios';
    import { ref } from 'vue';

    const props = defineProps(['programcode'])
    const emit = defineEmits(['validatePromo'])
    const promocode = ref(null)
    const isVerifying = ref(false)
    const invalid = ref(false)
    const valid = ref(false)

    const validatePromoCode = (code) => {
        valid.value = false
        invalid.value = false

        if(code)
        {
            isVerifying.value = true
            setTimeout(() => {
                axios.get(route('promo.validate', [props.programcode, code]))
                     .then((response) => {
                        valid.value = true
                        emit('validatePromo', response.data)
                     })
                     .catch(errors => {
                        invalid.value = true
                        emit('validatePromo', errors.response.data)
                     })
                     .finally(() => {
                        isVerifying.value = false
                     })
            }, 500)
        }
        else
        {
            emit('validatePromo', {})
        }
    }

</script>
<template>
    <div class="flex flex-col justify-center gap-1">
        <slot name="headerText"></slot>
        <div class="flex items-center gap-2">
            <BreezeInput
                @change="validatePromoCode(promocode)"
                v-model="promocode"
                type="text"
                class="text-gray-700 w-full p-2 border-t-0 border-r-0 border-l-0 bg-white/90 rounded-none border-b-gray-500/30 transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300 border-1"
                placeholder="ex. EBP2023"
            />
            <div v-if="isVerifying" class="text-left ml-1">
                <div role="status">
                    <svg class="inline mr-2 w-5 h-5 text-gray-200 animate-spin dark:text-gray-300 fill-blue-400" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                </div>
            </div>
            <svg v-if="valid" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="w-6 h-6 text-green-600">
                <path fill-rule="evenodd"
                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
            </svg>
        </div>
    </div>
    <span v-if="invalid" class="text-xs text-red-600">Promo is not valid.</span>
</template>
