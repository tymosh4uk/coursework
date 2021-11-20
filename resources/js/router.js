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


const router = new vueRouter({
    mode: "history",
    routes: [
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
            component: CreateReceipt,
            meta: {auth: true}
        },
        {
            path: '/app',
            component: App
        },
        {
            path: '/recepty',
            component: AllReceipt
        }


    ]
})

router.beforeEach(async (to, from, next) => {
    var currentUser;

    const requireAuth = to.matched.some(record => record.meta.auth)
    await axios.get('/currentId')
        .then(res => {
        console.log(res.data);
            currentUser = res.data;


        }).catch((error) => {
            this.showErrors(error.response.data.error)
        });

    console.log(requireAuth);
    console.log(currentUser);

    if (requireAuth && !currentUser) {

        next(window.location.href = '/login')


    } else {
        next()
    }
})


export default router
