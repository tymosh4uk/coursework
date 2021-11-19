import vueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(vueRouter);

import Index from "./views/Index";
import Blog from "./views/Blog";
import Receipt from "./views/Receipt";
import CreateKitchen from "./views/CreateKitchen";
import CreateReceipt from "./views/CreateReceipt";
import App from "./views/App";
import AllReceipt from "./views/AllReceipt";
import paginate from 'vuejs-paginate'
Vue.component('Paginate', paginate)


const routes = [
    {
        path: '/',
        component: Index
    },
    {
        path: '/blog',
        component: Blog
    },
    {
        path: '/receipt/:id',
        component: Receipt
    },
    {
        path: '/create',
        component: CreateKitchen
    },
    {
        path: '/createReceipt',
        component: CreateReceipt
    },
    {
        path: '/app',
        component: App
    },
    {
        path: '/recepty',
        component: AllReceipt
    }


];

export default new vueRouter({
    mode: "history",
    routes: routes
});
