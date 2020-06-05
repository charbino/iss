<template>
    <div class="form">
        <div class="field is-horizontal">

            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <button class="button" @click="city='Oyonnax'">Test</button>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <input class="input" v-model="city" placeholder="Edit me : Oyonnax for exemple">
                    </div>
                </div>
            </div>
        </div>
        <Result
                v-if="city"
                :data="getPdvByCity()(city)"
        >
        </Result>
    </div>
</template>

<script>

    import Result from './Result'

    import * as types from '../store/types'
    import {mapActions, mapGetters} from 'vuex'

    export default {
        name: 'ModalEssence',
        components:{
            Result
        },
        data() {
            return {
                city: ''
            }
        },
        methods: {
            ...mapGetters({
                getPdvByCity: types.GET_PDV_BY_CITY
            }),
        }
    }
</script>

<style>

</style>
