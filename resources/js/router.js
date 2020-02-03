import Vue from 'vue';

// In
import VueRouter from 'vue-router';
import Welcome from "./components/Welcome";

// Cars
import CarsCreate from "./views/cars/CarsCreate";
import CarsShow from "./views/cars/CarsShow";
import CarsEdit from "./views/cars/CarsEdit";
import CarsIndex from "./views/cars/CarsIndex";

// Races
import RacesIndex from "./views/races/RacesIndex";
import RacesCreate from "./views/races/RacesCreate";
import RacesShow from "./views/races/RacesShow";
import RacesEdit from "./views/races/RacesEdit";

// Out
import Logout from "./Actions/Logout";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        // In
        {
            path: '/', component: Welcome,
            meta: { title: 'Welcome' }
        },
        // Cars
        {
            path: '/cars', component: CarsIndex,
            meta: { title: 'Car' }
        },
        {
            path: '/cars/create', component: CarsCreate,
            meta: { title: 'Add New Car' }
        },
        {
            path: '/cars/:id(\\d+)', component: CarsShow,
            meta: { title: 'Details for Car' }
        }, {
            path: '/cars/:id/edit', component: CarsEdit,
            meta: { title: 'Edit Car' }
        },
        // Races
        {
            path: '/races/create', component: RacesCreate,
            meta: { title: 'Add New Race' }
        },

        {
            path: '/races/:id(\\d+)', component: RacesShow,
            meta: { title: 'Details for Race' }
        },
        {
            path: '/races/:id(\\d+)/edit', component: RacesEdit,
            meta: { title: 'Edit Race' }
        },
        {
            path: '/races/past', component: RacesIndex,
            meta: { title: 'Races' , time: 'past'}
        },
        {
            path: '/races/upcoming', component: RacesIndex,
            meta: { title: 'Races', time: 'upcoming' }
        },
        // Out
        {
            path: '/logout', component: Logout
        }
    ],
    mode: 'history'
});
