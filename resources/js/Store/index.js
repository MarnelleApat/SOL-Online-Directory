import { createApp } from 'vue';

import { createStore } from 'vuex';

const store = createStore({
        state() {
            return {
                selectedCategories: [],
                selectedBannerImg: [],
                selectedPhotoImg: []
            }
        },
        getters: {
            getSelectedCategories(state) {
                return state.selectedCategories
            },

        },
        mutations:{
            GET_SELECTED_CATEGORIES(state, payload) {
                state.selectedCategories = payload
            },
            GET_SELECTED_IMAGE(state, payload) {
                if(payload.img_type === 'banner')
                    state.selectedBannerImg = payload.selectedPhoto
                else if(payload.img_type === 'photo')
                    state.selectedPhotoImg = payload.selectedPhoto
                else
                    state.selectedPhotoImg = payload.selectedPhoto
            }
        },
        actions: {
            storeSelectedCat({ commit }, payload) {
                commit('GET_SELECTED_CATEGORIES', payload)
            },
            storeSelectedImage({ commit }, payload) {
                commit('GET_SELECTED_IMAGE', payload)
            },

        }
    })

export default store
