import Vue from 'vue'
import Vuex from 'vuex'


Vue.use(Vuex);

const ROUTE_ISS_GET_POSTION = 'iss_position';
import * as types from './types'


/**
 *
 * @type {Store<{data: Array}>}
 */
export const store = new Vuex.Store({
    state: {
        marker: {},
        pa: {
            name: 'Albertville',
            longitude: 6.3925417,
            latitude: 45.6754622,
        },
    },
    mutations: {
        [types.MUTATE_SET_MARKER](state, marker) {
            setMarker(state, marker)
        },
    },
    actions: {
        [types.LOAD_MARKER]: ({commit}) => {
            // loadMarker({commit})
            return new Promise((resolve, reject) => {
                loadMarker({commit,resolve});

            })
        },
    },
    getters: {
        [types.GET_LAT_POINT_ACTION]: (state) => () => {
            return state.pa.latitude;
        },
        [types.GET_LONG_POINT_ACTION]: (state) => () => {
            return state.pa.longitude;
        },
        [types.GET_ALTITUDE]: (state) => () => {
            return state.marker.altitude;
        },
        [types.GET_DATE]: (state) => () => {
            return state.marker.dateTime;
        },
        [types.GET_LONGITUDE]: (state) => () => {
            return state.marker.longitude;
        },
        [types.GET_LATIITUDE]: (state) => () => {
            return state.marker.latitude;
        },
        [types.GET_SPEED]: (state) => () => {
            return state.marker.vitesse;
        },
        [types.GET_VISIBILITY]: (state) => () => {
            return state.marker.visibility;
        },
        [types.GET_UNITS]: (state) => () => {
            return state.marker.units;
        }
    }
});


const loadMarker = ({commit,resolve}) => {

    fetch(Routing.generate(ROUTE_ISS_GET_POSTION), {
        method: 'GET',
    })
        .then(r => r.json())
        .then(data => {
            commit(types.MUTATE_SET_MARKER, data);
            resolve();
        })
};

/**
 *
 * @param state
 * @param marker
 */
const setMarker = (state, marker) => {
    state.marker = marker;
};



