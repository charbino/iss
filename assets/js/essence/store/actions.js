//Action

import * as types from './types'

const loadData = ({commit}, data) => {

        const {pdv} = data;
        if (pdv) {
                // commit(types.MUTATE_SET_DATA, pdv.slice(0, 5000));
                // commit(types.MUTATE_SET_DATA, pdv);
            commit(types.MUTATE_SET_DATA_BY_RAYON_ACTION, pdv);
        }
}

export default {
    [types.LOAD_DATA]: ({commit}, data) => {
        loadData({commit}, data)
    },
}
