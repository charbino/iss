import('../../scss/essence.scss');

import Vue from 'vue'
import Essence from './components/Essence'
import VueResource from 'vue-resource';

import {store} from './store/store';


import Buefy from 'buefy'
import 'buefy/dist/buefy.css'

import {Icon} from 'leaflet'

delete Icon.Default.prototype._getIconUrl;
Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png')
});

Vue.config.productionTip = false;
Vue.use(VueResource);
Vue.use(Buefy);


/* eslint-disable no-new */
new Vue({
    el: '#app-essence',
    store: store,
    components: {Essence},
    template: '<Essence/>'
})
