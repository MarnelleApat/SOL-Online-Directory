<script setup>
    import Multiselect from '@vueform/multiselect'
    import { ref } from 'vue';

    defineProps({
        categories: Object
    })

    const options = ref(null);
    let value = ref(null);

</script>
<template>
    <div class="bg-white shadow-sm border ring-opacity-75">
        <div class="flex flex-col p-5">
            <p class="text-gray-400 font-bold my-3">Categories:</p>

<Multiselect
v-model="value"
mode="tags"
label="name"
track-by="name"
:options="categories"
/>
<pre>{{categories}}</pre>
<!--
            <Multiselect v-model="value" mode="tags" placeholder="Select category" track-by="name" label="name" :close-on-select="false" :search="true" :options="options">
                <template v-slot:tag="{ option, handleTagRemove, disabled }">
                    <div class="multiselect-tag is-user" :class="{ 'is-disabled': disabled }">
                    {{ option.name }}
                    <span v-if="!disabled" class="multiselect-tag-remove" @mousedown.prevent="handleTagRemove(option, $event)">
                        <span class="multiselect-tag-remove-icon"></span>
                    </span>
                    </div>
                </template>
            </Multiselect>
            <pre>{{options}}</pre>
-->
        </div>
    </div>
</template>

<style src="@vueform/multiselect/themes/default.css"></style>

<style>
    .multiselect-tag.is-user {
        padding: 5px 8px 5px 10px;
        border-radius: 22px;
        background: #35495e;
        margin: 3px 3px 8px;
    }

    .multiselect-tag.is-user img {
        width: 18px;
        border-radius: 50%;
        height: 18px;
        margin-right: 8px;
        border: 2px solid #ffffffbf;
    }

    .multiselect-tag.is-user i:before {
        color: #ffffff;
        border-radius: 50%;;
    }

    .user-image {
        margin: 0 6px 0 0;
        border-radius: 50%;
        height: 22px;
    }
</style>
