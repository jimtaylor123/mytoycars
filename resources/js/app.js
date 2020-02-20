import Vue from 'vue';
import Axios from 'axios';
import Moment from 'moment';
import router from './router';
import App from './components/App';

require('./bootstrap');

Vue.prototype.$http = Axios
Vue.prototype.$moment = Moment

// Leaflet map
import { LMap, LTileLayer, LMarker, fixDefaultIcons } from 'vue2-leaflet';
import 'leaflet/dist/leaflet.css';
fixDefaultIcons();
Vue.component('l-map', LMap);
Vue.component('l-tile-layer', LTileLayer);
Vue.component('l-marker', LMarker);

// Font awesome
import { library } from '@fortawesome/fontawesome-svg-core'
import { faCar, faFlagCheckered, faCalendarAlt, faPlusCircle } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
Vue.component('font-awesome-icon', FontAwesomeIcon);
library.add(faCar, faFlagCheckered, faCalendarAlt, faPlusCircle);


const app = new Vue({
    el: '#app',
    components: {
        App,
    },
    router
});
