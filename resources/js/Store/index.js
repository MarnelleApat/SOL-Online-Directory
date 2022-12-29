
import { createStore } from 'vuex';

import Cart from './modules/Cart';

export default createStore({
    modules:{
        cart: Cart,
    }
})
