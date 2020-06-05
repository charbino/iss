<template>
    <div>
        <article class="media">
            <l-map style="height: 600px; width: 100%" :zoom="zoom" :center="center" v-on:ready="invalid">
                <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
                <l-marker v-for="marker in getMarker()" :lat-lng="marker.latLng" v-bind:key="marker.id">
                    <l-popup>{{marker.msg}}</l-popup>
                </l-marker>
            </l-map>
        </article>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import * as types from '../store/types'
    import Result from './Result'
    import * as Vue2Leaflet from 'vue2-leaflet'

    var {LMap, LTileLayer, LMarker, LPopup} = Vue2Leaflet;

    export default {
        name: 'Map',
        components: {
            Result,
            LMap,
            LTileLayer,
            LMarker,
            LPopup
        },
        data() {
            return {
                zoom: 13,
                center: this.getPointCenter(),
                url: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
                markerCentral: this.getPointCenter(),
            }
        },
        mounted() {
            setTimeout(function() { window.dispatchEvent(new Event('resize')) }, 250);

        },
        methods: {

            ...mapGetters({
                getPdvByRayonAction: types.GET_PDV_BY_RAYON_ACTION,
                getRayonAction: types.GET_RAYON_ACTION,
                getPriceByTypeEssence: types.GET_PRICE_BY_TYPE_ESSENCE,
                getLatPoint: types.GET_LAT_POINT_ACTION,
                getLongPoint: types.GET_LONG_POINT_ACTION
            }),
            getMarker() {
                let result = [];
                let pdv = this.getPdvByRayonAction()();
                let count = 1;
                pdv.forEach(e => {
                    result.push({
                        id: count,
                        latLng: L.latLng(e["@attributes"].latitude / 100000, e["@attributes"].longitude / 100000),
                        msg: this.getTootltip(e)
                    });
                    count++;
                });
                return result;
            },
            getTootltip(e) {
                if (e.prix) {
                    var prix = this.getPriceByTypeEssence()(e.prix, "E10");
                    if (prix) {
                        return e.adresse + ' - ' + e.ville + ' - ' + prix["@attributes"].nom + ' : ' + prix["@attributes"].valeur + ' €';
                    }
                }
                return e.adresse + ' - ' + e.ville;
            },
            getPointCenter() {
                return L.latLng(this.getLatPoint()(), this.getLongPoint()());
            },
            invalid(map){
                map.invalidateSize();
                setTimeout(() => {
                    map.invalidateSize();
                }, 300);
            }
        }
    }
</script>

<style>

</style>
