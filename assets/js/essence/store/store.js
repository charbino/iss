import Vue from 'vue'
import Vuex from 'vuex'
import actions from './actions'
import mutations from './mutations'
import getters from './getters'


Vue.use(Vuex);

/**
 *
 * @type {Store<{data: Array}>}
 */
export const store = new Vuex.Store({
    state: {
        data: [],
        rayonAction: 20,
        pa: {
            name: 'Albertville',
            longitude: 6.3925417,
            latitude: 45.6754622,
        },
    },
    mutations: mutations,
    actions: actions,
    getters: getters
});
