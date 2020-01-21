import Vue from 'vue';
import VueRouter from 'vue-router';
import Welcome from "./components/Welcome";
import CarsCreate from "./views/CarsCreate";
import CarsShow from "./views/CarsShow";
import CarsEdit from "./views/CarsEdit";
import CarsIndex from "./views/CarsIndex";
import BirthdaysIndex from "./views/BirthdaysIndex";
import Logout from "./Actions/Logout";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: '/', component: Welcome,
            meta: { title: 'Welcome' }
        }, {
            path: '/cars', component: CarsIndex,
            meta: { title: 'Car' }
        }, {
            path: '/cars/create', component: CarsCreate,
            meta: { title: 'Add New Car' }
        }, {
            path: '/cars/:id', component: CarsShow,
            meta: { title: 'Details for Car' }
        }, {
            path: '/cars/:id/edit', component: CarsEdit,
            meta: { title: 'Edit Car' }
        }, {
            path: '/birthdays', component: BirthdaysIndex,
            meta: { title: 'This Month\'s Races' }
        }, {
            path: '/logout', component: Logout
        }
    ],
    mode: 'history'
});
