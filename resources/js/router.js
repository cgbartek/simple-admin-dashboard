import Vue from 'vue';
import VueRouter from 'vue-router';

/**
 * Top level route components.
 */
const Dashboard = () => import('./components/Dashboard');
const Domains = () => import('./components/Domains');
const AddDomain = () => import('./components/AddDomain');
const Settings = () => import('./components/Settings');

/**
 * Register router with vue.
 */
Vue.use(VueRouter);

/**
 * Create vue router and register top level routes.
 */
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'dashhboard',
            component: Dashboard
        },
        {
            path: '/domains',
            name: 'domains',
            component: Domains
        },
        {
            path: '/domains/add',
            name: 'add-domain',
            component: AddDomain
        },
        {
            path: '/settings',
            name: 'settings',
            component: Settings
        }
    ]
});

export default router;

