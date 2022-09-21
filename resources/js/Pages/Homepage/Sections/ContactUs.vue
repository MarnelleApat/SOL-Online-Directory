<script setup>
    import BreezeInput from '@/Components/Input.vue';
    import BreezeTextarea from '@/Components/Textarea.vue';
</script>
<template>
    <div class="container mx-auto mb-5 px-3 md:px-2 lg:px-0">
        <h2 class="font-bold text-3xl mb-5">Contact Us
            <span class="font-normal text-sm ml-2">If you have any questions, please feel free to message us.</span>
        </h2>
        <div class="flex flex-col md:flex-row lg:flex-row gap-3">
            <div class="w-full md:w-2/5">
                <BreezeInput id="name" type="text" placeholder="Name" class="block w-full rounded-none mb-4 h-14" required  />
                <BreezeInput id="email" type="email" placeholder="Name" class="block w-full rounded-none h-14" required  />
            </div>
            <div class="w-full md:w-2/5">
                <BreezeTextarea id="message" class="block w-full rounded-none mb-4 h-full" rows="4" placeholder="Name" required></BreezeTextarea>
            </div>
            <div class="w-full md:w-1/5">
                <button class="bg-gray-300 hover:bg-gray-500 outline outline-1 outline-gray-400 text-gray-700 hover:text-gray-100 text-sm w-full py-3 uppercase">Submit</button>
            </div>
        </div>
    </div>
</template>
