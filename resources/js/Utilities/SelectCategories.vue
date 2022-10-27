<script setup>
    import Multiselect from '@vueform/multiselect'
    import { onMounted, reactive, ref } from 'vue';

    // init for multiselect model
    let categoryModel = ref([])
    let categoryData = ref([])

    // component is required to accept the categories masterlist via props
    const props = defineProps({
            existingCat: {
                type: Object
            }
        })

    onMounted(() => {
        categoryModel.value = props.existingCat
        getAllCategories()
    })

    const emit = defineEmits(['selectedCategories'])

    const onSelect = async (value) => {
        await emit('selectedCategories', categoryModel)
    }

    // get all the categories
    function getAllCategories()
    {
        axios.get(route('allCategories.api'))
            .then((response) => {
                categoryData.value = response.data
            })
            .catch((error) => {
                console.log(error)
            })
    }

</script>
<template>
    <Multiselect
        v-model="categoryModel"
        mode="tags"
        @input="onSelect"
        :object=true
        value-prop="slug"
        :close-on-select="false"
        placeholder="Select category"
        track-by="name"
        label="name"
        :options="categoryData">
        <template v-slot:tag="{ option, handleTagRemove, disabled }">
            <div class="multiselect-tag is-user" :class="{ 'is-disabled': disabled }">
                {{ option.name }}
                <span v-if="!disabled" class="multiselect-tag-remove" @mousedown.prevent="handleTagRemove(option, $event)">
                    <span class="multiselect-tag-remove-icon"></span>
                </span>
            </div>
        </template>
    </Multiselect>
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
