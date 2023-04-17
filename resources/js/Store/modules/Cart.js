export default {
    namespaced: true,

    state: {
        customer: [],
        cart: localStorage.getItem("cart") ? JSON.parse(localStorage.getItem("cart")) : [],
        // totalCartQuantity: 0,
    },

    getters: {
        cart(state) {
            return state.cart
        },
        // totalCartQuantity(state) {
        //     return state.totalCartQuantity = state.cart!== null ? state.cart.length : 0
        // }
    },

    actions: {
        addToCart({commit, state}, payload) {

            let event = payload.event

            const str = state.cart.find(d => d.programCode === event.programCode)
            if(!str) {
                commit('ADD_TO_CART', payload)
                return true
            }
            else {
                console.log('item already exist in the cart')
                return false
            }
        },
        removeItemFromCart({commit}, payload) {
            commit('REMOVE_ITEM', payload)
            return true
        },
        emptyCart({commit}) {
            commit('EMPTY_CART')
        },
        checkoutCart({commit, state}, payload) {
            if(state.cart.find(d => d.id === payload.id)) {
                return 'exist'
            }
            else {
                commit('ADD_TO_CART', payload)
                return 'not exist'
            }
        }
    },

    mutations: {

        CART(state, payload) {
            state.cart = payload;
        },
        ADD_TO_CART(state, payload) {
            payload.event.discount = null
            payload.event.promo_id = null
            payload.event.registrant = payload.registrant
            state.cart.push(payload.event)
            localStorage.setItem("cart", JSON.stringify(state.cart))
        },
        REMOVE_ITEM(state, payload) {
            state.cart = payload
            localStorage.setItem("cart", JSON.stringify(state.cart))
        },
        EMPTY_CART(state) {
            state.cart = []
            localStorage.removeItem("cart")
        }
    }

}
