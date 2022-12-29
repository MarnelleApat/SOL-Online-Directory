export default {
    namespaced: true,

    state: {
        customer: [],
        cart: (localStorage.getItem("cart") !== null) ? JSON.parse(localStorage.getItem("cart")) : [],
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
            const str = state.cart.find(d => d.id === payload.id)
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
        ADD_TO_CART(state, item) {
            item.discount = null
            item.promo_id = null
            state.cart.push(item)
            localStorage.setItem("cart", JSON.stringify(state.cart))
        },
        REMOVE_ITEM(state, payload) {
            state.cart = payload
            localStorage.setItem("cart", JSON.stringify(state.cart))
        },
        EMPTY_CART(state) {
            localStorage.removeItem("cart")
        }
    }

}
