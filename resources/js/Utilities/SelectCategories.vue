<script setup>
    import Multiselect from '@vueform/multiselect'

    // init for vuex and assign to store variable
    import { useStore } from 'vuex'
    const store = useStore()

    // init for multiselect model
    const value = []

    // declare loading state
    let isLoading = false

    // component is required to accept the categories masterlist via props
    defineProps({
        categories: {
            type: Object,
            required: true
        }
    })

    // dispatch the vuex action 'storeSelectedCat' to get the final category selected and passed to the parent component
    const onSelect = async (value) => {
        isLoading = true
        await store.dispatch('storeSelectedCat', value)
        isLoading = false
    }

</script>
<template>
    <div class="bg-white shadow-sm border ring-opacity-75">
        <div class="flex flex-col p-5">
            <p class="text-gray-400 font-bold my-3">Categories:</p>

            <Multiselect
                v-model="value"
                mode="tags"
                @input="onSelect"
                :object=true
                :loading="isLoading"
                value-prop="slug"
                :close-on-select="false"
                placeholder="Select category"
                track-by="name"
                label="name"
                :options="categories">
                <template v-slot:tag="{ option, handleTagRemove, disabled }">
                    <div class="multiselect-tag is-user" :class="{ 'is-disabled': disabled }">
                        {{ option.name }}
                        <span v-if="!disabled" class="multiselect-tag-remove" @mousedown.prevent="handleTagRemove(option, $event)">
                            <span class="multiselect-tag-remove-icon"></span>
                        </span>
                    </div>
                </template>
            </Multiselect>

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

    .multiselect-clear {
        position: absolute !important;
        right: 7px !important;
        top: 10px;
    }
    .multiselect-caret {
        position: absolute !important;
        right: -10px !important;
        top: 10px;
    }
</style>
