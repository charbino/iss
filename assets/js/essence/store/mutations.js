import * as type from './types'


/**
 *
 * @param state
 * @param data
 */
const setData = (state, data) => {
    state.data = data;
};


export default {
    [type.MUTATE_SET_DATA](state, data) {
        setData(state, data)
    },
    [type.MUTATE_SET_DATA_BY_RAYON_ACTION](state, data) {
        let rayonAction = state.rayonAction;

        var dataFilter = data.filter((item) => {

            let latPt = state.pa.latitude;
            let longPt = state.pa.longitude;

            let itemLat = parseInt(item["@attributes"].latitude) / 100000;
            let itemLong = parseInt(item["@attributes"].longitude) / 100000;

            let checkLatitude = (latPt - rayonAction / 111) < itemLat && itemLat < (latPt + rayonAction / 111);
            let checkLong = (longPt - rayonAction / 76) < itemLong && itemLong < (longPt + rayonAction / 76);

            return checkLatitude && checkLong;
        });
        setData(state, dataFilter)
    },
    [type.MUTATE_SET_RAYON_ACTION](state, rayon) {
        state.rayonAction = rayon;
        //TODO UPDATE DATA CARD
        // state.commit(type.MUTATE_SET_DATA_BY_RAYON_ACTION)
    }
}
