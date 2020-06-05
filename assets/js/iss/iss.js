import('../../scss/iss.scss');


import Vue from 'vue'
import VueResource from 'vue-resource';
import {store} from './store';

import {Icon} from 'leaflet'

delete Icon.Default.prototype._getIconUrl;

Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png')
});

import Buefy from 'buefy'
import 'buefy/dist/buefy.css'

Vue.config.productionTip = false;
Vue.use(VueResource);
Vue.use(Buefy);

import Iss from './Iss'
/* eslint-disable no-new */
new Vue({
    el: '#app-iss',
    components: {Iss},
    store: store,
    template: '<Iss/>'
})


