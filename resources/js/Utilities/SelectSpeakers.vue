<script setup>
    import Multiselect from '@vueform/multiselect'
    import spinner from '@/Utilities/Spinner.vue'
    import { onMounted, ref } from 'vue';

    // init for multiselect model
    const speakerModel = ref(props.existingSpeakers)

    let allSpeakers = ref([])

    // create custom event
    const emit = defineEmits(['selectedSpeakers'])

    // component is required to accept the categories masterlist via props
    const props = defineProps({
            existingSpeakers: {
                type: Object,
            }
        })

    onMounted(() => {
        getAllSpeakers()
    })

    const onSelect = async (dataToEmit) => {
        await emit('selectedSpeakers', dataToEmit)
    }

    // get all the speakers
    function getAllSpeakers()
    {
        axios.get(route('allSpeakers.api'))
            .then((response) => {
                allSpeakers.value = response.data
            })
            .catch((error) => {
                console.log(error)
            })
    }


</script>

<template>
    <Multiselect
        v-model="speakerModel"
        mode="tags"
        @input="onSelect"
        :object=true
        value-prop="slug"
        :close-on-select="false"
        :searchable="true"
        placeholder="Search speaker/trainor"
        track-by="name"
        label="name"
        class="ms-speaker"
        :options="allSpeakers">
        <template v-slot:tag="{ option, handleTagRemove, disabled }">
            <div class="multiselect-tag is-user" :class="{ 'is-disabled': disabled }">
                <img :src="option.profileImg">{{ option.name }}
                <span v-if="!disabled" class="multiselect-tag-remove" @mousedown.prevent="handleTagRemove(option, $event)">
                    <span class="multiselect-tag-remove-icon"></span>
                </span>
            </div>
        </template>
    </Multiselect>
    <br />
    <div class="grid grid-cols-5 gap-3">
        <div class="flex flex-col justify-center items-center" v-for="speaker in speakerModel">
            <img v-if="speaker.profileImg" :src="speaker.profileImg" class="rounded-full h-20 mb-2" />
            <spinner v-else></spinner>
            <p class="font-bold text-gray-500 text-md">{{ speaker.name }}</p>
        </div>
    </div>
</template>

<style src="@vueform/multiselect/themes/default.css"></style>
<style>
  .multiselect-tag.is-user {
    padding: 5px 8px;
    border-radius: 22px;
    background: #35495e;
    margin: 3px 3px 8px;
  }

  .multiselect-tag.is-user img {
    width: 18px;
    border-radius: 50%;
    height: 18px;
    margin-right: 8px;
    border: 1px solid #ffffffbf;
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



