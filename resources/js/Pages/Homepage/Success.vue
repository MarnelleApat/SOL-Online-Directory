<script setup>
    const props = defineProps([
        'session',
        'customer',
        'invoice'
    ])
</script>

<template>
    <div class="container mx-auto">
        <div class="flex justify-center p-12">
            <div>
                <h1 class="text-4xl font-bold text-green-200 bg-green-500 p-10 text-center">Thank You for your donation</h1>
                <div class="border p-5 flex flex-col gap-4 min-h-[400px] relative">
                    <p class="font-bold">Greetings! {{props.customer.name}}</p>
                    <p>Your donation processed successfully with transaction number:
                        <span class="bg-green-700 p-1 text-white inline-block text-xs">{{props.session.payment_intent}}</span>
                        <br />Thank you for donating <span class="font-bold">${{(props.session.amount_total/100)}}</span> to this charity.
                        All the payment details will be sent to your email <span class="font-bold">{{props.customer.email}}</span>
                    </p>
                    <p>Meanwhile, you can download the invoice document <a href="#" class="text-blue-900 font-bold underline">here</a></p>

                    <a href="/" class="text-white font-bold bg-blue-700 hover:bg-blue-600 p-2 w-1/4 text-center absolute bottom-4">Go Back to the Homepage</a>
                </div>
            </div>
        </div>
        <div class="border bg-gray-100">
            <pre>{{props.session}}</pre>
        </div>
    </div>
</template>
