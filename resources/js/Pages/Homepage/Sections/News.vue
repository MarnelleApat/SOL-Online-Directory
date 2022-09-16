<script setup>
    import SectionHeader from '@/Pages/Homepage/Sections/SectionHeader.vue';

    defineProps({
        categoryName: {
            type: String,
        },
        postTags: {
            type: Array,
            default: ['Singapore', 'Asia', 'World']
        }
    })

</script>

<template>
    <div class="container mx-auto">
        <SectionHeader :categoryName=this.categoryName />
    </div>
</template>
