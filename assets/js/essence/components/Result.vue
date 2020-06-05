<template>

    <div>
        <div class="field is-grouped">
            <p class="control ">Afficher : </p>
            <p class="control">
                <b-switch :value="E10Active"
                          v-model="E10Active"
                          type="is-info">
                    E10
                </b-switch>
            </p>
            <p class="control">
                <b-switch :value="GazoleActive"
                          v-model="GazoleActive"
                          type="is-info">
                    Gazole
                </b-switch>
            </p>
            <p class="control">
                <b-switch :value="SP98Active"
                          v-model="SP98Active"
                          type="is-info">
                    SP98
                </b-switch>
            </p>
            <p class="control">
                <b-switch :value="SP95Active"
                          v-model="SP95Active"
                          type="is-info">
                    SP95
                </b-switch>
            </p>
            <p class="control">
                <b-switch :value="GPLcActive"
                          v-model="GPLcActive"
                          type="is-info">
                    GPLc
                </b-switch>
            </p>
            <p class="control">
                <b-switch :value="E85Active"
                          v-model="E85Active"
                          type="is-info">
                    E85
                </b-switch>
            </p>
        </div>
        <b-table
                :data="data"
                :paginated="isPaginated"
                hoverable
                striped
                :default-sort-direction="defaultSortDirection"
                :sort-icon="sortIcon"
                :sort-icon-size="sortIconSize"
                default-sort="index">

            <template slot-scope="props">
                <b-table-column field="id" label="ID" width="40" sortable numeric>
                    {{ props.index }}
                </b-table-column>

                <b-table-column field="ville" label="Ville" sortable>
                    {{ props.row.ville }}
                </b-table-column>

                <b-table-column field="address" label="Adresse" sortable>
                    {{ props.row.adresse }}
                </b-table-column>

                <b-table-column field="prix" label="Prix" sortable :custom-sort="sortPrice">

                    <template slot="header" slot-scope="{ column }">
                        <b-tooltip :label="explicationPrix" dashed>
                            {{ column.label }}
                        </b-tooltip>
                    </template>

                    <!--                    {{ props.row.prix }}-->
                    <li v-for="prix in props.row.prix" v-if="typeEssenceActive(prix)">
                        <span>{{getLabelPrice(prix) }}</span>
                        - &nbsp; <span>{{getPriceValeur(prix) | price}}</span>
                        <b-tooltip :label="getLabelMaj(prix)"
                                   position="is-bottom"
                                   animated>
                                <span class="icon has-text-info">
                                  <i class="fas fa-info-circle"></i>
                                </span>
                        </b-tooltip>
                    </li>
                </b-table-column>
            </template>
        </b-table>


    </div>
</template>

<script>

    import moment from 'moment'

    export default {
        name: 'Result',
        props: {
            data: Array
        },
        data() {
            return {
                GazoleActive: false,
                E10Active: true,
                SP98Active: false,
                SP95Active: false,
                GPLcActive: false,
                E85Active: false,
                isPaginated: false,
                isPaginationSimple: false,
                paginationPosition: 'bottom',
                defaultSortDirection: 'asc',
                sortIcon: 'chevron-up',
                sortIconSize: 'is-medium',
                explicationPrix: "Pour le tri sur le prix, on utilise la moyenne des prix affichés"
            }
        },
        methods: {
            typeEssenceActive(prix) {
                if(!prix["@attributes"]){
                    return false;
                }
                let essenceType = prix["@attributes"].nom;
                let variable = essenceType + 'Active';

                return this.$data[variable];
            },
            getLabelPrice(prix) {
                return prix["@attributes"].nom;
            },
            getPriceValeur(prix) {
                return prix["@attributes"].valeur;
            },
            getLabelMaj(prix) {
                let dateMaj = prix['@attributes'].maj;
                return "maj : " + moment(dateMaj).format('Do MMMM YYYY');
            },
            displayLine(item) {
                if (!item.prix) {
                    return false;
                }
                var res = item.prix.filter(e => {
                    return this.typeEssenceActive(e);
                });
                return res.length > 0;
            },
            sortPrice(a, b, isAsc) {
                var averageA = this.getAveragePdvDisplay(a.prix);
                var averageB = this.getAveragePdvDisplay(b.prix);

                if (isAsc) {
                    return averageA >= averageB
                } else {
                    return averageA < averageB
                }
            },
            getAveragePdvDisplay(prices) {
                if(!Array.isArray(prices)){
                    return 100;
                }

                var filtered = prices.filter(item => {
                    let essenceType = item["@attributes"].nom;
                    let variable = essenceType + 'Active';

                    return this.$data[variable];
                });

                if (filtered.length === 0) {
                    return 100;
                }
                var sum = filtered.reduce((a, b) => {
                    return parseFloat(a) + parseFloat(b["@attributes"].valeur);
                }, 0.0);

                return sum / filtered.length;
            }
        },
        filters: {
            price(valeur) {
                return valeur + '  €'
            },
            dateformat: function (value) {
                return moment(value).format('Do MMMM YYYY');
            },
            titlecase: function (value) {
                return value.replace(
                    /\w\S*/g,
                    function (txt) {
                        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                    });
            }
        }
    }
</script>

