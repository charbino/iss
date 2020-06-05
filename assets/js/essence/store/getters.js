//Action

import * as types from './types'

/**
 *
 * @param state
 * @param cityName
 */
const getPdvByCity = (state, cityName) => {

    return state.data.filter((item) => {

        return item.ville[0].toLowerCase() === cityName.toLowerCase()
    });
};

/**
 *
 * @param state
 * @param rayonAction
 */
const getPdvByRayonAction = (state, rayonAction) => {

    //calcul
    return state.data.filter((item) => {

        let latPt = state.pa.latitude;
        let longPt = state.pa.longitude;

        let itemLat = parseInt(item["@attributes"].latitude) / 100000;
        let itemLong = parseInt(item["@attributes"].longitude) / 100000;

        let checkLatitude = (latPt - rayonAction / 111) < itemLat && itemLat < (latPt + rayonAction / 111);
        let checkLong = (longPt - rayonAction / 76) < itemLong && itemLong < (longPt + rayonAction / 76);

        return checkLatitude && checkLong;
    });
};

export default {
    [types.GET_PDV_BY_CITY]: (state) => (cityName) => {
        return getPdvByCity(state, cityName);
    },
    [types.GET_PDV_BY_RAYON_ACTION]: (state) => () => {
        return getPdvByRayonAction(state, state.rayonAction);
    },
    [types.GET_PRICE_BY_TYPE_ESSENCE]: (state) => (prices, typeEssence) => {
        if (!prices) {
            return null;
        }
        if(!Array.isArray(prices)){
            return null;
        }
        return prices.find(e => {
            return e["@attributes"].nom === typeEssence;
        })
    },
    [types.GET_NB_PDV_SELECTED]: (state) => () => {
        return state.data.length;
    },
    [types.GET_RAYON_ACTION]: (state) => () => {
        return state.rayonAction;
    },
    [types.GET_POINT_ACTION_NAME]: (state) => () => {
        return state.pa.name;
    },
    [types.GET_LAT_POINT_ACTION]: (state) => () => {
        return state.pa.latitude;
    },
    [types.GET_LONG_POINT_ACTION]: (state) => () => {
        return state.pa.longitude;
    },
}
