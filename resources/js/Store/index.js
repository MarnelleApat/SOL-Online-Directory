import { createApp } from 'vue';

import { createStore } from 'vuex';

const store = createStore({
        state() {
            return {
                selectedCategories: [],
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
        },
        actions: {
            storeSelectedCat({ commit }, payload) {
                commit('GET_SELECTED_CATEGORIES', payload)
            },
        }
    })

export default store
