<template>
    <section class="section">
        <div class="container">
            <h1 class="title is-1">Essence</h1>
            <nav class="level">
                <div class="level-left">
                    <div class="level-item">
                        <p class="subtitle is-5">
                            <strong>{{this.getNbPdvSelected()()}}</strong> points
                        </p>
                    </div>
                    <div class="level-item">
                        <div class="field has-addons">
                            <p class="control">
                                <input class="input" type="text" placeholder="Find a city">
                            </p>
                            <p class="control">
                                <button class="button">
                                    Search
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="level-item has-text-centered">
                    <div>
                        <p class="heading">Ville</p>
                        <p class="title">{{this.getPointActionName()()}}</p>
                    </div>
                </div>
                <div class="level-item has-text-centered">
                    <div class="container-rayon-action">
                        <p class="heading">Rayon</p>
                        <p class="title">{{rayonAction}} km</p>
                        <p>
                            <b-field>
                                <b-slider size="is-large" :value="rayonAction" v-model="rayonAction">
                                </b-slider>
                            </b-field>
                        </p>
                    </div>
                    <div>

                    </div>

                </div>
            </nav>

            <b-tabs size="is-large" class="block" v-model="activeTab">
                <b-tab-item label="Tableau" icon="table-large">
                    <Result
                            :data="getPdvByRayonAction()()">
                    </Result>
                </b-tab-item>
                <b-tab-item label="Carte" icon="map-marker">
                    <Map>
                    </Map>
                </b-tab-item>
            </b-tabs>


        </div>
    </section>
</template>

<script>

    import Result from './Result'
    import Map from './Map'

    import * as types from '../store/types'
    import {mapActions, mapGetters} from 'vuex'
    import {getData} from '../helper';

    export default {
        name: 'Essence',
        components: {
            Result,
            Map,

        },
        data() {
            return {
                city: '',
                activeTab: 0,
                pathImport: '',
            }
        },
        created() {
            var data = getData(this);
            this.loadData(data);
        },
        computed: {
            rayonAction: {
                get() {
                    return this.getRayonAction()();
                },
                set(value) {
                    this.$store.commit(types.MUTATE_SET_RAYON_ACTION, value)
                }
            }
        },
        methods: {
            ...mapActions({
                loadData: types.LOAD_DATA,
            }),
            ...mapGetters({
                getPdvByCity: types.GET_PDV_BY_CITY,
                getPdvByRayonAction: types.GET_PDV_BY_RAYON_ACTION,
                getNbPdvSelected: types.GET_NB_PDV_SELECTED,
                getRayonAction: types.GET_RAYON_ACTION,
                getPointActionName: types.GET_POINT_ACTION_NAME,
                getPointActionLat: types.GET_LAT_POINT_ACTION,
                getPointActionLong: types.GET_LONG_POINT_ACTION,
            }),

        }
    }
</script>

