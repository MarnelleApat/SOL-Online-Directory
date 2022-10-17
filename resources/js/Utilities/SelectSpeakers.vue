<script setup>
    import Multiselect from '@vueform/multiselect'
    import { ref } from 'vue';

    // init for multiselect model
    const value = []

    let previewSpeaker = ref([])

    // create custom event
    const emit = defineEmits(['selectedSpeakers'])

    // component is required to accept the categories masterlist via props
    const props = defineProps({
        speakers: {
            type: Object,
            required: true
        }
    })

    const speakersData = async () => {
        return await props.speakers
    }

    const onSelect = async (value) => {
        previewSpeaker.value = await value
        await emit('selectedSpeakers', value)
    }

</script>

<template>
    <Multiselect
        v-model="value"
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
        :options="speakersData">
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
        <div class="flex flex-col justify-center items-center" v-for="speaker in previewSpeaker">
            <img :src="speaker.profileImg" class="rounded-full h-20 mb-2" />
            <p class="font-bold text-gray-500 text-md">{{ speaker.name }}</p>
        </div>
    </div>
    <!-- {{previewSpeaker[0]}} -->
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



