<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    class: {
        type: String,
        default: 'bg-gray-700 border border-transparent text-sm text-white disabled:bg-gray-400 disabled:border-gray-500/60 hover:bg-gray-600 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray'
    }
});
</script>

<template>
    <button :type="type"
        :class="class"
        class="items-center p-4 shadow-lg rounded-none font-semibold uppercase tracking-widest transition ease-in-out duration-150">
        <slot />
    </button>
</template>
