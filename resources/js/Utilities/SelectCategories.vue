<script setup>
    import Multiselect from '@vueform/multiselect'
    import { onMounted, reactive, ref } from 'vue';

    // init for multiselect model
    let categoryModel = ref(props.existingCat)
    let categoryData = ref([])

    // component is required to accept the categories masterlist via props
    const props = defineProps({
            existingCat: {
                type: Object
            }
        })

    onMounted(() => {
        getAllCategories()
    })

    const emit = defineEmits(['selectedCategories'])

    const onSelect = async (dataToEmit) => {
        await emit('selectedCategories', dataToEmit)
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
    <!-- <pre>{{props.existingCat}}</pre> -->
</template>

<style src="@vueform/multiselect/themes/default.css"></style>

<style>
    .multiselect {
        background: #fff;
        color: #2c2a2a;
        border: 1px solid rgba(156, 163, 175, 1);
        border-radius: 0px;
    }
    .multiselect-tag.is-user {
        padding: 5px 8px 5px 10px;
        border-radius: 22px;
        background: #5e5435;
        margin: 3px 3px 8px;
    }

    .multiselect-tag.is-user img {
        width: 18px;
        border-radius: 50%;
        height: 18px;
        margin-right: 8px;
        border: 2px solid #fff;
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
