<template>
    <div>
        <Header
                :localistation="localistation"
                :speed="this.getSpeed()()"
                :units="this.getUnits()()"
                :delais="this.getDelaisInSeconde()"
        ></Header>
        <article class="media map">
            <l-map style="height: 600px; width: 100%"
                   :zoom="zoom"
                   :center="center">
                <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
                <l-marker :lat-lng="getMarkerLatLong()" v-if="hasMarker()">

                </l-marker>
            </l-map>
        </article>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
    </div>
</template>

<script>

    import * as Vue2Leaflet from 'vue2-leaflet'
    import * as types from './types';
    import {mapGetters, mapActions} from 'vuex'
    import Header from './Header'

    var {LMap, LTileLayer, LMarker} = Vue2Leaflet;

    export default {
        name: 'Iss',
        components: {
            Header,
            LMap,
            LTileLayer,
            LMarker
        },
        data() {
            return {
                delais: 10000, //10s
                localistation: '',
                speed: 0,
                zoom: 2,
                center: this.getPointCenter(),
                url: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
                markerCentral: this.getPointCenter(),
                isLoading: false,
                isFullPage: false
            }
        },
        created() {
            this.init();
            setInterval(() => {
                this.loadMarker();
            }, this.delais);


        },
        methods: {
            ...mapGetters({
                getLatPoint: types.GET_LAT_POINT_ACTION,
                getLongPoint: types.GET_LONG_POINT_ACTION,
                getAltitude: types.GET_ALTITUDE,
                getDate: types.GET_DATE,
                getLongitude: types.GET_LONGITUDE,
                getLatitude: types.GET_LATIITUDE,
                getSpeed: types.GET_SPEED,
                getVisibility: types.GET_VISIBILITY,
                getUnits: types.GET_UNITS,
            }),
            ...mapActions({
                loadMarker: types.LOAD_MARKER
            }),
            getPointCenter() {
                return L.latLng(this.getLatPoint()(), this.getLongPoint()());
            },
            getMarkerLatLong() {
                if (this.getLatitude()() && this.getLongitude()()) {
                    return L.latLng(this.getLatitude()(), this.getLongitude()());
                }
            },
            hasMarker: function () {
                let lat = this.getLatitude()();
                let long = this.getLongitude()();
                return (typeof lat !== 'undefined' && typeof long !== 'undefined');
            },
            getDelaisInSeconde() {
                return this.delais / 1000;
            },
            async init() {
                this.isLoading = true;
               this.loadMarker().then(() => {
                   this.isLoading = false;
               });
            }
        }
    }
</script>

<style>

</style>
